<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;
class Ozon extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ozon';
    }
}
