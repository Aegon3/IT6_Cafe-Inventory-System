<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class StocksController extends Controller
{
    public function index()
    {
        $stocks     = Stock::with('product')->orderBy('stock_ID')->get();
        $totalValue = $stocks->sum(fn($s) => $s->quantity * ($s->product->unit_price ?? 0));
        $lowCount   = $stocks->filter(fn($s) => $s->product && $s->quantity < $s->min_stock)->count();
        return view('stocks.index', compact('stocks', 'totalValue', 'lowCount'));
    }

    public function edit(Stock $stock)
    {
        $stock->load('product');
        return view('stocks.edit', compact('stock'));
    }

    public function update(Request $request, Stock $stock)
    {
        $request->validate([
            'quantity'   => 'required|integer|min:0',
            'min_stock'  => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $stock->update([
            'quantity'  => $request->quantity,
            'min_stock' => $request->min_stock,
        ]);

        $stock->product->update([
            'unit_price' => $request->unit_price,
        ]);

        return redirect()->route('stocks.index')->with('success', 'Stock updated.');
    }
}