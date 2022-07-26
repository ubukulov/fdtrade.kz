<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;
class HK extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'hk';
    }
}
