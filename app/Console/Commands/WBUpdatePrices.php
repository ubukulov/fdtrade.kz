<?php

namespace App\Console\Commands;

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
        foreach($getProductCardList->result->cards as $item) {
            if(!empty($item->supplierVendorCode)) {
                $product = Product::where(['article' => $item->supplierVendorCode])->first();
                if($product && isset($item->nomenclatures[0])) {
                    $updatePrices = json_decode(WB::updatePrices($product, $item->nomenclatures[0]->nmId));
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
