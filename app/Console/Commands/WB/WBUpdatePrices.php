<?php

namespace App\Console\Commands\WB;

use App\Models\Product;
use Illuminate\Console\Command;
use WB;

class WBUpdatePrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wb:update-prices';

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
        /*for($i=1000; $i<=8000; $i = $i + 1000) {
            $limit = 1000;
            $offset = ($i == 1000) ? 0 : 1000;
            $getProductCardList = WB::getProductCardList($limit, $offset);
            foreach($getProductCardList->data->cards as $item) {
                if(!empty($item->vendorCode)) {
                    $product = Product::where(['wb_barcode' => $item->sizes[0]->skus[0]])->first();
                    if($product) {
                        $updatePrices = json_decode(WB::updatePrices($product, $item->nmID));
                        if(isset($updatePrices->errors)) {
                            $this->info("Product: {$product->article} prices failed.");
                        } else {
                            $this->info("Product: {$product->article} prices success.");
                        }
                    }
                }
            }
            $this->info('+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++');
        }
        $this->info('Process completed.');*/

        Product::whereNotNull('wb_imtId')->chunk(100, function($products){
            foreach($products as $product) {
                $wb_product = WB::getProductByArticle($product->wb_imtId);

                if(empty($wb_product->data) || is_null($wb_product->data)) {
                    $this->info("Product: {$product->article} not found.");
                    continue;
                }

                $category = $product->category;
                if($category){
                    $price = $product->getPriceForMarketPlace($category->margin);

                    $updatePrices = WB::updatePrices($price, $wb_product->data[0]->nmID);

                    if(!$updatePrices) {
                        $this->info("Product: {$product->article} prices not updated.");
                        continue;
                    }

                    $updatePrices = json_decode($updatePrices);

                    if(isset($updatePrices->uploadId) && $updatePrices->uploadId > 0) {
                        $this->info("Product: {$product->article} prices success.");
                    } else {
                        $this->info("Product: {$product->article} prices failed.");
                    }
                } else {
                    $this->info("Product: {$product->article} not found category.");
                }
            }
        });

        $this->info('Process completed.');
    }
}
