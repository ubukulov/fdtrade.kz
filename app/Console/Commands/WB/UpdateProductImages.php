<?php

namespace App\Console\Commands\WB;

use App\Models\Product;
use Illuminate\Console\Command;
use WB;

class UpdateProductImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wb:update-product-images';

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
            $lists = WB::getProductCardList($limit, $offset);
            foreach($lists->data->cards as $card) {
                if(empty($card->mediaFiles)) {
                    $product = Product::where(['wb_imtId' => $card->vendorCode])->first();
                    if($product) {
                        $product_images = [];
                        $images = $product->images;

                        if($images) {
                            foreach($images as $image) {
                                if($image->thumbs == 0) {
                                    $product_images[]['value'] = $image->path;
                                }
                            }
                        }

                        $arrImages = [];
                        if(count($product_images) > 1) {
                            foreach($product_images as $key=>$arr) {
                                if($key == 0) {
                                    continue;
                                }

                                $arrImages[] = $arr['value'];
                            }
                        }

                        if(count($arrImages) > 0) {
                            $response = WB::updateProductImages($product->wb_imtId, $arrImages);
                            if($response){
                                $this->info("Product ".$card->vendorCode." images updated.");
                            }
                        }
                    }
                }
            }
            $this->info("----------------------------------------------------");
        }


        $this->info("Product Images process is finished.");*/
    }
}
