<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WBCategory extends Model
{
    use HasFactory;

    protected $table = 'wb_categories';
    protected $fillable = [
        'name', 'foreign_id', 'parent_id', 'rv'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];
}
