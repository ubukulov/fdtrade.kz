<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Style;

class GenerateXalykXml extends Command
{
    protected $contents = '';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:halyk-xml';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?><merchant_offers date="string"
                 xmlns="halyk_market"
                 xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
                 <company>FastDev Trade</company>
                 <merchantid>830706301762</merchantid><brand>FastDev Trade</brand><offers>
                ';

        Product::chunk(100, function($products){
            foreach($products as $product) {
                $qty = $product->getQuantity();
                if($qty == 0) {
                    continue;
                }

                $category = $product->category;
                if($category) {
                    $product_feature = Style::getProductFeature($product->article);
                    if(isset($product_feature[0])) {
                        $brand = $product_feature[0]->brand;
                        $price = $product->price2 + ($product->price2 * ($category->margin_halyk / 100));
                        $this->contents .= '<offer sku="'.$product->article.'">';
                        $this->contents .= '<model>'.$product->name.'</model>';
                        $this->contents .= '<brand>'.$brand.'</brand>';
                        $this->contents .= '<stocks>';
                        for($i=1; $i<=22; $i++) {
                            $storeId = 'fastdev_pp' . $i;
                            $this->contents .= '<stock available="yes" stockLevel="'.$qty.'" storeId="'.$storeId.'"/>';
                        }
                        $this->contents .= '</stocks>';
                        $this->contents .= '<price>'.$price.'</price>';
                        $this->contents .= '<loanPeriod>24</loanPeriod>';
                        $this->contents .= '</offer>';
                    }
                }
            }
        });

        $xml .= $this->contents . '</offers></merchant_offers>';
        Storage::disk('public')->put('halyk/stocks.xml', $xml);

        $this->info('Halyk XML file is successfully generated.');
    }
}