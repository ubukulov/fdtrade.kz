<?php

namespace App\Console\Commands\WB;

use App\Models\Product;
use Illuminate\Console\Command;
use WB;

class WBUpdateStocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wb:update-stocks';

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
            Product::whereNotNull('wb_imtId')->chunk(100, function($products){
                foreach($products as $product) {
                    if($product->category_id == 7 || $product->category_id == 208){
                        continue;
                    }

                    if($product->getQuantity() == 0) {
                        if(WB::getStocks($product->wb_barcode)) {
                            if(WB::deleteStocks($product->wb_barcode)) {
                                $this->info("Product: {$product->article} deleted in Stocks.");
                            }
                        }

                    }

                    $hasProductInWB = WB::getProductByArticle($product->wb_imtId);

                    if(empty($hasProductInWB->data)) {
                        $this->info("Product: {$product->article} not found.");
                        continue;
                    }

                    $price = $product->convertPrice();
                    if($price < 1000) {
                        $updateStocks = json_decode(WB::cancelStocks($product));
                    } else {
                        $updateStocks = json_decode(WB::updateStocks($product));
                    }

                    if(isset($updateStocks->error)) {
                        $this->info("Product: {$product->article} stocks failed.");
                    } else {
                        $this->info("Product: {$product->article} stocks success.");
                    }
                }
            });
            $this->info('Process completed.');
        } catch (\Exception $exception) {
            $this->info("Ошибка: " . $exception->getMessage());
        }
    }
}
