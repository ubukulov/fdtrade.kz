<?php

namespace App\Console\Commands\WB;

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
            $product = Product::where(['article' => (int) $card->supplierVendorCode])
                ->whereNull('wb_imtId')
                ->first();
            if($product) {
                $product->wb_imtId      = $card->imtId;
                $product->wb_barcode    = $card->nomenclatures[0]->variations[0]->barcodes[0];
                $product->save();
                $this->info("The product with article {$product->article} has imtId successfully.");
            } else {
                $this->info("The product with article {$card->supplierVendorCode} don't found.");
            }
        }
        $this->info('The process is finished.');
    }
}
