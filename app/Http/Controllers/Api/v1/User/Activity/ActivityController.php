<?php

namespace App\Http\Controllers\Api\v1\User\Activity;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Activity;

// Request Imports
use App\Http\Requests\Api\v1\User\Activity\ActivityIndexRequest;
use App\Http\Requests\Api\V1\User\Activity\ActivityStoreRequest;
use App\Http\Requests\Api\v1\User\Activity\ActivitySummaryRequest;
use App\Http\Requests\Api\v1\User\Activity\ActivityUpdateRequest;

// Resource Imports
use App\Http\Resources\Api\v1\User\Activity\ActivityStoreResource;
use App\Http\Resources\Api\v1\User\Activity\ActivityIndexResource;
use App\Http\Resources\Api\v1\User\Activity\ActivityShowResource;
use App\Http\Resources\Api\v1\User\Activity\ActivitySummaryResource;
use App\Http\Resources\Api\v1\User\Activity\ActivityUpdateResource;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ActivityIndexRequest $request)
    {
        $activity = Activity::query()
            ->when(
                $request->filled('date'),
                function ($query) use ($request) {
                    $query->whereDate('created_at', $request->date);
                }
            )
            ->paginate(10);
        $activity->load('category');

        return ActivityIndexResource::collection($activity);

        // return response()->json([
        //     'data' => $activity
        // ]);
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
        $activity = Activity::query()
            ->findOrFail($id)
            ->load('category');
        
        return new ActivityShowResource($activity);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ActivityUpdateRequest $request, string $id)
    {
        $activity = Activity::query()->findOrFail($id);

        $activity->update([
            'category_id' => $request->category_id,
            'description' => $request->description,
            'started_at' => now()->toDateString() . ' ' . $request->started_at,
            'finished_at' => now()->toDateString() . ' ' . $request->ended_at,
        ]);

        return new ActivityUpdateResource($activity);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $activity = Activity::findOrFail($id);
        $activity->delete();

        return response()->json([
            'message' => 'success'
        ]);
    }

    public function summary(ActivitySummaryRequest $request) 
    {
        $activities = Activity::query()
            ->where('user_id', auth()->id())
            ->when(
            $request->filled('date'),
            function ($query) use ($request) {
                $query->whereDate('created_at', $request->date);
            })
            ->get();
        $activities->load('category');

        $total_hours = 0;
        $longest_activity = null;
        $max_duration = 0;
        
        foreach ($activities as $activity) {
            $duration = $activity->started_at->diffInMinutes($activity->finished_at);
            $total_hours += $duration;
            
            if ($duration > $max_duration) {
                $max_duration = $duration;
                $longest_activity = $activity;
            }
        };

        return new ActivitySummaryResource([$total_hours, $longest_activity]);
    }
}
