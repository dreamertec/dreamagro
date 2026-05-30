<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\DeviceSetting;
use App\Models\Schedule;
use App\Models\SensorLog;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class IrrigationApiController extends Controller
{
    /**
     * GET /api/irrigation/status
     * Returns system mode, override triggers, and active schedules list.
     */
    public function status()
    {
        // Get or create default settings
        $settings = DeviceSetting::firstOrCreate([], [
            'mode' => 'manual',
            'dripper_override' => 'OFF',
            'fogger_override' => 'OFF',
            'motor_override' => 'OFF',
        ]);

        $schedules = Schedule::where('is_active', true)->get();

        return response()->json([
            'mode' => $settings->mode,
            'dripper_override' => $settings->dripper_override,
            'fogger_override' => $settings->fogger_override,
            'motor_override' => $settings->motor_override,
            'schedules' => $schedules->map(function ($schedule) {
                return [
                    'id' => $schedule->id,
                    'type' => $schedule->type,
                    'time' => $schedule->time,
                    'duration' => $schedule->duration, // in minutes
                    'days_of_week' => $schedule->days_of_week ?? ['*'],
                ];
            }),
        ]);
    }

    /**
     * POST /api/irrigation/telemetry
     * Receives sensor readings & relay states from the ESP32.
     */
    public function telemetry(Request $request)
    {
        $validated = $request->validate([
            'temperature' => 'required|numeric',
            'humidity' => 'required|numeric',
            'motor_state' => 'required|integer',
            'dripper_state' => 'required|integer',
            'fogger_state' => 'required|integer',
        ]);

        // 1. Log sensor readings if valid
        if ($validated['temperature'] != 0.0 || $validated['humidity'] != 0.0) {
            SensorLog::create([
                'temperature' => $validated['temperature'],
                'humidity' => $validated['humidity'],
            ]);
        }

        // 2. Fetch current settings
        $settings = DeviceSetting::first();
        if ($settings) {
            // Auto-clear overrides if ESP32 reports that the valve has successfully closed.
            // This is useful for manual click events that run for a set duration.
            $updates = [];
            
            if ($settings->dripper_override === 'ON' && $validated['dripper_state'] === 0) {
                $updates['dripper_override'] = 'OFF';
            }
            if ($settings->fogger_override === 'ON' && $validated['fogger_state'] === 0) {
                $updates['fogger_override'] = 'OFF';
            }
            if ($settings->motor_override === 'ON' && $validated['motor_state'] === 0) {
                $updates['motor_override'] = 'OFF';
            }

            if (!empty($updates)) {
                $settings->update($updates);
            }
        }

        return response()->json(['status' => 'success']);
    }

    /**
     * POST /api/irrigation/log
     * Receives event logging from the ESP32 (e.g. physical buttons or timer triggers)
     */
    public function logEvent(Request $request)
    {
        $validated = $request->validate([
            'event' => 'required|string',
            'triggered_by' => 'required|string',
        ]);

        ActivityLog::create([
            'event' => $validated['event'],
            'triggered_by' => $validated['triggered_by'],
        ]);

        return response()->json(['status' => 'success']);
    }
}
