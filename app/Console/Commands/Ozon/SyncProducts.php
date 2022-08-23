<?php

namespace App\Console\Commands\Ozon;

use App\Models\AlOzCategory;
use App\Models\OZONCategory;
use App\Models\Product;
use Illuminate\Console\Command;
use OZON;

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
        /*$al_oz_categories = AlOzCategory::all();
        if(count($al_oz_categories) > 0) {
            foreach($al_oz_categories as $al_oz_category) {
                $products = Product::where(['category_id' => $al_oz_category->al_category_id])
                    ->where('price', '<>', 0)
                    ->limit(50)
                    ->get();
                $oz_category = OZONCategory::findOrFail($al_oz_category->oz_category_id);*/
                $oz_category = OZONCategory::findOrFail(9828);

                //if(count($products) > 0) {
                    //foreach($products as $product) {
                        $product = Product::find(500);
                        $category = $product->category;
                        $price = $product->price2 + ($product->price2 * ($category->margin_ozon / 100));
                        $price = $product->convertPrice('RUB', $price);
                        $arr = [
                            'name' => $product->name,
                            'price' => $price,
                            'category_id' => $oz_category->oz_category_id,
                        ];

                        // Картинки
                        $images = $product->images;
                        if(count($images) <= 1) {
                            //continue;
                        } else {
                            foreach($images as $image) {
                                if($image->thumbs == 1) {
                                    $arr['images360'] = $image->path;
                                } else {
                                    $arr['images'][] = $image->path;
                                }
                            }
                        }

                        $response = OZON::createOrUpdate($arr);

                        if(!$response) {
                            $this->info("Product {$product->article} don't created.");
                            //continue;
                        }

                        $response = json_decode($response);
                        if(isset($response->result)) {
                            $this->info("The product with $product->article successfully added.");
                        } else {
                            $this->info("The product with $product->article failed.");
                        }
                    //}
                //}
           // }

            $this->info('The process "ozon:sync-products" is finished.');
       // }
    }
}
