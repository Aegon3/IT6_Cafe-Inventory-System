@extends('layouts.app')
@section('title', 'Products')

@section('content')
<div class="card">
    <div class="card-title">All Products</div>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;gap:10px">
        <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
        <form method="GET" action="{{ route('products.index') }}" style="display:flex;gap:8px">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, ID, unit..." style="padding:7px 10px;border:1px solid var(--border);border-radius:3px;font-size:.85rem;background:var(--bg);color:var(--text);width:260px">
            <button type="submit" class="btn btn-secondary">Search</button>
            @if(request('search'))
                <a href="{{ route('products.index') }}" class="btn btn-secondary">Clear</a>
            @endif
        </form>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>ID</th><th>Product Name</th><th>Unit</th><th>Unit Price</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @forelse($products as $p)
            <tr>
                <td>{{ $p->product_ID }}</td>
                <td>{{ $p->product_name }}</td>
                <td>{{ $p->p_unit }}</td>
                <td>PHP {{ number_format($p->unit_price, 2) }}</td>
                <td>
                    <a href="{{ route('products.edit', $p->product_ID) }}" class="btn btn-secondary btn-sm">Edit</a>
                    <form method="POST" action="{{ route('products.destroy', $p->product_ID) }}" style="display:inline" onsubmit="return confirm('Delete this product?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="color:var(--muted)">{{ request('search') ? 'No products matched your search.' : 'No products found.' }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection