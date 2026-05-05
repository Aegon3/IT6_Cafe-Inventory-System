<?php

namespace App\Http\Controllers;

use App\Models\StockIn;
use App\Models\StockInDetail;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockInController extends Controller
{
    private function nextID(): string
    {
        $last = StockIn::orderByDesc('stockin_ID')->value('stockin_ID');
        $n = $last ? ((int) substr($last, 2)) + 1 : 1;
        return 'SI' . str_pad($n, 4, '0', STR_PAD_LEFT);
    }

    private function nextDetailID(): string
    {
        $last = StockInDetail::orderByDesc('stockin_details_ID')->value('stockin_details_ID');
        $n = $last ? ((int) substr($last, 3)) + 1 : 1;
        return 'SID' . str_pad($n, 4, '0', STR_PAD_LEFT);
    }

    private function nextProductID(): string
    {
        $last = Product::orderByDesc('product_ID')->value('product_ID');
        $n = $last ? ((int) substr($last, 1)) + 1 : 1;
        return 'P' . str_pad($n, 3, '0', STR_PAD_LEFT);
    }

    private function nextStockID(): string
    {
        $last = Stock::orderByDesc('stock_ID')->value('stock_ID');
        $n = $last ? ((int) substr($last, 2)) + 1 : 1;
        return 'ST' . str_pad($n, 3, '0', STR_PAD_LEFT);
    }

    public function index(Request $request)
    {
        $query = StockIn::with(['employee', 'details'])->orderByDesc('date_added');
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('stockin_ID', 'like', "%$s%")
                  ->orWhere('date_added', 'like', "%$s%")
                  ->orWhereHas('employee', fn($eq) =>
                      $eq->where('employee_Fname', 'like', "%$s%")
                         ->orWhere('employee_Lname', 'like', "%$s%")
                  );
            });
        }
        $records = $query->get();
        return view('stock-in.index', compact('records'));
    }

    public function create()
    {
        $employees = Employee::orderBy('employee_Fname')->get();
        $products  = Product::orderBy('product_name')->get();
        $stockMap  = Stock::all()->keyBy('product_ID');
        return view('stock-in.create', compact('employees', 'products', 'stockMap'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_added'   => 'required|date',
            'employee_ID'  => 'required|exists:employees,employee_ID',
            'product_type' => 'required|array|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $stockIn = StockIn::create([
                'stockin_ID'  => $this->nextID(),
                'date_added'  => $request->date_added,
                'employee_ID' => $request->employee_ID,
            ]);

            foreach ($request->product_type as $i => $type) {
                if ($type === 'new') {
                    $productID = $this->nextProductID();
                    Product::create([
                        'product_ID'   => $productID,
                        'product_name' => $request->new_product_name[$i],
                        'p_unit'       => $request->new_product_unit[$i],
                        'unit_price'   => $request->new_unit_price[$i],
                    ]);
                    Stock::create([
                        'stock_ID'   => $this->nextStockID(),
                        'product_ID' => $productID,
                        'quantity'   => $request->new_quantity[$i],
                    ]);
                    $pid  = $productID;
                    $qty  = $request->new_quantity[$i];
                    $cost = $request->new_cost[$i];
                } else {
                    $pid  = $request->product_ID[$i];
                    $qty  = $request->existing_quantity[$i];
                    $cost = $request->existing_cost[$i];
                    Stock::where('product_ID', $pid)->increment('quantity', $qty);
                }

                StockInDetail::create([
                    'stockin_details_ID' => $this->nextDetailID(),
                    'stockin_ID'         => $stockIn->stockin_ID,
                    'product_ID'         => $pid,
                    'quantity'           => $qty,
                    'cost_per_unit'      => $cost,
                ]);
            }
        });

        return redirect()->route('stock-in.index')->with('success', 'Stock-In recorded.');
    }

    public function show(StockIn $stockIn)
    {
        $stockIn->load(['employee', 'details.product.stockRecord']);
        return view('stock-in.show', compact('stockIn'));
    }

    public function edit(StockIn $stockIn)
    {
        $stockIn->load(['employee', 'details.product']);
        $employees = Employee::orderBy('employee_Fname')->get();
        return view('stock-in.edit', compact('stockIn', 'employees'));
    }

    public function update(Request $request, StockIn $stockIn)
    {
        $request->validate([
            'date_added'      => 'required|date',
            'employee_ID'     => 'required|exists:employees,employee_ID',
            'detail_id'       => 'required|array',
            'quantity'        => 'required|array',
            'quantity.*'      => 'required|integer|min:1',
            'cost_per_unit'   => 'required|array',
            'cost_per_unit.*' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request, $stockIn) {
            foreach ($stockIn->details as $d) {
                Stock::where('product_ID', $d->product_ID)->decrement('quantity', $d->quantity);
            }
            $stockIn->update([
                'date_added'  => $request->date_added,
                'employee_ID' => $request->employee_ID,
            ]);
            foreach ($request->detail_id as $i => $detailId) {
                $detail = StockInDetail::find($detailId);
                if ($detail) {
                    $detail->update([
                        'quantity'      => $request->quantity[$i],
                        'cost_per_unit' => $request->cost_per_unit[$i],
                    ]);
                    Stock::where('product_ID', $detail->product_ID)
                         ->increment('quantity', $request->quantity[$i]);
                }
            }
        });

        return redirect()->route('stock-in.show', $stockIn->stockin_ID)->with('success', 'Stock-In updated.');
    }

    public function destroy(StockIn $stockIn)
    {
        DB::transaction(function () use ($stockIn) {
            foreach ($stockIn->details as $d) {
                Stock::where('product_ID', $d->product_ID)->decrement('quantity', $d->quantity);
            }
            $stockIn->delete();
        });
        return redirect()->route('stock-in.index')->with('success', 'Stock-In deleted and stock reversed.');
    }
}