<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private function nextID(): string
    {
        $last = Product::orderByDesc('product_ID')->value('product_ID');
        $num  = $last ? ((int) substr($last, 1)) + 1 : 1;
        return 'P' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }

    private function nextStockID(): string
    {
        $last = Stock::orderByDesc('stock_ID')->value('stock_ID');
        $num  = $last ? ((int) substr($last, 2)) + 1 : 1;
        return 'ST' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }

    public function index(Request $request)
    {
        $query = Product::orderBy('product_name');
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('product_name', 'like', "%$s%")
                  ->orWhere('product_ID', 'like', "%$s%")
                  ->orWhere('p_unit', 'like', "%$s%");
            });
        }
        $products = $query->paginate(5)->withQueryString();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'p_unit'       => 'required|string|max:50',
            'unit_price'   => 'required|numeric|min:0',
        ]);

        $id = $this->nextID();
        Product::create(array_merge(['product_ID' => $id], $data));

        Stock::create([
            'stock_ID'   => $this->nextStockID(),
            'product_ID' => $id,
            'quantity'   => 0,
        ]);

        return redirect()->route('products.index')->with('success', 'Product added.');
    }

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'p_unit'       => 'required|string|max:50',
            'unit_price'   => 'required|numeric|min:0',
        ]);
        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }
}