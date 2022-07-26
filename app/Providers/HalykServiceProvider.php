<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Classes\Halyk;

class HalykServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('hk', Halyk::class);
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
