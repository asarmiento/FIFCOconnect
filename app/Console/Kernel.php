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
		'App\Console\Commands\SendFilesFIFCO\Faca\SaleFormat',
		'App\Console\Commands\SendFilesFIFCO\Jagris\CustomerFormat',
		'App\Console\Commands\SendFilesFIFCO\Jagris\CameraFormat',
		'App\Console\Commands\SendFilesFIFCO\Jagris\ProductsFormat',
		'App\Console\Commands\SendFilesFIFCO\Jagris\SaleFormat',
		'App\Console\Commands\SendFilesFIFCO\Alvasol\CustomerFormat',
		'App\Console\Commands\SendFilesFIFCO\Alvasol\CameraFormat',
		'App\Console\Commands\SendFilesFIFCO\Alvasol\ProductsFormat',
		'App\Console\Commands\SendFilesFIFCO\Alvasol\SaleFormat',
		'App\Console\Commands\SendFilesFIFCO\Azteka\CustomerFormat',
		'App\Console\Commands\SendFilesFIFCO\Azteka\CameraFormat',
		'App\Console\Commands\SendFilesFIFCO\Azteka\ProductsFormat',
		'App\Console\Commands\SendFilesFIFCO\Azteka\SaleFormat',
		'App\Console\Commands\SendFilesFIFCO\Jucasoto\CustomerFormat',
		'App\Console\Commands\SendFilesFIFCO\Jucasoto\CameraFormat',
		'App\Console\Commands\SendFilesFIFCO\Jucasoto\ProductsFormat',
		'App\Console\Commands\SendFilesFIFCO\Jucasoto\SaleFormat',
		'App\Console\Commands\SendFilesFIFCO\PZJota\CustomerFormat',
		'App\Console\Commands\SendFilesFIFCO\PZJota\CameraFormat',
		'App\Console\Commands\SendFilesFIFCO\PZJota\ProductsFormat',
		'App\Console\Commands\SendFilesFIFCO\PZJota\SaleFormat',
		'App\Console\Commands\SendFilesFIFCO\Elimurgue\CustomerFormat',
		'App\Console\Commands\SendFilesFIFCO\Elimurgue\CameraFormat',
		'App\Console\Commands\SendFilesFIFCO\Elimurgue\ProductsFormat',
		'App\Console\Commands\SendFilesFIFCO\Elimurgue\SaleFormat',
		'App\Console\Commands\SendFilesFIFCO\Virginia\CustomerFormat',
		'App\Console\Commands\SendFilesFIFCO\Virginia\CameraFormat',
		'App\Console\Commands\SendFilesFIFCO\Virginia\ProductsFormat',
		'App\Console\Commands\SendFilesFIFCO\Virginia\SaleFormat'
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

	    $schedule->command('PZJota:CustomerFormat')
		    ->everyMinute();
	    $schedule->command('PZJota:cameraFormat')
		    ->everyMinute();
	    $schedule->command('PZJota:productFormat')
		    ->everyMinute();
	    $schedule->command('PZJota:saleFormat')
		    ->everyMinute();

	    $schedule->command('Alvasol:CustomerFormat')
		    ->everyMinute();
	    $schedule->command('Alvasol:cameraFormat')
		    ->everyMinute();
	    $schedule->command('Alvasol:productFormat')
		    ->everyMinute();
	    $schedule->command('Alvasol:saleFormat')
		    ->everyMinute();

	    $schedule->command('Azteka:CustomerFormat')
		    ->everyMinute();
	    $schedule->command('Azteka:cameraFormat')
		    ->everyMinute();
	    $schedule->command('Azteka:productFormat')
		    ->everyMinute();
	    $schedule->command('Azteka:saleFormat')
		    ->everyMinute();

	    $schedule->command('Elimurgue:CustomerFormat')
		    ->everyMinute();
	    $schedule->command('Elimurgue:cameraFormat')
		    ->everyMinute();
	    $schedule->command('Elimurgue:productFormat')
		    ->everyMinute();
	    $schedule->command('Elimurgue:saleFormat')
		    ->everyMinute();

	    $schedule->command('faca:CustomerFormat')
		    ->everyMinute();
	    $schedule->command('faca:cameraFormat')
		    ->everyMinute();
	    $schedule->command('faca:productFormat')
		    ->everyMinute();
	    $schedule->command('faca:saleFormat')
		    ->everyMinute();

	    $schedule->command('Virginia:CustomerFormat')
		    ->everyMinute();
	    $schedule->command('Virginia:cameraFormat')
		    ->everyMinute();
	    $schedule->command('Virginia:productFormat')
		    ->everyMinute();
	    $schedule->command('Virginia:saleFormat')
		    ->everyMinute();

	    $schedule->command('Jagris:CustomerFormat')
		    ->everyMinute();
	    $schedule->command('Jagris:cameraFormat')
		    ->everyMinute();
	    $schedule->command('Jagris:productFormat')
		    ->everyMinute();
	    $schedule->command('Jagris:saleFormat')
		    ->everyMinute();

	    $schedule->command('Jucasoto:CustomerFormat')
		    ->everyMinute();
	    $schedule->command('Jucasoto:cameraFormat')
		    ->everyMinute();
	    $schedule->command('Jucasoto:productFormat')
		    ->everyMinute();
	    $schedule->command('Jucasoto:saleFormat')
		    ->everyMinute();
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
