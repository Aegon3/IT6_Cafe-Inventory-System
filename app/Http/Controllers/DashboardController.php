<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Employee;
use App\Models\StockIn;
use App\Models\StockOut;
use App\Models\Stock;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts  = Product::count();
        $totalEmployees = Employee::count();
        $totalStockIn   = StockIn::count();
        $totalStockOut  = StockOut::count();

        $lowStock = Stock::with('product')
            ->where('quantity', '<', 20)
            ->orderBy('quantity')
            ->get();

        $recentStockIn = StockIn::with(['employee','details'])
            ->orderByDesc('date_added')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalProducts','totalEmployees','totalStockIn',
            'totalStockOut','lowStock','recentStockIn'
        ));
    }
}
