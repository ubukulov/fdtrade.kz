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
        if($oProductsLists != false) {
            $oProductsLists = json_decode($oProductsLists);
            $count = 0;
            foreach($oProductsLists->result->items as $item) {
                $product = Product::where(['article' => $item->offer_id])->first();
                if($product) {
                    $data['stocks'][] = [
                        'offer_id' => (string) $product->article,
                        'stock' => (int) $product->getQuantity()
                    ];

                    if($count == 100) {
                        $response = OZON::updateStocks($data);

                        if(!$response) {
                            $this->info("$count products stocks failed.");
                        }

                        $response = json_decode($response);
                        if(isset($response->result) && $response->result[0]->updated) {
                            $this->info("$count ozon products stocks updated.");
                            $data['stocks'] = [];
                        } else {
                            $this->info("Ozon products stocks failed.");
                        }
                    } else {
                        $count++;
                    }
                }
            }
        } else {
            $this->info("Cannot get list of products from OZON");
        }
    }
}
