@extends('layouts.app')
@section('title', 'Stock In')

@section('content')
<div class="card">
    <div class="card-title">Stock-In Records</div>
    <div style="margin-bottom:14px">
        <a href="{{ route('stock-in.create') }}" class="btn btn-primary">Record Stock-In</a>
    </div>
    <div class="table-wrap">
        <table>
            <thead><tr><th>ID</th><th>Date</th><th>Handled By</th><th>Items</th><th>Actions</th></tr></thead>
            <tbody>
            @forelse($records as $r)
            <tr>
                <td>{{ $r->stockin_ID }}</td>
                <td>{{ $r->date_added }}</td>
                <td>{{ $r->employee->full_name }}</td>
                <td>{{ $r->details->count() }} item(s)</td>
                <td>
                    <a href="{{ route('stock-in.show', $r->stockin_ID) }}" class="btn btn-secondary btn-sm">View</a>
                    <form method="POST" action="{{ route('stock-in.destroy', $r->stockin_ID) }}" style="display:inline" onsubmit="return confirm('Delete and reverse stock levels?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="color:var(--muted)">No records yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
