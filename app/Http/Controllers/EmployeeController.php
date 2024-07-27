<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Carbon\Carbon;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $query = Employee::query();

        if ($request->has('filter')) {
            $filter = $request->input('filter');
            $query->where('name', 'like', "%{$filter}%")
                  ->orWhere('contact_number', 'like', "%{$filter}%")
                  ->orWhere('email', 'like', "%{$filter}%");
        }

        $employees = $query->paginate(10);

        return view('dashboard', compact('employees'));
    }

    public function show($id)
    {
        // Find the employee by ID or abort if not found
        $employee = Employee::findOrFail($id);

        // Return the view with employee data
        return view('employees.create', compact('employee'));
    }

    public function create()
    {
        return view('employees.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contact_number' => 'required|unique:employees|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email' => 'required|unique:employees|email',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $employee = new Employee($request->all());
        $employee->employee_register_number = 'EMP' . str_pad(Employee::count() + 1, 3, '0', STR_PAD_LEFT);
        $employee->save();

        return redirect()->route('dashboard')->with('success', 'Employee added successfully!');
    }

    public function edit(Employee $employee)
    {
        return view('employees.edit', compact('employee'));
    }

    public function update(Request $request,Employee $employee)
    {
    
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contact_number' => 'required|unique:employees,contact_number,' . $employee->id . '|regex:/^([0-9\s\-\+\(\)]*)$/',
            'email' => 'required|unique:employees,email,' . $employee->id . '|email',
            'date_of_birth' => 'required|date',
            'address' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $employee->update($request->all());

        return redirect()->route('dashboard')->with('success', 'Employee updated successfully!');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('dashboard')->with('success', 'Employee deleted successfully!');
    }

    public function export()
    {
        $employees = Employee::all();
        $pdf = Pdf::loadView('employees.export', compact('employees'));
        
        return $pdf->download('employees.pdf');
    }
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls',
        ]);
        
        $file = $request->file('file');
        $spreadsheet = IOFactory::load($file->getPathname());
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // Iterate through the rows and update or create records
        foreach ($rows as $index => $row) {
            // Skip the header row
            if ($index === 0) {
                continue;
            }

            // Map data to employee model
            Employee::updateOrCreate(
                ['employee_register_number' => $row[0]], // Unique field for matching
                [
                    'name' => $row[1],
                    'contact_number' => $row[2],
                    'email' => $row[3],
                    'date_of_birth' => Carbon::parse($row[4]), // Convert to date format
                    'address' => $row[5] ?? null, // Optional field
                ]
            );
        }


        return redirect()->back()->with('success', 'Employees imported successfully.');
    }
    // API Endpoints

    public function fetchEmployee(Request $request)
    {
        $query = Employee::query();
        
        if ($request->has('register_number')) {
            $query->where('employee_register_number', $request->query('register_number'));
        }

        if ($request->has('contact_number')) {
            $query->where('contact_number', $request->query('contact_number'));
        }

        if ($request->has('email')) {
            $query->where('email', $request->query('email'));
        }

        $employee = $query->first();

        if ($employee) {
            return response()->json($employee);
        } else {
            return response()->json(['message' => 'Employee not found'], 404);
        }
    }

    public function fetchAllEmployees()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }
}
