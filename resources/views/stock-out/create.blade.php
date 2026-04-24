@extends('layouts.app')
@section('title', 'Record Stock-Out')

@section('content')
<div class="card">
    <div class="card-title">Record Stock-Out</div>
    <form method="POST" action="{{ route('stock-out.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Date of Issuance</label>
                <input type="date" name="date_issuance" value="{{ old('date_issuance', date('Y-m-d')) }}" required>
            </div>
            <div class="form-group">
                <label>Handled By</label>
                <select name="employee_ID" required>
                    <option value="">Select employee...</option>
                    @foreach($employees as $e)
                    <option value="{{ $e->employee_ID }}" {{ old('employee_ID') == $e->employee_ID ? 'selected' : '' }}>
                        {{ $e->employee_Fname }} {{ $e->employee_Lname }} ({{ $e->e_role }})
                    </option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="card-title" style="margin-top:20px">Items Issued</div>
        <div id="detail-rows">
            <div class="detail-row-so">
                <div class="form-group">
                    <label>Product</label>
                    <select name="product_ID[]" required>
                        <option value="">Select product...</option>
                        @foreach($products as $p)
                        <option value="{{ $p->product_ID }}">
                            {{ $p->product_name }} (Stock: {{ $p->stock->quantity ?? 0 }})
                        </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="quantity[]" min="1" required>
                </div>
                <div style="padding-top:22px">
                    <button type="button" class="remove-row" onclick="removeRow(this)">x</button>
                </div>
            </div>
        </div>
        <button type="button" class="add-row-btn" onclick="addRow()">+ Add Another Item</button>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Stock-Out</button>
            <a href="{{ route('stock-out.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
const opts = `@foreach($products as $p)<option value="{{ $p->product_ID }}">{{ $p->product_name }} (Stock: {{ $p->stock->quantity ?? 0 }})</option>@endforeach`;

function addRow() {
    const wrap = document.getElementById('detail-rows');
    const div = document.createElement('div');
    div.className = 'detail-row-so';
    div.innerHTML = `
        <div class="form-group"><label>Product</label>
        <select name="product_ID[]" required><option value="">Select product...</option>${opts}</select></div>
        <div class="form-group"><label>Quantity</label><input type="number" name="quantity[]" min="1" required></div>
        <div style="padding-top:22px"><button type="button" class="remove-row" onclick="removeRow(this)">x</button></div>`;
    wrap.appendChild(div);
}
function removeRow(btn) {
    if (document.querySelectorAll('.detail-row-so').length > 1)
        btn.closest('.detail-row-so').remove();
}
</script>
@endsection
