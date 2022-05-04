<?php


namespace App\Providers;

use App\Classes\Style;
use Illuminate\Support\ServiceProvider;

class StyleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('style', Style::class);
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
