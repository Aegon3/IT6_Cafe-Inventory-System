@extends('layouts.app')
@section('title', 'Add Employee')

@section('content')
<div class="card">
    <div class="card-title">Add Employee</div>
    <form method="POST" action="{{ route('employees.store') }}">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label>First Name</label>
                <input type="text" name="employee_Fname" value="{{ old('employee_Fname') }}" required>
            </div>
            <div class="form-group">
                <label>Last Name</label>
                <input type="text" name="employee_Lname" value="{{ old('employee_Lname') }}" required>
            </div>
            <div class="form-group">
                <label>Role</label>
                <select name="e_role">
                    @foreach(['Admin','Staff','Cashier','Manager'] as $r)
                        <option value="{{ $r }}" {{ old('e_role') === $r ? 'selected' : '' }}>{{ $r }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Add Employee</button>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
