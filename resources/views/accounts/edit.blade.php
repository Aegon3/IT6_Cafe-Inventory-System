@extends('layouts.app')
@section('title', 'Edit Account')

@section('content')
<div class="card">
    <div class="card-title">Edit Account — {{ $account->name }}</div>
    <form method="POST" action="{{ route('accounts.update', $account) }}">
        @csrf @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" value="{{ old('name', $account->name) }}" required>
            </div>
            <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" value="{{ old('email', $account->email) }}" required>
            </div>
            <div class="form-group">
                <label>New Password <span style="color:var(--muted);font-weight:400">(leave blank to keep)</span></label>
                <input type="password" name="password" placeholder="Min. 6 characters">
            </div>
            <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="password_confirmation" placeholder="Repeat new password">
            </div>
            <div class="form-group">
                <label>Linked Employee <span style="color:var(--muted);font-weight:400">(for auto-fill)</span></label>
                <select name="employee_ID">
                    <option value="">— None —</option>
                    @foreach($employees as $e)
                    <option value="{{ $e->employee_ID }}" {{ old('employee_ID', $account->employee_ID) == $e->employee_ID ? 'selected' : '' }}>
                        {{ $e->employee_Fname }} {{ $e->employee_Lname }} ({{ $e->e_role }})
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="justify-content:flex-end;padding-bottom:4px">
                <label style="display:flex;align-items:center;gap:8px;cursor:pointer;text-transform:none;letter-spacing:0;font-size:.88rem;font-weight:400">
                    <input type="checkbox" name="is_admin" value="1" {{ old('is_admin', $account->is_admin) ? 'checked' : '' }} style="width:16px;height:16px;accent-color:var(--accent)"
                    {{ $account->id === auth()->id() ? 'disabled' : '' }}>
                    Grant Admin privileges
                </label>
                @if($account->id === auth()->id())
                    <span style="font-size:.72rem;color:var(--muted);font-style:italic">Cannot change your own role</span>
                @endif
            </div>
        </div>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Changes</button>
            <a href="{{ route('accounts.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
