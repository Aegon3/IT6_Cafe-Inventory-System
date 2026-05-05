<?php

namespace App\Http\Controllers;

use App\Models\StockOut;
use App\Models\StockOutDetail;
use App\Models\Employee;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockOutController extends Controller
{
    private function nextID(): string
    {
        $last = StockOut::orderByDesc('stockout_ID')->value('stockout_ID');
        $n = $last ? ((int) substr($last, 2)) + 1 : 1;
        return 'SO' . str_pad($n, 4, '0', STR_PAD_LEFT);
    }

    private function nextDetailID(): string
    {
        $last = StockOutDetail::orderByDesc('stockout_details_ID')->value('stockout_details_ID');
        $n = $last ? ((int) substr($last, 3)) + 1 : 1;
        return 'SOD' . str_pad($n, 4, '0', STR_PAD_LEFT);
    }

    public function index(Request $request)
    {
        $query = StockOut::with(['employee', 'details'])->orderByDesc('date_issuance');
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('stockout_ID', 'like', "%$s%")
                  ->orWhere('date_issuance', 'like', "%$s%")
                  ->orWhereHas('employee', fn($eq) =>
                      $eq->where('employee_Fname', 'like', "%$s%")
                         ->orWhere('employee_Lname', 'like', "%$s%")
                  );
            });
        }
        $records = $query->get();
        return view('stock-out.index', compact('records'));
    }

    public function create()
    {
        $employees = Employee::orderBy('employee_Fname')->get();
        $products  = Product::with('stock')->orderBy('product_name')->get();
        return view('stock-out.create', compact('employees', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_issuance' => 'required|date',
            'employee_ID'   => 'required|exists:employees,employee_ID',
            'product_ID'    => 'required|array|min:1',
            'product_ID.*'  => 'required|exists:products,product_ID',
            'quantity.*'    => 'required|integer|min:1',
        ]);

        foreach ($request->product_ID as $i => $pid) {
            $stock = Stock::where('product_ID', $pid)->first();
            if (!$stock || $stock->quantity < $request->quantity[$i]) {
                return back()->withErrors(['quantity' => 'Insufficient stock for one or more items.'])->withInput();
            }
        }

        DB::transaction(function () use ($request) {
            $stockOut = StockOut::create([
                'stockout_ID'   => $this->nextID(),
                'date_issuance' => $request->date_issuance,
                'employee_ID'   => $request->employee_ID,
            ]);

            foreach ($request->product_ID as $i => $pid) {
                StockOutDetail::create([
                    'stockout_details_ID' => $this->nextDetailID(),
                    'stockout_ID'         => $stockOut->stockout_ID,
                    'product_ID'          => $pid,
                    'quantity'            => $request->quantity[$i],
                ]);
                Stock::where('product_ID', $pid)->decrement('quantity', $request->quantity[$i]);
            }
        });

        return redirect()->route('stock-out.index')->with('success', 'Stock-Out recorded.');
    }

    public function show(StockOut $stockOut)
    {
        $stockOut->load(['employee', 'details.product']);
        return view('stock-out.show', compact('stockOut'));
    }

    public function edit(StockOut $stockOut)
    {
        $stockOut->load(['employee', 'details.product']);
        $employees = Employee::orderBy('employee_Fname')->get();
        return view('stock-out.edit', compact('stockOut', 'employees'));
    }

    public function update(Request $request, StockOut $stockOut)
    {
        $request->validate([
            'date_issuance' => 'required|date',
            'employee_ID'   => 'required|exists:employees,employee_ID',
            'detail_id'     => 'required|array',
            'quantity'      => 'required|array',
            'quantity.*'    => 'required|integer|min:1',
        ]);

        foreach ($request->detail_id as $i => $detailId) {
            $detail = StockOutDetail::find($detailId);
            if ($detail) {
                $stock     = Stock::where('product_ID', $detail->product_ID)->first();
                $available = $stock ? $stock->quantity + $detail->quantity : 0;
                if ($request->quantity[$i] > $available) {
                    return back()->withInput()->withErrors(['quantity' => 'Insufficient stock for item ' . ($i + 1) . '.']);
                }
            }
        }

        DB::transaction(function () use ($request, $stockOut) {
            foreach ($stockOut->details as $d) {
                Stock::where('product_ID', $d->product_ID)->increment('quantity', $d->quantity);
            }
            $stockOut->update([
                'date_issuance' => $request->date_issuance,
                'employee_ID'   => $request->employee_ID,
            ]);
            foreach ($request->detail_id as $i => $detailId) {
                $detail = StockOutDetail::find($detailId);
                if ($detail) {
                    $detail->update(['quantity' => $request->quantity[$i]]);
                    Stock::where('product_ID', $detail->product_ID)->decrement('quantity', $request->quantity[$i]);
                }
            }
        });

        return redirect()->route('stock-out.show', $stockOut->stockout_ID)->with('success', 'Stock-Out updated.');
    }

    public function destroy(StockOut $stockOut)
    {
        DB::transaction(function () use ($stockOut) {
            foreach ($stockOut->details as $d) {
                Stock::where('product_ID', $d->product_ID)->increment('quantity', $d->quantity);
            }
            $stockOut->delete();
        });
        return redirect()->route('stock-out.index')->with('success', 'Stock-Out deleted and stock restored.');
    }
}