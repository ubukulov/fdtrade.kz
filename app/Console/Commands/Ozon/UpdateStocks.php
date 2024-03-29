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

    protected $i = 1000;
    protected $allCountProducts = 3000;
    protected $last_id = "";

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
        try {
            while ($this->i <= $this->allCountProducts) {
                $oProductsLists = OZON::getProducts($this->i, $this->last_id);
                $oProductsLists = json_decode($oProductsLists);
                $count = count($oProductsLists->result->items);
                if($count == 0) {
                    break;
                }

                if($oProductsLists != false) {
                    $items = collect($oProductsLists->result->items);
                    $items = $items->chunk(100);
                    foreach($items as $item) {

                        // Первые 100 товаров
                        $data['stocks'] = [];
                        foreach($item as $prod) {
                            $product = Product::where(['article' => $prod->offer_id])->first();
                            if($product) {
                                $data['stocks'][] = [
                                    'offer_id' => (string) $product->article,
                                    'stock' => (int) $product->getQuantity()
                                ];
                            }
                        }

                        $response = OZON::updateStocks($data);

                        if(!empty($response->errors)) {
                            $this->info("Products stocks failed.");
                        }

                        if(isset($response->result) && $response->result[0]->updated) {
                            $this->info(count($data['stocks']) . " Ozon products stocks updated.");
                        } else {
                            $this->info("Ozon products stocks failed.");
                        }

                    }
                } else {
                    $this->info("Cannot get list of products from OZON: last_id=".$this->last_id);
                }

                $this->last_id = $oProductsLists->result->last_id;
                $this->i += 1000;
            }

            $this->info("The process is completed.");
        } catch (\Exception $exception) {
            $this->info("Ошибка: " . $exception->getMessage());
        }
    }
}
