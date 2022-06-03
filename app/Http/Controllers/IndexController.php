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
        $product = Product::whereArticle(30948)->first();
        $wl_category = WBCategory::find(2573);
        dd(WB::getProductByImtId($product));
//        dd(WB::getProductStocks());
//        dd(WB::updateStocks($product));
//        dd(WB::updatePrices($product, 84317767));
//        $barcode = json_decode(WB::getGeneratedBarcodeForProduct());
//        dd($barcode->result->barcodes[0]);
//        dd(WB::createProduct($product, $wl_category));
//        $ss = Style::getProductFeature($product->article);
//        $ss = (array) $ss[0]->properties;
//        dd($ss);
//        $p = Style::getProductPriceAndQuantity(19708);
//        dd($p['19708']->price1);
        $getProductCardList = WB::getProductCardList();
        dd($getProductCardList);
        $arr = [];
        foreach ($getProductCardList->result->cards as $card) {
            if($card->supplierVendorCode == 'MS212') {
                //dd($card);
            }
        }

        dd($arr);
//        dd(WB::getProductByImtId($product));
//        dd(Style::getProductFeature($product->article));

//        $wb_product = WB::getProductByImtId($product);
//        dd(WB::updateProduct($wb_product, $product));
    }
}
