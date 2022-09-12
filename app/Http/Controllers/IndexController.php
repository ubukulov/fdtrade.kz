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
//        $str = "RE-JD 2002";
//        $str = "MG";
//        $str1 = preg_replace("/[0-9- ]/ui", "", $str);
//        $str2 = preg_replace("/[a-zA-Z- ]/ui", "", $str);
//        dd($str2);
//        $str = substr($str1,0,2) . "-" . substr($str1,2) . " " . $str2;
//        dd($str);
//        $str = "{\"items\":[{\"name\":\"Смартфон Xiaomi Redmi 9A 2\/32Gb Granite Gray\",\"price\":9065,\"category_id\":17030819,\"offer_id\":34061,\"vat\":0,\"weight\":100,\"depth\":10,\"width\":150,\"height\":250,\"images360\":[\"https:\/\/img.al-style.kz\/34061_01.jpg\"],\"images\":[\"https:\/\/img.al-style.kz\/34061_1.jpg\",\"https:\/\/img.al-style.kz\/34061_2.jpg\",\"https:\/\/img.al-style.kz\/34061_3.jpg\"],\"attributes\":[{\"complex_id\":0,\"id\":85,\"values\":{\"value\":\"Redmi \"}},{\"complex_id\":0,\"id\":4385,\"values\":{\"value\":\"1\"}},{\"complex_id\":0,\"id\":9048,\"values\":{\"value\":\"Смартфон Xiaomi Redmi 9A 2\/32Gb Granite Gray\"}},{\"complex_id\":0,\"id\":9331,\"values\":{\"value\":\"Русский\"}}]}]}";
//        dd(json_decode($str));
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
}
