<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class StyleBrand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'style:brand';

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
        Product::chunk(100, function($products){
            foreach($products as $product) {
                $product_feature = Style::getProductFeature($product->article);
                if(isset($product_feature[0])) {
                    $brand = $product_feature[0]->brand;
                    $product->brand = $brand;
                    $product->save();
                }
            }
        });
        $this->info('The finished.');
    }
}
