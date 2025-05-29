<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\WeeklyReport;
use Illuminate\Console\Command;

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
        $user = User::first();

        $user->notify(
            new WeeklyReport()
        );
    }
}
