@extends('layouts.app')
@section('title', 'Products')

@section('content')
<div class="card">
    <div class="card-title">All Products</div>
    <div style="margin-bottom:14px">
        <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
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
            <tr><td colspan="5" style="color:var(--muted)">No products found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
