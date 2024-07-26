<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{AuthController,EmployeeController};
 
Route::match(array('GET','POST'),'/', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('employees/import', [EmployeeController::class, 'import'])->name('employees.import');
Route::middleware('auth')->group(function () {
    Route::get('employees/export', [EmployeeController::class, 'export'])->name('employees.export');
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard','employees.index');
    Route::get('employees', [EmployeeController::class, 'index']);
    Route::get('employees/{employee}', [EmployeeController::class, 'show'])->name('employees.edit');
    Route::get('employees', [EmployeeController::class, 'create'])->name('employees.create');
    Route::post('employees', [EmployeeController::class, 'store'])->name('employees.store');
    Route::put('employees/{employee}', [EmployeeController::class, 'update'])->name('employees.update');
    Route::delete('employees/{employee}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
    Route::get('employees/search/{keyword}', [EmployeeController::class, 'search']);
   
});

