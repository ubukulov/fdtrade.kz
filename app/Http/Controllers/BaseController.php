<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use View;

class BaseController extends Controller
{
    public function __construct()
    {
        $categories = Category::whereIn('id', [2,36,78,89,142,174,215,234,567,568, 569])->get();
        $randomProducts = Product::whereNotNull('price')->inRandomOrder()->limit(20)->get();
        View::share('categories', $categories);
        View::share('randomProducts', $randomProducts);
    }
}
