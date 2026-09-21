<?php

namespace App\Http\Controllers\Api\v1\Admin\Employee;

// Laravel Imports
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Model Imports
use App\Models\User;

// Resource Imports
use App\Http\Resources\Api\v1\Admin\Employee\EmployeeResource;

// Request Imports 
use App\Http\Requests\Api\V1\Admin\Employee\EmployeeIndexRequest;

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
        
        return new EmployeeResource([
            'data'  => $employees,
            'count' => $employees->count()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
