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

    public function index(Request $request)
    {
        $query = StockIn::with(['employee','details'])->orderByDesc('date_added');
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
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
        return view('stock-in.create', compact('employees','products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'date_added'    => 'required|date',
            'employee_ID'   => 'required|exists:employees,employee_ID',
            'product_ID'    => 'required|array|min:1',
            'product_ID.*'  => 'required|exists:products,product_ID',
            'quantity.*'    => 'required|integer|min:1',
            'cost_per_unit.*' => 'required|numeric|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $stockIn = StockIn::create([
                'stockin_ID'  => $this->nextID(),
                'date_added'  => $request->date_added,
                'employee_ID' => $request->employee_ID,
            ]);

            foreach ($request->product_ID as $i => $pid) {
                StockInDetail::create([
                    'stockin_details_ID' => $this->nextDetailID(),
                    'stockin_ID'         => $stockIn->stockin_ID,
                    'product_ID'         => $pid,
                    'quantity'           => $request->quantity[$i],
                    'cost_per_unit'      => $request->cost_per_unit[$i],
                ]);
                Stock::where('product_ID', $pid)
                    ->increment('quantity', $request->quantity[$i]);
            }
        });

        return redirect()->route('stock-in.index')->with('success', 'Stock-In recorded.');
    }

    public function show(StockIn $stockIn)
    {
        $stockIn->load(['employee','details.product']);
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