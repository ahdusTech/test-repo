<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\BidManagerAuctionClosing;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
         //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('daily-visits')
            ->dailyAt('00:02')
            ->timezone('Europe/Vienna')->runInBackground();
        $schedule->command('add-daily-visits-to-adomino-com')
            ->dailyAt('00:15')
            ->timezone('Europe/Vienna')->runInBackground();
        $schedule->command('add-total-to-visits-per-day')
            ->dailyAt('00:30')
            ->timezone('Europe/Vienna')->runInBackground();
        $schedule->command('import-domains')
            ->dailyAt('04:00')
            ->timezone('Europe/Vienna')->runInBackground();
        $schedule->command('bid_manager_auction_closing')->name('bid_manager_automation')
            ->everyThirtyMinutes()->runInBackground()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
