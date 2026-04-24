@extends('layouts.app')
@section('title', 'Edit Product')

@section('content')
<div class="card">
    <div class="card-title">Edit Product — {{ $product->product_ID }}</div>
    <form method="POST" action="{{ route('products.update', $product->product_ID) }}">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="product_name" value="{{ old('product_name', $product->product_name) }}" required>
            </div>
            <div class="form-group">
                <label>Unit</label>
                <input type="text" name="p_unit" value="{{ old('p_unit', $product->p_unit) }}" required>
            </div>
            <div class="form-group">
                <label>Unit Price (PHP)</label>
                <input type="number" name="unit_price" step="0.01" min="0" value="{{ old('unit_price', $product->unit_price) }}" required>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
