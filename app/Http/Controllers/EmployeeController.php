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

    public function index()
    {
        $employees = Employee::orderBy('employee_ID')->get();
        return view('employees.index', compact('employees'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'employee_Fname' => 'required|string|max:100',
            'employee_Lname' => 'required|string|max:100',
            'e_role'         => 'required|string|max:100',
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
            'employee_Fname' => 'required|string|max:100',
            'employee_Lname' => 'required|string|max:100',
            'e_role'         => 'required|string|max:100',
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
