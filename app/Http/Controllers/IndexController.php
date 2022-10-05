<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\WBCategory;
use Illuminate\Http\Request;
use WB;
use Style;
use HK;

class IndexController extends BaseController
{
    public function index()
    {
        dd(Style::getProductFeature(8611));
        $hitProducts = Product::whereNotNull('price')->inRandomOrder()->limit(4)->get();
        $bestsellerProducts = Product::whereNotNull('price')->inRandomOrder()->limit(6)->get();
        $randomProducts = Product::whereNotNull('price')->inRandomOrder()->limit(20)->get();
        return view('welcome', compact('hitProducts', 'bestsellerProducts', 'randomProducts'));
    }

    public function halykXml()
    {
        $xml = HK::createOrUpdate();
        return response()->view('xml', $xml, 200)->header('Content-Type', 'text/xml');
    }

    public function catProducts($catId)
    {
        $products = Product::where(['category_id' => $catId])->get();
        return view('cat_products', compact('products'));
    }

    public function productInfo($article)
    {
        $info = Style::getProductFeature($article);
        dd($info);
    }
}
