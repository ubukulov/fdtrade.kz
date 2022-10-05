<?php

namespace App\Console\Commands\Style;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Console\Command;
use Style;

class GetStyleProductImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'style:get-product-images';

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
        Product::chunk(100, function($products) {
            foreach($products as $product) {
                $arrImages = Style::getProductInfo($product->article);
                foreach($arrImages['thumbs'] as $item) {
                    ProductImage::create([
                        'product_id' => $product->id, 'path' => $item, 'thumbs' => 1
                    ]);
                }

                foreach($arrImages['images'] as $item) {
                    ProductImage::create([
                        'product_id' => $product->id, 'path' => $item
                    ]);
                }
            }
        });

        $this->info('The process finished.');
    }
}
