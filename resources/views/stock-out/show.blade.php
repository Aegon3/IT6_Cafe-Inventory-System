@extends('layouts.app')
@section('title', 'Stock-Out Details')

@section('content')
<div class="card">
    <div class="card-title">Stock-Out Details &mdash; {{ $stockOut->stockout_ID }}</div>
    <p style="font-size:.85rem;color:var(--muted);margin-bottom:16px">
        Date: {{ $stockOut->date_issuance }} &nbsp;|&nbsp; Handled by: {{ $stockOut->employee->full_name }}
    </p>
    <div class="table-wrap">
        <table>
            <thead><tr><th>Detail ID</th><th>Product</th><th>Unit</th><th>Quantity Issued</th></tr></thead>
            <tbody>
            @foreach($stockOut->details as $d)
            <tr>
                <td>{{ $d->stockout_details_ID }}</td>
                <td>{{ $d->product->product_name }}</td>
                <td>{{ $d->product->p_unit }}</td>
                <td>{{ $d->quantity }}</td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="form-actions">
        <a href="{{ route('stock-out.index') }}" class="btn btn-secondary">Back</a>
    </div>
</div>
@endsection
