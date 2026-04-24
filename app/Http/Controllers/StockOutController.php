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
        $n = StockOut::count() + 1;
        return 'SO' . str_pad($n, 4, '0', STR_PAD_LEFT);
    }
    private function nextDetailID(): string
    {
        $n = StockOutDetail::count() + 1;
        return 'SOD' . str_pad($n, 4, '0', STR_PAD_LEFT);
    }

    public function index()
    {
        $records = StockOut::with(['employee','details'])->orderByDesc('date_issuance')->get();
        return view('stock-out.index', compact('records'));
    }

    public function create()
    {
        $employees = Employee::orderBy('employee_Fname')->get();
        $products  = Product::with('stock')->orderBy('product_name')->get();
        return view('stock-out.create', compact('employees','products'));
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
                'stockout_ID'    => $this->nextID(),
                'date_issuance'  => $request->date_issuance,
                'employee_ID'    => $request->employee_ID,
            ]);

            foreach ($request->product_ID as $i => $pid) {
                StockOutDetail::create([
                    'stockout_details_ID' => $this->nextDetailID(),
                    'stockout_ID'         => $stockOut->stockout_ID,
                    'product_ID'          => $pid,
                    'quantity'            => $request->quantity[$i],
                ]);
                Stock::where('product_ID', $pid)
                    ->decrement('quantity', $request->quantity[$i]);
            }
        });

        return redirect()->route('stock-out.index')->with('success', 'Stock-Out recorded.');
    }

    public function show(StockOut $stockOut)
    {
        $stockOut->load(['employee','details.product']);
        return view('stock-out.show', compact('stockOut'));
    }

    public function destroy(StockOut $stockOut)
    {
        DB::transaction(function () use ($stockOut) {
            foreach ($stockOut->details as $d) {
                Stock::where('product_ID', $d->product_ID)
                    ->increment('quantity', $d->quantity);
            }
            $stockOut->delete();
        });
        return redirect()->route('stock-out.index')->with('success', 'Stock-Out deleted and stock restored.');
    }
}
