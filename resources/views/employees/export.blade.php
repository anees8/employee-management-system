<!-- resources/views/employees/export.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Employee Records</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Employee Records</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Contact Number</th>
                <th>Email</th>
                <th>Date of Birth</th>
                <th>Address</th>
                <th>Employee Register Number</th>
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
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
