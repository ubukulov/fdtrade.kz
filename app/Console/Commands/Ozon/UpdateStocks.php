<?php

namespace App\Console\Commands\Ozon;

use App\Models\OZONCategory;
use App\Models\Product;
use Illuminate\Console\Command;
use OZON;

class UpdateStocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ozon:update-stocks';

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
        if(!$oProductsLists) {
            dd($oProductsLists);
        }

        /*$products = Product::where(['category_id' => 2])->get();
        $count = 0;

        foreach($products as $product) {
            $data['stocks'][] = [
                'offer_id' => (string) $product->article,
                'stock' => (int) $product->getQuantity()
            ];

            $count++;

            if($count == 100) {
                break;
            }
        }

        $response = OZON::updateStocks($data);

        if(!$response) {
            $this->info("Product {$product->article} stocks failed.");
        }

        $response = json_decode($response);
        if(isset($response->result) && $response->result[0]->updated) {
            $this->info("Ozon products stocks updated.");
        } else {
            $this->info("Ozon products stocks failed.");
        }*/
    }
}
