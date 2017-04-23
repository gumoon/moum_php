<?php

namespace moum\Console;

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
        Commands\fetchNews::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
//         $schedule->command('inspire')
//                  ->sendOutputTo('/Users/gumoon/Desktop/testcommand.txt', true)
//                  ->everyMinute();
        $logFile = env('CRONTAB_LOG_DIR') . 'zoglo.txt';
         $schedule->command('news:fetch 10')->sendOutputTo($logFile, true)->everyMinute();
//         $schedule->exec('date')->everyMinute()->sendOutputTo('/Users/gumoon/Desktop/testcommand.txt', true);
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
