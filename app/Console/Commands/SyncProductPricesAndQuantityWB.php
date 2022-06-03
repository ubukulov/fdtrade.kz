<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use WB;

class SyncProductPricesAndQuantityWB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wb:sync-product-prices-and-quantity';

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
        foreach($getProductCardList->result->cards as $item) {
            if(!empty($item->supplierVendorCode)) {
                $product = Product::where(['article' => $item->supplierVendorCode])->first();
                if($product) {
                    WB::updateStocks($product);
                    //WB::updatePrices($product, $item->nomenclatures[0]->nmId);
                }
            }
        }
    }
}
