<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\WBCategory;
use Illuminate\Http\Request;
use WB;
use Style;

class IndexController extends Controller
{
    public function index()
    {
        $product = Product::findOrFail(12);
        $wl_category = WBCategory::find(2786);
//        dd(WB::getProductStocks());
//        dd(WB::updateStocks($product));
//        $barcode = json_decode(WB::getGeneratedBarcodeForProduct());
//        dd($barcode->result->barcodes[0]);
//        dd(WB::createProduct($product, $wl_category));
//        $ss = json_decode(Style::getProductFeature($product->article));
//        $ss = (array) $ss[0]->properties;
//        dd($ss);
//        $p = Style::getProductPriceAndQuantity(19708);
//        dd($p['19708']->price1);
        $getProductCardList = WB::getProductCardList();
        dd($getProductCardList);
        dd(WB::getProductByImtId($product));
    }
}
