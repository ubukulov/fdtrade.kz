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
        $getProductCardList = WB::getProductCardList();
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
    }
}
