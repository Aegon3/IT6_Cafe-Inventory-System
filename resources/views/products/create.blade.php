@extends('layouts.app')
@section('title', 'Add Product')

@section('content')
<div class="card">
    <div class="card-title">Add Product</div>
    <form method="POST" action="{{ route('products.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Product Name</label>
                <input type="text" name="product_name" value="{{ old('product_name') }}" required>
            </div>
            <div class="form-group">
                <label>Unit</label>
                <input type="text" name="p_unit" placeholder="kg, L, pcs..." value="{{ old('p_unit') }}" required>
            </div>
            <div class="form-group">
                <label>Unit Price (PHP)</label>
                <input type="number" name="unit_price" step="0.01" min="0" value="{{ old('unit_price') }}" required>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Add Product</button>
            <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
