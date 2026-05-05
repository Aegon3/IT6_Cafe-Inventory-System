@extends('layouts.app')
@section('title', 'Stock Summary Report')

@section('content')
<div class="card">
    <div class="card-title">Stock Summary Report</div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Stock ID</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Unit</th>
                    <th>Unit Price</th>
                    <th>Quantity</th>
                    <th>Min Stock</th>
                    <th>Total Value</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @forelse($stocks as $s)
            <tr>
                <td>{{ $s->stock_ID }}</td>
                <td>{{ $s->product_ID }}</td>
                <td>{{ $s->product_name }}</td>
                <td>{{ $s->p_unit }}</td>
                <td>PHP {{ number_format($s->unit_price, 2) }}</td>
                <td>{{ $s->quantity }}</td>
                <td>{{ $s->min_stock }}</td>
                <td>PHP {{ number_format($s->total_value, 2) }}</td>
                <td>
                    @if($s->stock_status === 'Out of Stock')
                        <span class="badge badge-low">Out of Stock</span>
                    @elseif($s->stock_status === 'Low Stock')
                        <span class="badge badge-low">Low Stock</span>
                    @else
                        <span class="badge badge-ok">OK</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr><td colspan="9" style="color:var(--muted)">No records found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
