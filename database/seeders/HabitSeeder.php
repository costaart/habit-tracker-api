<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Habit;
use App\Models\HabitLog;

class HabitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::all()->each(function ($user) {
            Habit::factory(10)->create([
            'user_id' => $user->id,
            ])->each(function ($habit) {
                HabitLog::factory()->create([
                    'habit_id' => $habit->id,
                ]);
            });
        });
    }
}
