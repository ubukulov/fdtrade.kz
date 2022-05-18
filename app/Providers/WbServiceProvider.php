<?php


namespace App\Providers;

use App\Classes\WB;
use Illuminate\Support\ServiceProvider;
class WbServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('wb', WB::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
