<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
	protected $commands = [
		'App\Console\Commands\SendFilesFIFCO\Faca\CustomerFormat',
		'App\Console\Commands\SendFilesFIFCO\Faca\CameraFormat',
		'App\Console\Commands\SendFilesFIFCO\Faca\ProductsFormat',
		'App\Console\Commands\SendFilesFIFCO\Faca\SaleFormat'
		];
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
	    /**
	     * Comandos de FIFCO
	     */

	    $schedule->command('friendly:CustomerFormat')
		    ->dailyAt('23:00');
	    $schedule->command('friendly:cameraFormat')
		    ->dailyAt('23:00');
	    $schedule->command('friendly:productFormat')
		    ->dailyAt('23:00');
	    $schedule->command('friendly:saleFormat')
		    ->dailyAt('23:00');
        // $schedule->command('inspire')->hourly();
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
