<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

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
        Employee::create(array_merge(['employee_ID' => $this->nextID()], $data));
        return redirect()->route('employees.index')->with('success', 'Employee added.');
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
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
        return redirect()->route('employees.index')->with('success', 'Employee updated.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted.');
    }
}