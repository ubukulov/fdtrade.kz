<?php

namespace App\Console\Commands\Ozon;

use App\Models\Product;
use Illuminate\Console\Command;

class SyncProducts extends Command
{
    protected $items = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ozon:sync-products';

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
                if($product->getQuantity() == 0) {
                    continue;
                }

                $arr = [
                    'name' => $product->name,
                    'price' => $product->price,
                ];

                $images = $product->images;
                if(count($images) <= 1) {
                    continue;
                } else {
                    foreach($images as $image) {
                        if($image->thumbs == 1) {
                            $arr['images360'] = $image->path;
                        } else {
                            $arr['images'][] = $image->path;
                        }
                    }
                }

                
            }
        });
    }
}
