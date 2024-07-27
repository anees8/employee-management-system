<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{EmployeeController};

Route::get('/employees', [EmployeeController::class, 'fetchEmployee']);

// Fetch all employee records
Route::get('/employees/all', [EmployeeController::class, 'fetchAllEmployees']);
