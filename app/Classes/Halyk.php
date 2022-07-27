<?php


namespace App\Classes;

use App\Models\Product;
use GuzzleHttp\Client;

class Halyk
{
    protected $clientId     = 'HMM_830706301762';
    protected $clientSecret = 'o4GePK6i$JPT$X^0';
    protected $api = 'https://api.halykmarket.com/api/merchant/v1/';
    protected $goods = '';

    public function createOrUpdate()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
                    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
                    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
                    xmlns:xhtml="http://www.w3.org/1999/xhtml"
                    xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
                </urlset>';

        Product::chunk(100, function($products){
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
        });

        $xml .= $this->goods . '</goods>';

        //return response()->xml($xml, 200, ['Content-Type' => 'text/xml']);

        return $xml;
    }
}
