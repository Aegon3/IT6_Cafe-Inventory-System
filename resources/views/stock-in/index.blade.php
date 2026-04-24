@extends('layouts.app')
@section('title', 'Stock In')

@section('content')
<div class="card">
    <div class="card-title">Stock-In Records</div>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;gap:10px">
        <a href="{{ route('stock-in.create') }}" class="btn btn-primary">Record Stock-In</a>
        <form method="GET" action="{{ route('stock-in.index') }}" style="display:flex;gap:8px">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by ID, date, employee..." style="padding:7px 10px;border:1px solid var(--border);border-radius:3px;font-size:.85rem;background:var(--bg);color:var(--text);width:260px">
            <button type="submit" class="btn btn-secondary">Search</button>
            @if(request('search'))
                <a href="{{ route('stock-in.index') }}" class="btn btn-secondary">Clear</a>
            @endif
        </form>
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
                    <a href="{{ route('stock-in.edit', $r->stockin_ID) }}" class="btn btn-secondary btn-sm">Edit</a>
                    <form method="POST" action="{{ route('stock-in.destroy', $r->stockin_ID) }}" style="display:inline" onsubmit="return confirm('Delete and reverse stock levels?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="5" style="color:var(--muted)">{{ request('search') ? 'No records matched your search.' : 'No records yet.' }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection