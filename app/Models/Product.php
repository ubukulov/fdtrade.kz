<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id', 'article', 'name', 'full_name', 'sort', 'price1', 'price2', 'price', 'quantity', 'isnew',
        'ishit', 'ispromo', 'article_pn', 'active', 'description', 'wb_imtId', 'wb_barcode'
    ];

    protected $dates = [
        'created_at', 'updated_at'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function thumb()
    {
        return $this->hasMany(ProductImage::class)->where('thumbs', 1);
    }

    public function attachments()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function getQuantity()
    {
        $quantity = str_replace('>', '', $this->quantity);
        $quantity = str_replace('<', '', $quantity);
        return (int) $quantity;
    }

    public function convertPrice($currency = 'RUB')
    {
        $exchange_rate = ExchangeRate::findOrFail(1);

        switch ($currency) {
            case "RUB":
                $converted_currency = $exchange_rate->RUB;
                break;

            case "EUR":
                $converted_currency = $exchange_rate->EUR;
                break;

            case "USD":
                $converted_currency = $exchange_rate->USD;
                break;

            default:
                $converted_currency = $exchange_rate->RUB;
                break;
        }

        return round($this->price * $converted_currency);
    }
}
