<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $table = 'categories';
    protected $fillable = [
        'foreign_id', 'name', 'left', 'right', 'level', 'elements', 'margin', 'margin_halyk', 'margin_ozon'
    ];
    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
