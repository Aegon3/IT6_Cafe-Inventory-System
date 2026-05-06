<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
    public function index()
    {
        $accounts = User::orderBy('name')->get();
        return view('accounts.index', compact('accounts'));
    }

    public function create()
    {
        $employees = Employee::orderBy('employee_Fname')->get();
        return view('accounts.create', compact('employees'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => 'required|email|unique:users,email',
            'password'    => 'required|min:6|confirmed',
            'is_admin'    => 'nullable|boolean',
            'employee_ID' => 'nullable|exists:employees,employee_ID',
        ]);

        User::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            'is_admin'    => $request->boolean('is_admin'),
            'employee_ID' => $data['employee_ID'] ?? null,
        ]);

        return redirect()->route('accounts.index')->with('success', 'Account created.');
    }

    public function edit(User $account)
    {
        $employees = Employee::orderBy('employee_Fname')->get();
        return view('accounts.edit', compact('account', 'employees'));
    }

    public function update(Request $request, User $account)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'email'       => 'required|email|unique:users,email,' . $account->id,
            'password'    => 'nullable|min:6|confirmed',
            'is_admin'    => 'nullable|boolean',
            'employee_ID' => 'nullable|exists:employees,employee_ID',
        ]);

        $account->update([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'is_admin'    => $request->boolean('is_admin'),
            'employee_ID' => $data['employee_ID'] ?? null,
        ]);

        if (!empty($data['password'])) {
            $account->update(['password' => Hash::make($data['password'])]);
        }

        return redirect()->route('accounts.index')->with('success', 'Account updated.');
    }

    public function destroy(User $account)
    {
        if ($account->id === auth()->id()) {
            return back()->withErrors(['error' => 'You cannot delete your own account.']);
        }
        $account->delete();
        return redirect()->route('accounts.index')->with('success', 'Account deleted.');
    }
}