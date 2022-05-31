<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExchangeRate extends Model
{
    use HasFactory;

    protected $table = 'exchange_rates';

    protected $fillable = [
        'KZT', 'EUR', 'USD', 'RUB', 'date'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];
}
