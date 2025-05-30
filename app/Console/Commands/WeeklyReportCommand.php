<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\WeeklyReport;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class WeeklyReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'report:weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send weekly report';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        foreach (User::all() as $user) {
            $user->notify(
                new WeeklyReport($this->getHabits($user))
            );
        }
    }

    public function getHabits(User $user): Collection
    {
        $query = "
            WITH RECURSIVE calendar AS (
                SELECT CURDATE() - INTERVAL 6 DAY AS log_date
                UNION ALL
                SELECT log_date + INTERVAL 1 DAY
                FROM calendar
                WHERE log_date + INTERVAL 1 DAY <= CURDATE()
            )
            SELECT
                h.id AS habit_id, 
                h.name AS habit_name, 
                c.log_date,
                CASE
                    WHEN h1.id IS NOT NULL THEN 1
                    ELSE 0
                END AS completed
            FROM calendar c
            CROSS JOIN habits h
            LEFT JOIN habit_logs h1 
                ON DATE(h1.completed_at) = c.log_date
                AND h1.habit_id = h.id
            JOIN users u ON h.user_id = u.id
            WHERE u.id = ?
            ORDER BY h.id, c.log_date;";

        return collect(DB::select($query, [$user->id]))
            ->map(function ($item) {

                return (object) [
                    'habit_id' => $item->habit_id,
                    'habit_name' => $item->habit_name,
                    'log_date' => Carbon::make($item->log_date),
                    'completed' => (bool) $item->completed
                ];   

            });

    }
}
