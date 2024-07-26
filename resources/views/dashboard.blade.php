@extends('layouts.app')
@section('navbar')
@endsection

@section('content')
<div class="container">
    <h1 class="mb-4">Employee List</h1>
    <!-- Filter Form -->
    <form method="GET" action="{{ route('dashboard') }}" class="mb-4">
        <div class="input-group">
            <input type="search" name="filter" class="form-control" placeholder="Search..." value="{{ request('filter') }}">
            <button class="btn btn-primary" type="submit">Filter</button>
        </div>
    </form>
 <!-- Button Row with Flexbox -->
 <div class="d-flex justify-content-between mb-4">
    <!-- Add New Employee Button -->
     <div>
    <a href="{{ route('employees.create') }}" class="btn btn-success">Add New Employee</a>
    </div>
    
    <div class="d-flex align-items-center">
        <!-- Import Form -->
        <form action="{{ route('employees.import') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center me-2">
            @csrf
            <input type="file" class="form-control me-2" id="file" name="file" accept=".xls,.xlsx"  required>
            <button type="submit" class="btn btn-info">Import</button>
        </form>
        
        <!-- Export Button -->
        <a href="{{ route('employees.export') }}" class="btn btn-info ml-3">Export Records</a>
    </div> 
</div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    <!-- Employee Table -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Contact Number</th>
                    <th>Email</th>
                    <th>Date of Birth</th>
                    <th>Address</th>
                    <th>Employee Register Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                    <tr>
                        <td>{{ $employee->name }}</td>
                        <td>{{ $employee->contact_number }}</td>
                        <td>{{ $employee->email }}</td>
                        <td>{{ $employee->date_of_birth->format('Y-m-d') }}</td>
                        <td>{{ $employee->address }}</td>
                        <td>{{ $employee->employee_register_number }}</td>
                        <td>
                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div>
        {{ $employees->links() }}
    </div>
</div>
@endsection
