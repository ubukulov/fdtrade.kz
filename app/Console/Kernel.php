<?php

namespace App\Console;

use App\Console\Commands\Halyk\GenerateXalykXml;
use App\Console\Commands\Halyk\SyncHalyk;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\WB\SyncProductsWithWB;
use App\Console\Commands\Style\SyncWithAlstyle;
use App\Console\Commands\WB\WBUpdateStocks;
use App\Console\Commands\WB\WBUpdatePrices;
use App\Console\Commands\WB\GetWbImtIdForProduct;
use App\Console\Commands\GetActualRates;
use App\Console\Commands\Ozon\UpdateStocks;
use App\Console\Commands\Ozon\UpdatePrices;


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
        SyncHalyk::class,
        UpdateStocks::class,
        UpdatePrices::class,
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
         //$schedule->command('wb:update-stocks')->everyThirtyMinutes();
         //$schedule->command('wb:update-prices')->everyFourHours();

         /* Halyk */
         $schedule->command('generate:halyk-xml')->everyTwoHours();
         //$schedule->command('sync:halyk')->everyThreeHours();

        /* OZON */
        $schedule->command('ozon:update-stocks')->everyTwoHours();
        $schedule->command('ozon:update-prices')->everyFourHours();

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
