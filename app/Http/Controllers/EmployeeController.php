<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class EmployeeController extends Controller
{
    private function nextID(): string
    {
        $last = Employee::orderByDesc('employee_ID')->value('employee_ID');
        $num  = $last ? ((int) substr($last, 1)) + 1 : 1;
        return 'E' . str_pad($num, 3, '0', STR_PAD_LEFT);
    }

    public function index(Request $request)
    {
        $query = Employee::orderBy('employee_ID');
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('employee_Fname', 'like', "%$s%")
                  ->orWhere('employee_Lname', 'like', "%$s%")
                  ->orWhere('employee_ID', 'like', "%$s%")
                  ->orWhere('e_role', 'like', "%$s%");
            });
        }
        $employees = $query->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_Fname'    => 'required|string|max:100',
            'employee_Lname'    => 'required|string|max:100',
            'e_role'            => 'required|string|max:100',
            'contact_number'    => 'nullable|string|max:20',
            'employee_address'  => 'nullable|string|max:255',
            'sss_number'        => 'nullable|string|max:20',
            'philhealth_number' => 'nullable|string|max:20',
        ]);

        // Validate account fields if checkbox is ticked
        if ($request->boolean('create_account')) {
            $request->validate([
                'account_email'    => 'required|email|unique:users,email',
                'account_password' => 'required|min:6|confirmed',
            ]);
        }

        $employee = Employee::create(array_merge(['employee_ID' => $this->nextID()], $data));

        if ($request->boolean('create_account')) {
            User::create([
                'name'        => $employee->employee_Fname . ' ' . $employee->employee_Lname,
                'email'       => $request->account_email,
                'password'    => Hash::make($request->account_password),
                'is_admin'    => $request->boolean('account_is_admin'),
                'employee_ID' => $employee->employee_ID,
            ]);
        }

        return redirect()->route('employees.index')->with('success', 'Employee added.');
    }

    public function edit(Employee $employee)
    {
        $linkedAccount = User::where('employee_ID', $employee->employee_ID)->first();
        return view('employees.edit', compact('employee', 'linkedAccount'));
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'employee_Fname'    => 'required|string|max:100',
            'employee_Lname'    => 'required|string|max:100',
            'e_role'            => 'required|string|max:100',
            'contact_number'    => 'nullable|string|max:20',
            'employee_address'  => 'nullable|string|max:255',
            'sss_number'        => 'nullable|string|max:20',
            'philhealth_number' => 'nullable|string|max:20',
        ]);

        $employee->update($data);

        $linkedAccount = User::where('employee_ID', $employee->employee_ID)->first();

        if ($linkedAccount) {
            // Update existing account
            $linkedAccount->update([
                'name'     => $employee->employee_Fname . ' ' . $employee->employee_Lname,
                'is_admin' => $request->boolean('account_is_admin'),
            ]);
            if ($request->filled('account_password')) {
                $request->validate(['account_password' => 'min:6|confirmed']);
                $linkedAccount->update(['password' => Hash::make($request->account_password)]);
            }
        } elseif ($request->boolean('create_account')) {
            // Create new account
            $request->validate([
                'account_email'    => 'required|email|unique:users,email',
                'account_password' => 'required|min:6|confirmed',
            ]);
            User::create([
                'name'        => $employee->employee_Fname . ' ' . $employee->employee_Lname,
                'email'       => $request->account_email,
                'password'    => Hash::make($request->account_password),
                'is_admin'    => $request->boolean('account_is_admin'),
                'employee_ID' => $employee->employee_ID,
            ]);
        }

        return redirect()->route('employees.index')->with('success', 'Employee updated.');
    }

    public function destroy(Employee $employee)
    {
        // Also remove linked account if any
        User::where('employee_ID', $employee->employee_ID)->delete();
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted.');
    }
}