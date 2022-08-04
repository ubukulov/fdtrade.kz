<?php


namespace App\Classes;

use App\Models\MarketPlace;
use App\Models\Product;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Psr7;
use Style;

class Halyk
{
    protected $api = '';
    protected $goods = '';
    protected $access_token = '';

    public function __construct()
    {
        $marketplace = MarketPlace::where(['title' => 'halykmarket'])->first();
        if(!$marketplace) {
            abort(500, 'В таблице marketplaces отсутствует запись про Халык Маркет');
        }

        $this->api = $marketplace->api;

        if(is_null($marketplace->expires_date) || Carbon::now()->gt($marketplace->expires_date)) {
            $client = new Client(['base_uri' => $this->api]);
            $data = [
                'grant_type' => 'client_credentials',
                'client_id' => $marketplace->client_id,
                'client_secret' => $marketplace->client_secret
            ];

            $request = $client->request('POST', 'auth', [
                'headers' => [
                    'Content-type' => 'application/json'
                ],
                'body' => json_encode($data)
            ]);

            $res = json_decode($request->getBody()->getContents());

            if(isset($res->success) && $res->success) {
                $marketplace->access_token = $res->access_token;
                $marketplace->token_type = $res->token_type;
                $marketplace->expires_date = Carbon::now()->addSeconds($res->expires_in);
                $marketplace->save();

                $this->access_token = $res->access_token;
            } else {
                abort(500, 'Ошибка при получение токена. Попробуйте позже');
            }
        } else {
            $this->access_token = $marketplace->access_token;
        }
    }

    public function generateXml()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?><merchant_offers date="string"
 xmlns="halyk_market"
 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
 <company>FastDev Trade</company>
 <merchantid>830706301762</merchantid><brand>Brand test</brand><offers>
';

        $products = Product::limit(50)->get();
        foreach($products as $product) {
            $qty = $product->getQuantity();
            if($qty != 0) {
                $product_feature = Style::getProductFeature($product->article);
                if(isset($product_feature[0])) {
                    $brand = $product_feature[0]->brand;
                    //$barcode = $product_feature[0]->barcode;

                    $this->goods .= '<offer sku="'.$product->article.'">';
                    $this->goods .= '<model>'.$product->name.'</model>';
                    $this->goods .= '<brand>'.$brand.'</brand>';
                    $this->goods .= '<stocks>';
                    for($i=1; $i<=22; $i++) {
                        $storeId = 'fastdev_pp' . $i;
                        $this->goods .= '<stock available="yes" stockLevel="'.$qty.'" storeId="'.$storeId.'"/>';
                    }
                    $this->goods .= '</stocks>';
                    $this->goods .= '<price>'.$product->price.'</price>';
                    $this->goods .= '<loanPeriod>24</loanPeriod>';
                    $this->goods .= '</offer>';
                }
            }
        }

        //$product = Product::find(3);


        /*Product::chunk(100, function($products){
            foreach($products as $product) {
                $qty = $product->getQuantity();
                if($qty == 0) {
                    continue;
                }

                $this->goods .= '<good sku="'.$product->article.'">';
                $this->goods .= '<name>'.$product->name.'</name>';
                $this->goods .= '<stocks>';
                for($i=1; $i<=22; $i++) {
                    $storeId = 'fastdev_pp' . $i;
                    $this->goods .= '<stock availability="'.$qty.'" storeId="'.$storeId.'"/>';
                }
                $this->goods .= '</stocks>';
                $this->goods .= '<price>'.$product->price.'</price>';
                $this->goods .= '<loanPeriod>24</loanPeriod>';
                $this->goods .= '</good>';
            }
        });*/

        $xml .= $this->goods . '</offers></merchant_offers>';
        Storage::disk('public')->put('halyk/stocks.xml', $xml);
    }

    public function createOrUpdate()
    {
        //$this->generateXml();
        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('POST', 'offers/upload', [
            'headers' => [
                'Authorization' => "Bearer " . $this->access_token,
                'Content-type' => 'multipart/form-data'
            ],
            'multipart' => [
                /*[
                    'name' => 'stocks-' . date('Y-m-d H:i:s'),
                    'contents' => fopen(public_path() . '/storage/halyk/stocks.xml', 'r')
                ],*/
                [
                    'name'     => 'stockss',
                    'contents' => file_get_contents(public_path() . '/storage/halyk/stocks.xml'),
                    'filename' => 'stocks.xml'
                ],
            ]
        ]);

        dd($request->getBody()->getContents());
    }
}
