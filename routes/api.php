<?php

// Laravel Imports
use Illuminate\Support\Facades\Route;

// Controller Imports 
use App\Http\Controllers\Api\v1\Admin\Employee\EmployeeController;

Route::prefix('v1')
    ->group(function () {
        Route::prefix('admin')
            ->name('admin.')
            ->group(function () {
                Route::prefix('employee')
                    ->name('employee.')
                    ->group(function () {
                        Route::get('/', [EmployeeController::class, 'index'])
                            ->name('index');
                    });
            });
    });
