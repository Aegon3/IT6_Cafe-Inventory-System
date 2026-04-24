<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            ['employee_ID'=>'E001','employee_Fname'=>'Maria','employee_Lname'=>'Dampog','e_role'=>'Admin'],
            ['employee_ID'=>'E002','employee_Fname'=>'Juan','employee_Lname'=>'Santos','e_role'=>'Staff'],
            ['employee_ID'=>'E003','employee_Fname'=>'Ana','employee_Lname'=>'Reyes','e_role'=>'Cashier'],
        ];
        foreach ($employees as $e) {
            DB::table('employees')->insertOrIgnore(array_merge($e, ['created_at'=>now(),'updated_at'=>now()]));
        }

        // Prices based on realistic Philippine wholesale/retail market rates (PHP)
        $products = [
            ['product_ID'=>'P001','product_name'=>'Coffee Bean','p_unit'=>'kg',   'unit_price'=>650.00],  // Arabica/Robusta blend per kg
            ['product_ID'=>'P002','product_name'=>'Heavy Cream', 'p_unit'=>'L',   'unit_price'=>280.00],  // per liter
            ['product_ID'=>'P003','product_name'=>'Butter',      'p_unit'=>'pcs', 'unit_price'=>95.00],   // 225g block
            ['product_ID'=>'P004','product_name'=>'Onion',       'p_unit'=>'kg',  'unit_price'=>80.00],   // red/white onion per kg
            ['product_ID'=>'P005','product_name'=>'Garlic',      'p_unit'=>'kg',  'unit_price'=>160.00],  // per kg
            ['product_ID'=>'P006','product_name'=>'Chicken',     'p_unit'=>'kg',  'unit_price'=>200.00],  // dressed chicken per kg
            ['product_ID'=>'P007','product_name'=>'Potato',      'p_unit'=>'kg',  'unit_price'=>75.00],   // per kg
            ['product_ID'=>'P008','product_name'=>'Bread Loaf',  'p_unit'=>'pcs', 'unit_price'=>65.00],   // standard loaf
            ['product_ID'=>'P009','product_name'=>'Fries',       'p_unit'=>'pack','unit_price'=>185.00],  // 2kg frozen pack
            ['product_ID'=>'P010','product_name'=>'Chips',       'p_unit'=>'pack','unit_price'=>55.00],   // snack-size bag
            ['product_ID'=>'P011','product_name'=>'Sugar',       'p_unit'=>'kg',  'unit_price'=>70.00],   // refined white sugar per kg
            ['product_ID'=>'P012','product_name'=>'Oil',         'p_unit'=>'L',   'unit_price'=>95.00],   // cooking oil per liter
            ['product_ID'=>'P013','product_name'=>'Rice',        'p_unit'=>'kg',  'unit_price'=>55.00],   // well-milled rice per kg
            ['product_ID'=>'P014','product_name'=>'Flour',       'p_unit'=>'kg',  'unit_price'=>52.00],   // all-purpose flour per kg
        ];

        $quantities  = [50, 30, 40, 100, 80, 60, 120, 25, 45, 70, 55, 35, 90, 65];
        $minStocks   = [20, 15, 15,  30, 20, 25,  30, 10, 20, 20, 20, 15, 30, 20];

        foreach ($products as $i => $p) {
            DB::table('products')->insertOrIgnore(array_merge($p, ['created_at'=>now(),'updated_at'=>now()]));
            DB::table('stocks')->insertOrIgnore([
                'stock_ID'   => 'ST' . str_pad($i + 1, 3, '0', STR_PAD_LEFT),
                'product_ID' => $p['product_ID'],
                'quantity'   => $quantities[$i],
                'min_stock'  => $minStocks[$i],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}