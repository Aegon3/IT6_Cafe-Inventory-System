@extends('layouts.app')
@section('title', 'Stock-In Details')

@section('content')
<div class="card">
    <div class="card-title">Stock-In Details &mdash; {{ $stockIn->stockin_ID }}</div>
    <p style="font-size:.85rem;color:var(--muted);margin-bottom:16px">
        Date: {{ $stockIn->date_added }} &nbsp;|&nbsp; Handled by: {{ $stockIn->employee->full_name }}
    </p>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Detail ID</th>
                    <th>Stock ID</th>
                    <th>Product ID</th>
                    <th>Product</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Cost/Unit</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
            @foreach($stockIn->details as $d)
            <tr>
                <td>{{ $d->stockin_details_ID }}</td>
                <td>{{ $d->product->stockRecord->stock_ID ?? '—' }}</td>
                <td>{{ $d->product_ID }}</td>
                <td>{{ $d->product->product_name }}</td>
                <td>{{ $d->product->p_unit }}</td>
                <td>{{ $d->quantity }}</td>
                <td>PHP {{ number_format($d->cost_per_unit, 2) }}</td>
                <td>PHP {{ number_format($d->quantity * $d->cost_per_unit, 2) }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="form-actions">
        <a href="{{ route('stock-in.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection