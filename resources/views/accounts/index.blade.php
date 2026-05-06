@extends('layouts.app')
@section('title', 'User Accounts')

@section('content')
<div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:20px">
    <div></div>
    <a href="{{ route('accounts.create') }}" class="btn btn-primary">+ New Account</a>
</div>

<div class="card">
    <div class="card-title">User Accounts</div>
    <div class="table-wrap">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Linked Employee</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($accounts as $account)
                <tr>
                    <td>{{ $account->name }}</td>
                    <td style="color:var(--muted)">{{ $account->email }}</td>
                    <td>
                        @if($account->is_admin)
                            <span class="badge badge-admin">Admin</span>
                        @else
                            <span class="badge badge-staff">Staff</span>
                        @endif
                    </td>
                    <td>
                        @if($account->employee)
                            {{ $account->employee->employee_Fname }} {{ $account->employee->employee_Lname }}
                            <span style="color:var(--muted);font-size:.78rem">({{ $account->employee->e_role }})</span>
                        @else
                            <span style="color:var(--muted)">—</span>
                        @endif
                    </td>
                    <td style="text-align:right;white-space:nowrap">
                        <a href="{{ route('accounts.edit', $account) }}" class="btn btn-secondary btn-sm">Edit</a>
                        @if($account->id !== auth()->id())
                        <form method="POST" action="{{ route('accounts.destroy', $account) }}" style="display:inline" onsubmit="return confirm('Delete this account?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
