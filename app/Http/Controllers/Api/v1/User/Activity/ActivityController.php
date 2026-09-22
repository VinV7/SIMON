<?php

namespace App\Http\Controllers\Api\v1\User\Activity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Http\Requests\Api\V1\User\Activity\ActivityStoreRequest;
use App\Http\Resources\Api\v1\User\Activity\ActivityStoreResource;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ActivityStoreRequest $request)
    {
        $activity = Activity::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'description' => $request->description,
            'started_at' => now()->toDateString() . ' ' . $request->time_started,
            'finished_at' => now()->toDateString() . ' ' . $request->time_ended,
        ]);
        $activity->load('category');

        return new ActivityStoreResource($activity);

        // return response()->json([
        //     'data' => $activity
        // ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
