<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlOzCategory extends Model
{
    use HasFactory;

    protected $table = 'al_oz_categories';
    protected $fillable = [
        'al_category_id', 'oz_category_id'
    ];
    protected $dates = [
        'created_at', 'updated_at'
    ];
}
