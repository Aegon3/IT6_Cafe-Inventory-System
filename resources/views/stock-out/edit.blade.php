@extends('layouts.app')
@section('title', 'Edit Stock-Out')

@section('content')
<div class="card">
    <div class="card-title">Edit Stock-Out &mdash; {{ $stockOut->stockout_ID }}</div>
    <form method="POST" action="{{ route('stock-out.update', $stockOut->stockout_ID) }}">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date_issuance" value="{{ old('date_issuance', $stockOut->date_issuance) }}" required>
            </div>
            <div class="form-group">
                <label>Handled By</label>
                <select name="employee_ID" required>
                    <option value="">Select employee...</option>
                    @foreach($employees as $e)
                    <option value="{{ $e->employee_ID }}" {{ $stockOut->employee_ID == $e->employee_ID ? 'selected' : '' }}>
                        {{ $e->employee_Fname }} {{ $e->employee_Lname }} ({{ $e->e_role }})
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-title" style="margin-top:20px">Items</div>
        @foreach($stockOut->details as $i => $d)
        <div style="border:1px solid var(--border);border-radius:4px;padding:14px;margin-bottom:12px">
            <div style="font-size:.78rem;color:var(--muted);margin-bottom:8px;text-transform:uppercase;letter-spacing:.07em">Item {{ $i + 1 }} — {{ $d->product->product_name }}</div>
            <input type="hidden" name="detail_id[]" value="{{ $d->stockout_details_ID }}">
            <input type="hidden" name="product_ID[]" value="{{ $d->product_ID }}">
            <div class="form-grid">
                <div class="form-group">
                    <label>Product</label>
                    <input type="text" value="{{ $d->product->product_name }}" disabled>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="quantity[]" min="1" value="{{ old('quantity.'.$i, $d->quantity) }}" required>
                </div>
            </div>
        </div>
        @endforeach

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="{{ route('stock-out.show', $stockOut->stockout_ID) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection