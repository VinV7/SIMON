<?php

// Laravel Imports
use Illuminate\Support\Facades\Route;

// Controller Imports 
    // Admin
use App\Http\Controllers\Api\v1\Admin\Employee\EmployeeController;
use App\Http\Controllers\Api\V1\Admin\Auth\AuthController as AdminAuthController;
use App\Http\Controllers\Api\v1\Admin\ActivityCategory\ActivityCategoriesController;
// User
use App\Http\Controllers\Api\v1\User\Auth\AuthController as UserAuthController;
use App\Http\Controllers\Api\v1\User\Activity\ActivityController;

Route::prefix('v1')->group(function () {
    Route::prefix('admin')
        ->name('admin.')
        ->group(function () {
            Route::post('/login', [AdminAuthController::class, 'authenticate'])->name('authenticate');

            Route::middleware('auth:admin')->group(function () {
                Route::delete('/logout', [AdminAuthController::class, 'logout'])->name('logout');

                Route::get('/employees', [EmployeeController::class, 'index'])->name('employees.index');
                Route::post('/employees',  [EmployeeController::class, 'store'])->name('employees.store');
                Route::patch('/employees/{id}', [EmployeeController::class, 'update'])->name('employees.update');
                Route::delete('/employees/{id}', [EmployeeController::class, 'destroy'])->name('employees.destroy');

                Route::get('/activity-categories', [ActivityCategoriesController::class, 'index'])->name('activity-categories.index');
                Route::post('/activity-categories', [ActivityCategoriesController::class, 'store'])->name('activity-categories.store');
                Route::patch('/activity-categories/{id}', [ActivityCategoriesController::class, 'update'])->name('activity-categories.update');
                Route::delete('/activity-categories/{id}', [ActivityCategoriesController::class, 'destroy'])->name('activity-categories.destroy');
            });
        });

    Route::prefix('user')
        ->name('user.')
        ->group(function  () {
            Route::post('/login', [UserAuthController::class, 'authenticate'])->name('authenticate');
        
            Route::middleware('auth:employee')->group(function () {
                Route::delete('/logout', [UserAuthController::class, 'logout'])->name('logout');

                Route::get('/activity', [ActivityController::class, 'index'])->name('activity.index');
                Route::get('/activity/{id}', [ActivityController::class, 'show'])->name('activity.show');
                Route::post('/activity', [ActivityController::class, 'store'])->name('activity.store');
                Route::patch('/activity/{id}', [ActivityController::class, 'update'])->name('activity.update');
                Route::delete('/activity/{id}', [ActivityController::class, 'destroy'])->name('activity.delete');
            });  
        });
});
