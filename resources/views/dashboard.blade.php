@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="stats-row">
    <div class="stat-card">
        <div class="stat-label">Total Products</div>
        <div class="stat-value">{{ $totalProducts }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Employees</div>
        <div class="stat-value">{{ $totalEmployees }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Stock-In Records</div>
        <div class="stat-value">{{ $totalStockIn }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Stock-Out Records</div>
        <div class="stat-value">{{ $totalStockOut }}</div>
    </div>
    <div class="stat-card">
        <div class="stat-label">Low Stock Items</div>
        <div class="stat-value" style="color:var(--danger)">{{ $lowStock->count() }}</div>
    </div>
</div>

@if($lowStock->count())
<div class="card">
    <div class="card-title">Low Stock Alert — Items Below 20 Units</div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Product</th><th>Quantity</th><th>Unit</th><th>Status</th></tr></thead>
            <tbody>
            @foreach($lowStock as $s)
            <tr>
                <td>{{ $s->product->product_name }}</td>
                <td>{{ $s->quantity }}</td>
                <td>{{ $s->product->p_unit }}</td>
                <td><span class="badge badge-low">Low Stock</span></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<div class="card">
    <div class="card-title">Recent Stock-In Transactions</div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>ID</th><th>Date</th><th>Handled By</th><th>Items</th></tr></thead>
            <tbody>
            @forelse($recentStockIn as $r)
            <tr>
                <td>{{ $r->stockin_ID }}</td>
                <td>{{ $r->date_added }}</td>
                <td>{{ $r->employee->full_name }}</td>
                <td>{{ $r->details->count() }} item(s)</td>
            </tr>
            @empty
            <tr><td colspan="4" style="color:var(--muted)">No records yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
