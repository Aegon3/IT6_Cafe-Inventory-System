@extends('layouts.app')
@section('title', 'Edit Employee')

@section('content')
<div class="card">
    <div class="card-title">Edit Employee — {{ $employee->employee_ID }}</div>
    <form method="POST" action="{{ route('employees.update', $employee->employee_ID) }}">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="employee_Fname" value="{{ old('employee_Fname', $employee->employee_Fname) }}" required>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="employee_Lname" value="{{ old('employee_Lname', $employee->employee_Lname) }}" required>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="e_role">
                    @foreach(['Admin','Staff','Cashier','Manager'] as $r)
                        <option value="{{ $r }}" {{ old('e_role', $employee->e_role) === $r ? 'selected' : '' }}>{{ $r }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Employee</button>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
