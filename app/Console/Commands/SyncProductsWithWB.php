<?php

namespace App\Console\Commands;

use App\Models\AlWbCategory;
use App\Models\Product;
use App\Models\WBCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use WB;
use Artisan;

class SyncProductsWithWB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:products-with-wb';

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
        $al_wb_categories = AlWbCategory::all();
        if(count($al_wb_categories) > 0) {
            foreach($al_wb_categories as $al_wb_category) {
                $products = Product::where(['category_id' => $al_wb_category->al_category_id])
                    ->where('price', '<>', 0)
                    ->whereNull('wb_imtId')
                    ->get();
                $wb_category = WBCategory::findOrFail($al_wb_category->wb_category_id);

                if(count($products) > 0) {
                    foreach($products as $product) {
                        $response = WB::createProduct($product, $wb_category);
                        $response = json_decode($response);
                        if(isset($response->result)) {
                            $this->info("The product with $product->id successfully added.");
                        } else {
                            $this->info("The product with $product->id failed.");
                        }
                    }

                    Artisan::call('wb:get-imtId-for-product');
                }

            }

            //DB::update("DELETE FROM al_wb_categories");

            $this->info('The process "sync-products-with-wb" is finished.');
        }
    }
}
