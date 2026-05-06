@extends('layouts.app')
@section('title', 'Edit Stock-In')

@section('content')
<div class="card">
    <div class="card-title">Edit Stock-In &mdash; {{ $stockIn->stockin_ID }}</div>
    <form method="POST" action="{{ route('stock-in.update', $stockIn->stockin_ID) }}">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date_added" value="{{ old('date_added', $stockIn->date_added) }}" required>
            </div>
            <div class="form-group">
                <label>Handled By</label>
                @if($linkedEmployee)
                    <input type="text" value="{{ $linkedEmployee->employee_Fname }} {{ $linkedEmployee->employee_Lname }} ({{ $linkedEmployee->e_role }})" readonly>
                    <input type="hidden" name="employee_ID" value="{{ $linkedEmployee->employee_ID }}">
                    <span class="auto-filled-note">Auto-filled from your account</span>
                @else
                    <select name="employee_ID" required>
                        <option value="">Select employee...</option>
                        @foreach($employees as $e)
                        <option value="{{ $e->employee_ID }}" {{ $stockIn->employee_ID == $e->employee_ID ? 'selected' : '' }}>
                            {{ $e->employee_Fname }} {{ $e->employee_Lname }} ({{ $e->e_role }})
                        </option>
                        @endforeach
                    </select>
                @endif
            </div>
        </div>

        <div class="card-title" style="margin-top:20px">Items</div>
        @foreach($stockIn->details as $i => $d)
        <div style="border:1px solid var(--border);border-radius:4px;padding:14px;margin-bottom:12px">
            <div style="font-size:.78rem;color:var(--muted);margin-bottom:8px;text-transform:uppercase;letter-spacing:.07em">Item {{ $i + 1 }} — {{ $d->product->product_name }}</div>
            <input type="hidden" name="detail_id[]" value="{{ $d->stockin_details_ID }}">
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
                <div class="form-group">
                    <label>Cost/Unit (PHP)</label>
                    <input type="number" name="cost_per_unit[]" step="0.01" min="0" value="{{ old('cost_per_unit.'.$i, $d->cost_per_unit) }}" required>
                </div>
            </div>
        </div>
        @endforeach

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="{{ route('stock-in.show', $stockIn->stockin_ID) }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection