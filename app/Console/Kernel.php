<?php

namespace App\Console;

use App\Jobs\SyncFeeds;
use App\Models\Feed;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\App;

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
        // do not run if testing env
        if (App::environment() !== 'testing') {
            $feeds = Feed::isActive()->notFetchedYet()->get();
            foreach ($feeds as $feed) {
                $schedule->job(new SyncFeeds($feed), 'scrape')->everyMinute();
            }
        }
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
