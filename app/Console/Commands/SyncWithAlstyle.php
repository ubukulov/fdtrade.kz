<?php

namespace App\Console\Commands;

use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Style;

class SyncWithAlstyle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:price-and-quantity-with-al-style';

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
        $priceAndQuantity  = Style::getProductPriceAndQuantity(40219);
        dd($priceAndQuantity);
        Product::chunk(50, function($products){
            foreach($products as $product) {
                $priceAndQuantity  = Style::getProductPriceAndQuantity($product->article);
                if(isset($priceAndQuantity[$product->article])) {
                    $product->quantity = $priceAndQuantity[$product->article]->quantity;
                    $product->price1   = $priceAndQuantity[$product->article]->price1;
                    $product->price2   = $priceAndQuantity[$product->article]->price2;
                    $product->save();

                    $category = $product->category;
                    if($category) {
                        $product->price = $priceAndQuantity[$product->article]->price2 + ($priceAndQuantity[$product->article]->price2 * ($category->margin / 100));
                        $product->updated_at = Carbon::now();
                        $product->save();

                        $this->info("Sync with Al: Product {$product->article} is updated.");
                    }
                }
            }
        });
        $this->info('Process is finished.');
    }
}
