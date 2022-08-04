<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MarketPlace extends Model
{
    use HasFactory;

    protected $table = 'marketplaces';

    protected $fillable = [
        'title', 'api', 'client_id', 'client_secret', 'access_token', 'refresh_token', 'expires_in', 'token_type', 'expires_date'
    ];
}
