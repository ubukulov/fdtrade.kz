<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\WBCategory;
use Illuminate\Http\Request;
use WB;
use Style;
use HK;

class IndexController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function halykXml()
    {
        $xml = HK::createOrUpdate();
        return response()->view('xml', $xml, 200)->header('Content-Type', 'text/xml');
    }
}
