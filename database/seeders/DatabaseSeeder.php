<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\DeviceSetting;
use App\Models\Schedule;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed initial device settings
        DeviceSetting::firstOrCreate([], [
            'mode' => 'manual', // start in manual mode as requested
            'dripper_override' => 'OFF',
            'fogger_override' => 'OFF',
            'motor_override' => 'OFF',
        ]);

        // 2. Seed initial schedules matching existing predefined schedules
        // 6:00 AM Dripper (10 min)
        Schedule::firstOrCreate(
            ['type' => 'dripper', 'time' => '06:00:00'],
            ['duration' => 10, 'is_active' => true, 'days_of_week' => ['*']]
        );

        // 12:15 PM Dripper (5 min)
        Schedule::firstOrCreate(
            ['type' => 'dripper', 'time' => '12:15:00'],
            ['duration' => 5, 'is_active' => true, 'days_of_week' => ['*']]
        );

        // 6:00 PM Dripper (10 min)
        Schedule::firstOrCreate(
            ['type' => 'dripper', 'time' => '18:00:00'],
            ['duration' => 10, 'is_active' => true, 'days_of_week' => ['*']]
        );

        // Fogger schedules (representing 11:30 AM to 2:00 PM window at 30 min intervals, duration 1 min)
        $foggerTimes = ['11:30:00', '12:00:00', '12:30:00', '13:00:00', '13:30:00'];
        foreach ($foggerTimes as $t) {
            Schedule::firstOrCreate(
                ['type' => 'fogger', 'time' => $t],
                ['duration' => 1, 'is_active' => true, 'days_of_week' => ['*']]
            );
        }

        // 3. User for testing
        User::firstOrCreate(
            ['email' => 'admin@dreamagro.com'],
            [
                'name' => 'DreamAgro Admin',
                'password' => bcrypt('password'),
            ]
        );
    }
}
