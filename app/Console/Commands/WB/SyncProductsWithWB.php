<?php

namespace App\Console\Commands\WB;

use App\Models\AlWbCategory;
use App\Models\Product;
use App\Models\WBCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use WB;

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
                    ->whereNotNull('wb_imtId')
                    ->limit(50)
                    ->get();
                $wb_category = WBCategory::findOrFail($al_wb_category->wb_category_id);

                if(count($products) > 0) {
                    foreach($products as $product) {
                        $wbProduct = WB::getProductByArticle($product);

                        if($wbProduct->error) {
                            continue;
                        }

                        $response = WB::uploadProduct($product, $wb_category);
                        if(!$response) {
                            $this->info("Product {$product->article} don't created. Cannot get properties from Al-style.kz");
                            continue;
                        }

                        if(isset($response->error) && $response->error) {
                            $this->info("Product {$product->article} don't created. ". $response->errorText);
                            continue;
                        }

                        if(isset($response->error) && !$response->error) {
                            $this->info("The product with $product->article successfully added.");
                        }
                    }
                }
            }

            $this->info('The process "sync-products-with-wb" is finished.');
        }
    }
}
