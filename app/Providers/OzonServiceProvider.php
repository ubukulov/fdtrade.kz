<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Classes\Ozon;

class OzonServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('ozon', Ozon::class);
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
