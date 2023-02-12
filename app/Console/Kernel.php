<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Http\Controllers\YoutubeController;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $data = [
            'subject' => 'Area Mail',
            'body' => 'La pignouf',
            'mail' => 'akohajordan@gmail.com'
        ];
        // $schedule->command('inspire')->hourly();
       // $schedule->call('Full\Namespace\YoutubeController@send_mail2')->everyMinute();
        $schedule->call(function () {
            $youtube = new YoutubeController;
            $youtube->send_mail2([
                'subject' => 'Area Mail',
                'body' => 'La pignouf',
                'mail' => 'akohajordan@gmail.com'
            ]);
            // $youtube->index();
        })->everyMinute();
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
