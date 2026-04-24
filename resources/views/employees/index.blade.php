@extends('layouts.app')
@section('title', 'Employees')

@section('content')
<div class="card">
    <div class="card-title">All Employees</div>
    <div style="margin-bottom:14px">
        <a href="{{ route('employees.create') }}" class="btn btn-primary">Add Employee</a>
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
            <tr><td colspan="4" style="color:var(--muted)">No employees found.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
