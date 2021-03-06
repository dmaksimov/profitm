<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\SendDropNotifications::class,
        Commands\SendDrops::class,
        Commands\ExpireCampaigns::class,
        Commands\RenewFacebookToken::class,
        Commands\FetchEvents::class,
        Commands\FetchCamapaigns::class,

    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('drops:notify')->everyMinute();
        $schedule->command('fetch:events')->everyMinute();
        $schedule->command('fetch:campaigns')->everyMinute();
//        $schedule->command('drops:send')->everyMinute();
        $schedule->command('campaigns:expire')->daily();
        $schedule->command('facebook-integration:reminder-renew-token')->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
