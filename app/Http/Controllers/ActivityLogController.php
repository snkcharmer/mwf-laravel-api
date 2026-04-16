<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use App\Http\Resources\ActivityLogResource;
use App\Http\Requests\StoreActivityLogRequest;

class ActivityLogController extends Controller
{
    // GET /api/activity-log
    public function index(Request $request)
    {
        $logs = ActivityLog::search($request)
            ->sort($request)
            ->filterByDate($request)
            ->paginate($request->integer('per_page', 10));

        return ActivityLogResource::collection($logs);
    }

    // POST /api/activity-log
    public function store(StoreActivityLogRequest $request)
    {
        $logs = ActivityLog::create($request->validated());

        return new ActivityLogResource($logs);
    }

    // GET /api/activity-log/{activity_log}
    public function show(ActivityLog $logs)
    {
        return new ActivityLogResource($logs);
    }

    // DELETE /api/activity-log/{activity_log}
    public function destroy(ActivityLog $logs)
    {
        $logs->delete();

        return response()->json([
            'message' => 'Activity log successfully deleted.',
            'data' => new ActivityLogResource($logs),
        ]);
    }
}
