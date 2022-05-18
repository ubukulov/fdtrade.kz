<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;
class WB extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'wb';
    }
}
