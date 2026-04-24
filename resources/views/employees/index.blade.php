@extends('layouts.app')
@section('title', 'Employees')

@section('content')
<div class="card">
    <div class="card-title">All Employees</div>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:14px;gap:10px">
        <a href="{{ route('employees.create') }}" class="btn btn-primary">Add Employee</a>
        <form method="GET" action="{{ route('employees.index') }}" style="display:flex;gap:8px">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, ID, role..." style="padding:7px 10px;border:1px solid var(--border);border-radius:3px;font-size:.85rem;background:var(--bg);color:var(--text);width:260px">
            <button type="submit" class="btn btn-secondary">Search</button>
            @if(request('search'))
                <a href="{{ route('employees.index') }}" class="btn btn-secondary">Clear</a>
            @endif
        </form>
    </div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr><th>ID</th><th>Full Name</th><th>Role</th><th>Actions</th></tr>
            </thead>
            <tbody>
            @forelse($employees as $e)
            <tr>
                <td>{{ $e->employee_ID }}</td>
                <td>{{ $e->employee_Fname }} {{ $e->employee_Lname }}</td>
                <td>{{ $e->e_role }}</td>
                <td>
                    <a href="{{ route('employees.edit', $e->employee_ID) }}" class="btn btn-secondary btn-sm">Edit</a>
                    <form method="POST" action="{{ route('employees.destroy', $e->employee_ID) }}" style="display:inline" onsubmit="return confirm('Delete this employee?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr><td colspan="4" style="color:var(--muted)">{{ request('search') ? 'No employees matched your search.' : 'No employees found.' }}</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection