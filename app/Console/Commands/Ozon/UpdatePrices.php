<?php

namespace App\Console\Commands\Ozon;

use App\Models\Product;
use Illuminate\Console\Command;
use OZON;

class UpdatePrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ozon:update-prices';

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
        $oProductsLists = OZON::getProducts();
        if($oProductsLists != false) {
            $oProductsLists = json_decode($oProductsLists);
            $items = collect($oProductsLists->result->items);
            $items = $items->chunk(100);
            foreach($items as $item) {

                // Первые 100 товаров
                $data['prices'] = [];
                foreach($item as $prod) {
                    $product = Product::where(['article' => $prod->offer_id])->first();
                    if($product) {
                        $category = $product->category;
                        $price = $product->price2 + ($product->price2 * ($category->margin_ozon / 100));
                        $price = $product->convertPrice('RUB', $price);
                        $oldPrice = $price * 2;

                        $data['prices'][] = [
                            'offer_id' => (string) $product->article,
                            'price' => (string) $price,
                            'old_price' => (string) $oldPrice,
                            'premium_price' => "0",
                            'min_price' => "0",
                            'currency_code' => "RUB",
                            'auto_action_enabled' => "UNKNOWN",
                        ];
                    }
                }

                $response = OZON::updatePrices($data);

                if(!empty($response->errors)) {
                    $this->info("Products prices failed.");
                }

                if(isset($response->result) && $response->result[0]->updated) {
                    $this->info(count($data['prices']) . " Ozon products prices updated.");
                } else {
                    $this->info("Ozon products prices failed.");
                }

            }
        } else {
            $this->info("Cannot get list of products from OZON");
        }
    }
}
