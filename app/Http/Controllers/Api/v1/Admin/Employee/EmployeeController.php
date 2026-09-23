<?php

namespace App\Http\Controllers\Api\v1\Admin\Employee;

// Laravel Imports
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Model Imports
use App\Models\User;

// Resource Imports
use App\Http\Resources\Api\v1\Admin\Employee\EmployeeIndexResource;
use App\Http\Resources\Api\v1\Admin\Employee\EmployeeStoreResource;
use App\Http\Resources\Api\v1\Admin\Employee\EmployeeUpdateResource;
use App\Http\Resources\Api\v1\Admin\Employee\EmployeeSummaryResource;

// Request Imports 
use App\Http\Requests\Api\V1\Admin\Employee\EmployeeIndexRequest;
use App\Http\Requests\Api\V1\Admin\Employee\EmployeeStoreRequest;
use App\Http\Requests\Api\V1\Admin\Employee\EmployeeUpdateRequest;
use App\Http\Requests\Api\V1\Admin\Employee\EmployeeSummaryRequest;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(EmployeeIndexRequest $request)
    {
        $orderBy        = $request->validated('orderBy') ?? 'name';
        $orderDirection = $request->validated('orderDirection') ?? 'asc';

        $employees = User::query()
            ->select(['id', 'name', 'email', 'address', 'created_at', 'updated_at'])
            ->when(
                $request->filled('keyword'),
                function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->keyword . '%')
                          ->orWhere('email', 'like', '%' . $request->keyword . '%')
                          ->orWhere('address', 'like', '%' . $request->keyword . '%');
                }
            )
            ->orderBy($orderBy, $orderDirection)
            ->paginate(10);

        // return response()->json([
        //     'success' => 'true',
        //     'data' => $employees
        // ]);
        
        return new EmployeeIndexResource([
            'data'  => $employees,
            'count' => $employees->count()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeStoreRequest $request)
    {
        $employee = User::create($request->validated());
        
        return new EmployeeStoreResource($employee);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeUpdateRequest $request, string $id)
    {
        $employee = User::findOrFail($id);
        $employee->update($request->validated());
        
        return new EmployeeUpdateResource($employee);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = User::findOrFail($id);
        $employee->delete();
        
        return response()->json([
            'data' => [
                'message' => 'success'
            ]
        ]);
    }

    public function summary(EmployeeSummaryRequest $request)
    {
        $employees = User::with([
            'activities' => function ($query) use ($request) {
                $query->when($request->filled('date'), function ($query) use ($request) {
                    $query->whereDate('created_at', $request->date);
                });
            }
        ])
        ->get();

        $total_employees = $employees->count();
        $total_active_employees = 0;
    
        $active_employees = [];
        $passive_employees = [];

        foreach ($employees as $employee) {
            if ($employee->activities->count() > 0) {
                $active_employees[] = $employee->only(['id', 'name', 'email']);
                $total_active_employees++;
            } else {
                $passive_employees[] = $employee->only(['id', 'name', 'email']);
            }
        }

        
        return new EmployeeSummaryResource([
            $total_employees, 
            $total_active_employees,
            $active_employees,
            $passive_employees
        ]);
    }
}
