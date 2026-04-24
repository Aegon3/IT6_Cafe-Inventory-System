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
        $n = StockIn::count() + 1;
        return 'SI' . str_pad($n, 4, '0', STR_PAD_LEFT);
    }

    private function nextDetailID(): string
    {
        $n = StockInDetail::count() + 1;
        return 'SID' . str_pad($n, 4, '0', STR_PAD_LEFT);
    }

    private function nextProductID(): string
    {
        $last = Product::orderByDesc('product_ID')->value('product_ID');
        $num  = $last ? ((int) substr($last, 1)) + 1 : 1;
        return 'P' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }

    private function nextStockID(): string
    {
        $n = Stock::count() + 1;
        return 'ST' . str_pad($n, 3, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        $records = StockIn::with(['employee', 'details'])->orderByDesc('date_added')->get();
        return view('stock-in.index', compact('records'));
    }

    public function create()
    {
        $employees = Employee::orderBy('employee_Fname')->get();
        $products  = Product::orderBy('product_name')->get();
        return view('stock-in.create', compact('employees', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_added'   => 'required|date',
            'employee_ID'  => 'required|exists:employees,employee_ID',
            'product_type' => 'required|array|min:1',
        ]);

        $types        = $request->product_type;
        $productIDs   = $request->product_ID ?? [];
        $existingQty  = $request->existing_quantity ?? [];
        $existingCost = $request->existing_cost ?? [];
        $newNames     = $request->new_product_name ?? [];
        $newUnits     = $request->new_product_unit ?? [];
        $newPrices    = $request->new_unit_price ?? [];
        $newQty       = $request->new_quantity ?? [];
        $newCost      = $request->new_cost ?? [];

        foreach ($types as $i => $type) {
            $row = 'Row ' . ($i + 1);
            if ($type === 'existing') {
                if (empty($productIDs[$i]))
                    return back()->withInput()->withErrors(["$row: Please select an existing product."]);
                if (empty($existingQty[$i]) || $existingQty[$i] < 1)
                    return back()->withInput()->withErrors(["$row: Quantity must be at least 1."]);
                if (!isset($existingCost[$i]) || $existingCost[$i] < 0)
                    return back()->withInput()->withErrors(["$row: Cost per unit is required."]);
            } else {
                if (empty($newNames[$i]))
                    return back()->withInput()->withErrors(["$row: New product name is required."]);
                if (empty($newUnits[$i]))
                    return back()->withInput()->withErrors(["$row: Unit is required for new product."]);
                if (!isset($newPrices[$i]) || $newPrices[$i] < 0)
                    return back()->withInput()->withErrors(["$row: Unit price is required for new product."]);
                if (empty($newQty[$i]) || $newQty[$i] < 1)
                    return back()->withInput()->withErrors(["$row: Quantity must be at least 1."]);
                if (!isset($newCost[$i]) || $newCost[$i] < 0)
                    return back()->withInput()->withErrors(["$row: Cost per unit is required."]);
            }
        }

        DB::transaction(function () use ($request, $types, $productIDs, $existingQty, $existingCost, $newNames, $newUnits, $newPrices, $newQty, $newCost) {
            $stockIn = StockIn::create([
                'stockin_ID'  => $this->nextID(),
                'date_added'  => $request->date_added,
                'employee_ID' => $request->employee_ID,
            ]);

            foreach ($types as $i => $type) {
                if ($type === 'new') {
                    $pid = $this->nextProductID();
                    Product::create([
                        'product_ID'   => $pid,
                        'product_name' => $newNames[$i],
                        'p_unit'       => $newUnits[$i],
                        'unit_price'   => $newPrices[$i],
                    ]);
                    Stock::create([
                        'stock_ID'   => $this->nextStockID(),
                        'product_ID' => $pid,
                        'quantity'   => 0,
                        'min_stock'  => 20,
                    ]);
                    $qty  = $newQty[$i];
                    $cost = $newCost[$i];
                } else {
                    $pid  = $productIDs[$i];
                    $qty  = $existingQty[$i];
                    $cost = $existingCost[$i];
                }

                StockInDetail::create([
                    'stockin_details_ID' => $this->nextDetailID(),
                    'stockin_ID'         => $stockIn->stockin_ID,
                    'product_ID'         => $pid,
                    'quantity'           => $qty,
                    'cost_per_unit'      => $cost,
                ]);

                Stock::where('product_ID', $pid)->increment('quantity', $qty);
            }
        });

        return redirect()->route('stock-in.index')->with('success', 'Stock-In recorded.');
    }

    public function show(StockIn $stockIn)
    {
        $stockIn->load(['employee', 'details.product']);
        return view('stock-in.show', compact('stockIn'));
    }

    public function destroy(StockIn $stockIn)
    {
        DB::transaction(function () use ($stockIn) {
            foreach ($stockIn->details as $d) {
                Stock::where('product_ID', $d->product_ID)
                    ->decrement('quantity', $d->quantity);
            }
            $stockIn->delete();
        });
        return redirect()->route('stock-in.index')->with('success', 'Stock-In deleted and stock reversed.');
    }
}