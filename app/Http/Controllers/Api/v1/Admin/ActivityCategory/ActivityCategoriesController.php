<?php

namespace App\Http\Controllers\Api\v1\Admin\ActivityCategory;

// Laravel Imports
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Model Imports
use App\Models\ActivityCategory;

// Resource Imports
use App\Http\Resources\Api\v1\Admin\ActivityCategory\ActivityCategoryIndexResource;
use App\Http\Resources\Api\v1\Admin\ActivityCategory\ActivityCategoryStoreResource;
use App\Http\Resources\Api\v1\Admin\ActivityCategory\ActivityCategoryUpdateResource;

// Request Imports 
use App\Http\Requests\Api\V1\Admin\ActivityCategory\ActivityCategoryIndexRequest;
use App\Http\Requests\Api\V1\Admin\ActivityCategory\ActivityCategoryStoreRequest;
use App\Http\Requests\Api\V1\Admin\ActivityCategory\ActivityCategoryUpdateRequest;

class ActivityCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ActivityCategoryIndexRequest $request)
    {
        $orderBy        = $request->validated('orderBy') ?? 'name';
        $orderDirection = $request->validated('orderDirection') ?? 'asc';

        $activityCategories = ActivityCategory::query()
            ->select(['id', 'name', 'created_at', 'updated_at'])
            ->when(
                $request->filled('keyword'),
                function ($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->keyword . '%');
                }
            )
            ->orderBy($orderBy, $orderDirection)
            ->paginate(10);

        return new ActivityCategoryIndexResource([
            'data'  => $activityCategories,
            'count' => $activityCategories->count()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ActivityCategoryStoreRequest $request)
    {
        $activityCategory = ActivityCategory::create($request->validated());
        
        return new ActivityCategoryStoreResource($activityCategory);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ActivityCategoryUpdateRequest $request, string $id)
    {
        $activityCategory = ActivityCategory::findOrFail($id);
        $activityCategory->update($request->validated());
        
        return new ActivityCategoryUpdateResource($activityCategory);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $activityCategory = ActivityCategory::findOrFail($id);
        $activityCategory->delete();
        
        return response()->json([
            'data' => [
                'message' => 'success'
            ]
        ]);
    }
}