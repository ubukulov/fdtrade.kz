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
        $getProductCardList = WB::getProductCardList();
        foreach($getProductCardList->data->cards as $item) {
            if(!empty($item->vendorCode)) {
                $product = Product::where(['wb_barcode' => $item->sizes[0]->skus[0]])->first();
                if($product) {
                    $updateStocks = json_decode(WB::updateStocks($product));
                    if($updateStocks->error) {
                        $this->info("Product: {$product->article} stocks failed.");
                    } else {
                        $this->info("Product: {$product->article} stocks success.");
                    }
                }
            }
        }
    }
}
