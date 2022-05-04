<?php


namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Style extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'style';
    }
}
