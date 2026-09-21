<?php

// Laravel Imports
use Illuminate\Support\Facades\Route;

// Controller Imports 
use App\Http\Controllers\Api\v1\Admin\Employee\EmployeeController;
use App\Http\Controllers\Api\V1\Admin\Auth\AuthController;

Route::prefix('v1')->group(function () {
    Route::prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::post('/login', [AuthController::class, 'authenticate'])->name('authenticate');

            Route::middleware('auth:admin')->group(function () {
                Route::delete('/logout', [AuthController::class, 'logout'])->name('logout');

                Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
                Route::post('/employees',  [EmployeeController::class, 'store'])->name('employees.store');
                Route::patch('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
                Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');
            });
        });
});
