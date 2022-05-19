<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlWbCategory extends Model
{
    use HasFactory;

    protected $table = 'al_wb_categories';
    protected $fillable = [
        'al_category_id', 'wb_category_id'
    ];
    protected $dates = [
        'created_at', 'updated_at'
    ];
}
