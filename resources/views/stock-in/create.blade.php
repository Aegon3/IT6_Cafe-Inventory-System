@extends('layouts.app')
@section('title', 'Record Stock-In')

@section('content')
<div class="card">
    <div class="card-title">Record Stock-In</div>

    <form method="POST" action="{{ route('stock-in.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>Date</label>
                <input type="date" name="date_added" value="{{ old('date_added', date('Y-m-d')) }}" required>
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

        <div class="card-title" style="margin-top:20px">Items Received</div>
        <div id="detail-rows">
            <div class="detail-row" style="display:block;border-bottom:1px dashed var(--border);padding-bottom:14px;margin-bottom:14px">
                <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px">
                    <span style="font-size:.78rem;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);font-weight:600">Product Type:</span>
                    <label style="display:flex;align-items:center;gap:5px;font-size:.85rem;cursor:pointer">
                        <input type="radio" name="product_type[0]" value="existing" checked onchange="toggleType(this,0)"> Existing
                    </label>
                    <label style="display:flex;align-items:center;gap:5px;font-size:.85rem;cursor:pointer">
                        <input type="radio" name="product_type[0]" value="new" onchange="toggleType(this,0)"> New Product
                    </label>
                    <button type="button" class="remove-row" onclick="removeRow(this)" style="margin-left:auto">✕</button>
                </div>

                {{-- Existing product --}}
                <div class="existing-section" id="existing-0">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Stock ID</label>
                            <input type="text" id="existing_stock_id_0" readonly
                                style="background:var(--bg-muted,#f5f5f5);color:var(--muted);cursor:not-allowed"
                                placeholder="Auto-filled">
                        </div>
                        <div class="form-group">
                            <label>Product</label>
                            <select name="product_ID[0]" onchange="fillExisting(this, 0)">
                                <option value="">Select product...</option>
                                @foreach($products as $p)
                                <option value="{{ $p->product_ID }}"
                                    data-price="{{ $p->unit_price }}"
                                    data-stock="{{ $stockMap[$p->product_ID]->stock_ID ?? '' }}">
                                    {{ $p->product_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" name="existing_quantity[0]" min="1" placeholder="0">
                        </div>
                        <div class="form-group">
                            <label>Cost/Unit (PHP)</label>
                            <input type="number" name="existing_cost[0]" id="existing_cost_0" step="0.01" min="0" placeholder="Auto-filled">
                        </div>
                    </div>
                </div>

                {{-- New product --}}
                <div class="new-section" id="new-0" style="display:none">
                    <div class="form-grid">
                        <div class="form-group">
                            <label>Stock ID</label>
                            <input type="text" readonly value="(auto-assigned)"
                                style="background:var(--bg-muted,#f5f5f5);color:var(--muted);cursor:not-allowed">
                        </div>
                        <div class="form-group">
                            <label>Product Name</label>
                            <input type="text" name="new_product_name[0]" placeholder="e.g. Arabica Beans">
                        </div>
                        <div class="form-group">
                            <label>Unit</label>
                            <input type="text" name="new_product_unit[0]" placeholder="e.g. kg, pcs, box">
                        </div>
                        <div class="form-group">
                            <label>Unit Price (PHP)</label>
                            <input type="number" name="new_unit_price[0]" step="0.01" min="0" placeholder="0.00">
                        </div>
                        <div class="form-group">
                            <label>Quantity</label>
                            <input type="number" name="new_quantity[0]" min="1" placeholder="0">
                        </div>
                        <div class="form-group">
                            <label>Cost/Unit (PHP)</label>
                            <input type="number" name="new_cost[0]" step="0.01" min="0" placeholder="0.00">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <button type="button" class="add-row-btn" onclick="addRow()">+ Add Another Item</button>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Stock-In</button>
            <a href="{{ route('stock-in.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>

<script>
let rowCount = 1;

const priceMap = {
    @foreach($products as $p)
    "{{ $p->product_ID }}": {{ $p->unit_price }},
    @endforeach
};

const stockIDMap = {
    @foreach($products as $p)
    "{{ $p->product_ID }}": "{{ $stockMap[$p->product_ID]->stock_ID ?? '' }}",
    @endforeach
};

const existingOpts = `@foreach($products as $p)<option value="{{ $p->product_ID }}" data-price="{{ $p->unit_price }}" data-stock="{{ $stockMap[$p->product_ID]->stock_ID ?? '' }}">{{ $p->product_name }}</option>@endforeach`;

function fillExisting(selectEl, idx) {
    const pid          = selectEl.value;
    const costInput    = document.getElementById('existing_cost_' + idx);
    const stockIDInput = document.getElementById('existing_stock_id_' + idx);
    if (pid) {
        if (priceMap[pid]   !== undefined) costInput.value    = priceMap[pid].toFixed(2);
        if (stockIDMap[pid] !== undefined) stockIDInput.value = stockIDMap[pid];
    } else {
        costInput.value    = '';
        stockIDInput.value = '';
    }
}

function toggleType(radio, idx) {
    const existingEl = document.getElementById('existing-' + idx);
    const newEl      = document.getElementById('new-' + idx);
    if (radio.value === 'existing') {
        existingEl.style.display = '';
        newEl.style.display      = 'none';
    } else {
        existingEl.style.display = 'none';
        newEl.style.display      = '';
    }
}

function addRow() {
    const idx  = rowCount++;
    const wrap = document.getElementById('detail-rows');
    const div  = document.createElement('div');
    div.className     = 'detail-row';
    div.style.cssText = 'display:block;border-bottom:1px dashed var(--border);padding-bottom:14px;margin-bottom:14px';
    div.innerHTML = `
        <div style="display:flex;align-items:center;gap:10px;margin-bottom:10px">
            <span style="font-size:.78rem;text-transform:uppercase;letter-spacing:.07em;color:var(--muted);font-weight:600">Product Type:</span>
            <label style="display:flex;align-items:center;gap:5px;font-size:.85rem;cursor:pointer">
                <input type="radio" name="product_type[${idx}]" value="existing" checked onchange="toggleType(this,${idx})"> Existing
            </label>
            <label style="display:flex;align-items:center;gap:5px;font-size:.85rem;cursor:pointer">
                <input type="radio" name="product_type[${idx}]" value="new" onchange="toggleType(this,${idx})"> New Product
            </label>
            <button type="button" class="remove-row" onclick="removeRow(this)" style="margin-left:auto">✕</button>
        </div>

        <div class="existing-section" id="existing-${idx}">
            <div class="form-grid">
                <div class="form-group">
                    <label>Stock ID</label>
                    <input type="text" id="existing_stock_id_${idx}" readonly
                        style="background:var(--bg-muted,#f5f5f5);color:var(--muted);cursor:not-allowed"
                        placeholder="Auto-filled">
                </div>
                <div class="form-group">
                    <label>Product</label>
                    <select name="product_ID[${idx}]" onchange="fillExisting(this, ${idx})">
                        <option value="">Select product...</option>${existingOpts}
                    </select>
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="existing_quantity[${idx}]" min="1" placeholder="0">
                </div>
                <div class="form-group">
                    <label>Cost/Unit (PHP)</label>
                    <input type="number" name="existing_cost[${idx}]" id="existing_cost_${idx}" step="0.01" min="0" placeholder="Auto-filled">
                </div>
            </div>
        </div>

        <div class="new-section" id="new-${idx}" style="display:none">
            <div class="form-grid">
                <div class="form-group">
                    <label>Stock ID</label>
                    <input type="text" readonly value="(auto-assigned)"
                        style="background:var(--bg-muted,#f5f5f5);color:var(--muted);cursor:not-allowed">
                </div>
                <div class="form-group">
                    <label>Product Name</label>
                    <input type="text" name="new_product_name[${idx}]" placeholder="e.g. Arabica Beans">
                </div>
                <div class="form-group">
                    <label>Unit</label>
                    <input type="text" name="new_product_unit[${idx}]" placeholder="e.g. kg, pcs, box">
                </div>
                <div class="form-group">
                    <label>Unit Price (PHP)</label>
                    <input type="number" name="new_unit_price[${idx}]" step="0.01" min="0" placeholder="0.00">
                </div>
                <div class="form-group">
                    <label>Quantity</label>
                    <input type="number" name="new_quantity[${idx}]" min="1" placeholder="0">
                </div>
                <div class="form-group">
                    <label>Cost/Unit (PHP)</label>
                    <input type="number" name="new_cost[${idx}]" step="0.01" min="0" placeholder="0.00">
                </div>
            </div>
        </div>`;
    wrap.appendChild(div);
}

function removeRow(btn) {
    if (document.querySelectorAll('.detail-row').length > 1)
        btn.closest('.detail-row').remove();
}
</script>
@endsection