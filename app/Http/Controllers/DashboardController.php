<?php

namespace App\Http\Controllers;

use App\Models\DeviceSetting;
use App\Models\Schedule;
use App\Models\SensorLog;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $settings = DeviceSetting::firstOrCreate([], [
            'mode' => 'manual',
            'dripper_override' => 'OFF',
            'fogger_override' => 'OFF',
            'motor_override' => 'OFF',
        ]);

        $schedules = Schedule::orderBy('time')->get();
        $latestSensor = SensorLog::latest()->first() ?? new SensorLog(['temperature' => 0.0, 'humidity' => 0.0]);
        $sensorHistory = SensorLog::latest()->take(10)->get()->reverse();
        $activityLogs = ActivityLog::latest()->take(25)->get();

        return view('dashboard', compact('settings', 'schedules', 'latestSensor', 'sensorHistory', 'activityLogs'));
    }

    /**
     * POST /mode
     * Update the system operating mode.
     */
    public function updateMode(Request $request)
    {
        $validated = $request->validate([
            'mode' => 'required|in:auto,manual,disabled',
        ]);

        $settings = DeviceSetting::firstOrCreate([]);
        $oldMode = $settings->mode;
        $settings->update(['mode' => $validated['mode']]);

        // Log this action
        ActivityLog::create([
            'event' => "System Mode Changed: " . strtoupper($oldMode) . " -> " . strtoupper($validated['mode']),
            'triggered_by' => 'Admin Dashboard',
        ]);

        return response()->json(['status' => 'success', 'mode' => $validated['mode']]);
    }

    /**
     * POST /override
     * Toggle manual valve or motor overrides.
     */
    public function toggleOverride(Request $request)
    {
        $validated = $request->validate([
            'target' => 'required|in:dripper,fogger,motor',
            'state' => 'required|in:ON,OFF',
        ]);

        $settings = DeviceSetting::firstOrCreate([]);
        $field = $validated['target'] . '_override';
        $settings->update([$field => $validated['state']]);

        // Log this action
        $targetName = ucfirst($validated['target']);
        ActivityLog::create([
            'event' => "{$targetName} Override set to {$validated['state']}",
            'triggered_by' => 'Admin Dashboard',
        ]);

        return response()->json([
            'status' => 'success',
            'target' => $validated['target'],
            'state' => $validated['state']
        ]);
    }

    /**
     * POST /schedules
     * Add a new schedule.
     */
    public function storeSchedule(Request $request)
    {
        $validated = $request->validate([
            'type' => 'required|in:dripper,fogger',
            'time' => 'required|date_format:H:i',
            'duration' => 'required|integer|min:1',
            'days_of_week' => 'nullable|array',
        ]);

        $days = $validated['days_of_week'] ?? ['*'];

        $schedule = Schedule::create([
            'type' => $validated['type'],
            'time' => $validated['time'] . ':00',
            'duration' => $validated['duration'],
            'is_active' => true,
            'days_of_week' => $days,
        ]);

        ActivityLog::create([
            'event' => "Created Schedule: " . ucfirst($schedule->type) . " at {$validated['time']} for {$schedule->duration} mins",
            'triggered_by' => 'Admin Dashboard',
        ]);

        return redirect()->back()->with('success', 'Schedule added successfully.');
    }

    /**
     * DELETE /schedules/{schedule}
     * Delete an existing schedule.
     */
    public function destroySchedule(Schedule $schedule)
    {
        $type = ucfirst($schedule->type);
        $time = date('H:i', strtotime($schedule->time));
        $duration = $schedule->duration;

        $schedule->delete();

        ActivityLog::create([
            'event' => "Deleted Schedule: {$type} at {$time} for {$duration} mins",
            'triggered_by' => 'Admin Dashboard',
        ]);

        return redirect()->back()->with('success', 'Schedule deleted successfully.');
    }
}
