<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;
use WB;

class GetWbImtIdForProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wb:get-imtId-for-product';

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
        foreach ($getProductCardList->result->cards as $card) {
            $product = Product::where(['article' => $card->supplierVendorCode])->first();
            if($product) {
                $product->wb_imtId = $card->imtId;
                $product->save();
            }
        }
    }
}
