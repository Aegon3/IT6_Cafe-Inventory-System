@extends('layouts.app')
@section('title', 'Stock In Report')

@section('content')
<div class="card">
    <div class="card-title">Stock In Report</div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Stock In ID</th>
                    <th>Date Added</th>
                    <th>Handled By</th>
                    <th>Role</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Unit</th>
                    <th>Quantity</th>
                    <th>Cost/Unit</th>
                    <th>Total Cost</th>
                </tr>
            </thead>
            <tbody>
            @forelse($records as $r)
            <tr>
                <td>{{ $r->stockin_ID }}</td>
                <td>{{ $r->date_added }}</td>
                <td>{{ $r->handled_by }}</td>
                <td>{{ $r->e_role }}</td>
                <td>{{ $r->product_ID }}</td>
                <td>{{ $r->product_name }}</td>
                <td>{{ $r->p_unit }}</td>
                <td>{{ $r->quantity }}</td>
                <td>PHP {{ number_format($r->cost_per_unit, 2) }}</td>
                <td>PHP {{ number_format($r->total_cost, 2) }}</td>
            </tr>
            @empty
            <tr><td colspan="10" style="color:var(--muted)">No records found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
