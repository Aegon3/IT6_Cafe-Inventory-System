@extends('layouts.app')
@section('title', 'Adjust Stock')

@section('content')
<div class="card">
    <div class="card-title">Adjust Stock &mdash; {{ $stock->product->product_name }}</div>
    <form method="POST" action="{{ route('stocks.update', $stock->stock_ID) }}">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label>Product</label>
                <input type="text" value="{{ $stock->product->product_name }}" disabled>
            </div>
            <div class="form-group">
                <label>Unit</label>
                <input type="text" value="{{ $stock->product->p_unit }}" disabled>
            </div>
            <div class="form-group">
                <label>Quantity</label>
                <input type="number" name="quantity" min="0" value="{{ old('quantity', $stock->quantity) }}" required>
            </div>
            <div class="form-group">
                <label>Minimum Stock Level</label>
                <input type="number" name="min_stock" min="0" value="{{ old('min_stock', $stock->min_stock) }}" required>
            </div>
            <div class="form-group">
                <label>Unit Price (PHP)</label>
                <input type="number" name="unit_price" step="0.01" min="0" value="{{ old('unit_price', $stock->product->unit_price) }}" required>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Stock</button>
            <a href="{{ route('stocks.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection