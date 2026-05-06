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
                    @foreach(['Admin','Staff'] as $r)
                        <option value="{{ $r }}" {{ old('e_role') === $r ? 'selected' : '' }}>{{ $r }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Contact Number</label>
                <input type="text" name="contact_number" value="{{ old('contact_number') }}">
            </div>
            <div class="form-group" style="grid-column: 1 / -1">
                <label>Address</label>
                <input type="text" name="employee_address" value="{{ old('employee_address') }}">
            </div>
            <div class="form-group">
                <label>SSS Number</label>
                <input type="text" name="sss_number" value="{{ old('sss_number') }}">
            </div>
            <div class="form-group">
                <label>PhilHealth Number</label>
                <input type="text" name="philhealth_number" value="{{ old('philhealth_number') }}">
            </div>
        </div>

        {{-- Login Account Section --}}
        <div class="card-title" style="margin-top:24px">
            Login Account
            <span style="font-size:.75rem;font-weight:400;color:var(--muted);font-style:italic;margin-left:8px">Optional — lets this employee log in</span>
        </div>
        <div style="margin-bottom:14px">
            <label style="display:flex;align-items:center;gap:8px;cursor:pointer;font-size:.88rem">
                <input type="checkbox" name="create_account" id="create_account" value="1" {{ old('create_account') ? 'checked' : '' }}
                    onchange="document.getElementById('account-fields').style.display=this.checked?'':'none'"
                    style="width:16px;height:16px;accent-color:var(--accent)">
                Create a login account for this employee
            </label>
        </div>
        <div id="account-fields" style="display:{{ old('create_account') ? '' : 'none' }}">
            <div class="form-grid">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="account_email" value="{{ old('account_email') }}" placeholder="employee@cafedampog.com">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="account_password" placeholder="Min. 6 characters">
                </div>
                <div class="form-group">
                    <label>Confirm Password</label>
                    <input type="password" name="account_password_confirmation" placeholder="Repeat password">
                </div>
                <div class="form-group" style="justify-content:flex-end;padding-bottom:4px">
                    <label style="display:flex;align-items:center;gap:8px;cursor:pointer;text-transform:none;letter-spacing:0;font-size:.88rem;font-weight:400">
                        <input type="checkbox" name="account_is_admin" value="1" {{ old('account_is_admin') ? 'checked' : '' }}
                            style="width:16px;height:16px;accent-color:var(--accent)">
                        Grant Admin privileges
                    </label>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Add Employee</button>
            <a href="{{ route('employees.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection