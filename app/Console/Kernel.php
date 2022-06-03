<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SyncProductsWithWB;
use App\Console\Commands\SyncWithAlstyle;
use App\Console\Commands\SyncProductPricesAndQuantityWB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SyncProductsWithWB::class,
        SyncWithAlstyle::class,
        SyncProductPricesAndQuantityWB::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('sync:products-with-wb')->everyFifteenMinutes();
         $schedule->command('wb:get-imtId-for-product')->everyThirtyMinutes();
         $schedule->command('sync:price-and-quantity-with-al-style')->hourly();
         $schedule->command('wb:sync-product-prices-and-quantity')->everyTwoHours();
         $schedule->command('get:actual-rates')->cron('0 8 * * *');
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
