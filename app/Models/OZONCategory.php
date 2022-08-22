<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OZONCategory extends Model
{
    use HasFactory;

    protected $table = 'ozon_categories';

    protected $fillable = [
        'oz_category_id', 'name', 'parent_id', 'created_at', 'updated_at'
    ];

    public static function exists($id)
    {
        $result = OZONCategory::where(['oz_category_id' => $id])->first();
        return ($result) ? true : false;
    }
}
