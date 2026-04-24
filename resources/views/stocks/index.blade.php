@extends('layouts.app')
@section('title', 'Current Stock')

@section('content')
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-label">Products Tracked</div>
        <div class="stat-value">{{ $stocks->count() }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Total Inventory Value</div>
        <div class="stat-value" style="font-size:1.15rem">PHP {{ number_format($totalValue, 2) }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Low Stock Items</div>
        <div class="stat-value" style="color:var(--danger)">{{ $lowCount }}</div>
    </div>
</div>

<div class="card">
    <div class="card-title">Current Stock Levels</div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Stock ID</th>
                    <th>Product</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Min. Stock</th>
                    <th>Unit Price</th>
                    <th>Total Value</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @forelse($stocks as $s)
            <tr>
                <td>{{ $s->stock_ID }}</td>
                <td>{{ $s->product->product_name }}</td>
                <td>{{ $s->product->p_unit }}</td>
                <td><strong>{{ $s->quantity }}</strong></td>
                <td>{{ $s->min_stock }}</td>
                <td>PHP {{ number_format($s->product->unit_price, 2) }}</td>
                <td>PHP {{ number_format($s->quantity * $s->product->unit_price, 2) }}</td>
                <td>
                    @if($s->quantity < $s->min_stock)
                        <span class="badge badge-low">Low Stock</span>
                    @else
                        <span class="badge badge-ok">Normal</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('stocks.edit', $s->stock_ID) }}" class="btn btn-secondary btn-sm">Adjust</a>
                </td>
            </tr>
            @empty
            <tr><td colspan="9" style="color:var(--muted)">No stock records found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection