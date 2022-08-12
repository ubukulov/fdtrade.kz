<?php

namespace App\Console;

use App\Console\Commands\GenerateXalykXml;
use App\Console\Commands\SyncHalyk;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\SyncProductsWithWB;
use App\Console\Commands\SyncWithAlstyle;
use App\Console\Commands\WBUpdateStocks;
use App\Console\Commands\WBUpdatePrices;
use App\Console\Commands\GetWbImtIdForProduct;
use App\Console\Commands\GetActualRates;

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
        WBUpdateStocks::class,
        WBUpdatePrices::class,
        GetWbImtIdForProduct::class,
        GetActualRates::class,
        GenerateXalykXml::class,
        SyncHalyk::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        /* WB */
         //$schedule->command('sync:products-with-wb')->everyFiveMinutes();
         //$schedule->command('wb:get-imtId-for-product')->everyTenMinutes();
         $schedule->command('sync:price-and-quantity-with-al-style')->everyFifteenMinutes();
         $schedule->command('wb:update-stocks')->everyThirtyMinutes();
         $schedule->command('wb:update-prices')->everyFourHours();

         /* Halyk */
         $schedule->command('generate:halyk-xml')->everyTwoHours();
         //$schedule->command('sync:halyk')->everyThreeHours();

         /* Get Actual Rates */
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
