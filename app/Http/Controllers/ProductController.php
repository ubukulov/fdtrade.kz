<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Style;

class ProductController extends BaseController
{
    public function detail($categoryId, $productId)
    {
        $product = Product::findOrFail($productId);
        $product_feature = Style::getProductFeature($product->article);
        return view('product.detail', compact('product', 'product_feature', 'categoryId'));
    }
}
