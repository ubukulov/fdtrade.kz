<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends BaseController
{
    public function show($categoryId)
    {
        $products = Product::where(['category_id' => $categoryId])->simplePaginate(9);
        return view('category.category', compact('products', 'categoryId'));
    }
}
