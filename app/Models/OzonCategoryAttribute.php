<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OzonCategoryAttribute extends Model
{
    use HasFactory;

    protected $table = 'ozon_category_attributes';
    protected $fillable = [
        'ozon_category_id', 'attribute_id', 'name', 'description', 'type', 'is_collection', 'is_required', 'group_id', 'group_name',
        'dictionary_id', 'created_at', 'updated_at'
    ];

    public function ozon_category()
    {
        return $this->belongsTo(OZONCategory::class);
    }

    public static function exists($category_id, $attribute_id)
    {
        $result = OzonCategoryAttribute::where(['ozon_category_id' => $category_id, 'attribute_id' => $attribute_id])->first();
        return ($result) ? true : false;
    }
}
