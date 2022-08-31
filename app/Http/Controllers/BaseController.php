<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use View;

class BaseController extends Controller
{
    public function __construct()
    {
        $categories = Category::whereIn('id', [1,13,78,89,142,174,215,234,239,275,420,456, 459])->get();
        View::share('categories', $categories);
    }
}
