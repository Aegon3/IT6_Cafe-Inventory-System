<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function stockSummary()
    {
        $stocks = DB::select('SELECT * FROM view_stock_summary');
        return view('reports.stock-summary', compact('stocks'));
    }

    public function stockInReport()
    {
        $records = DB::select('SELECT * FROM view_stock_in_report');
        return view('reports.stock-in-report', compact('records'));
    }
}
