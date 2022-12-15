<?php

namespace App\Console\Commands\Ozon;

use App\Models\AlOzCategory;
use App\Models\OZONCategory;
use App\Models\Product;
use Illuminate\Console\Command;
use OZON;
use Style;

class SyncProducts extends Command
{
    protected $items = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ozon:sync-products';

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
        /*$al_oz_categories = AlOzCategory::all();
        if(count($al_oz_categories) > 0) {
            foreach($al_oz_categories as $al_oz_category) {
                $products = Product::where(['category_id' => $al_oz_category->al_category_id])
                    ->where('price', '<>', 0)
                    ->limit(50)
                    ->get();
                $oz_category = OZONCategory::findOrFail($al_oz_category->oz_category_id);*/
                $oz_category = OZONCategory::findOrFail(10114);
                $products = Product::where(['category_id' => 133])->get();
                $count = 0;

                foreach($products as $product) {
                    $category = $product->category;
                    $price = $product->price2 + ($product->price2 * ($category->margin_ozon / 100));
                    $price = $product->convertPrice('RUB', $price);
                    $product_feature = Style::getProductFeature($product->article);

                    $arr = [
                        'name' => $product->name,
                        'price' => (string) $price,
                        'category_id' => $oz_category->oz_category_id,
                        'offer_id' => (string) $product->article,
                        'vat' => "0.0",
                        'weight' => 100,
                        'depth' => 10,
                        'width' => 150,
                        'height' => 250,
                        'primary_image' => $product->getImage()
                    ];

                    // Картинки
                    $images = $product->images;
                    if(count($images) <= 1) {
                        //continue;
                    } else {
                        foreach($images as $image) {
                            $arr['images'][] = $image->path;
                        }
                    }

                    if($thumb = $product->getThumb()) {
                        $arr['images360'][] = $thumb;
                    }

                    $attributes = OZON::getCategoryAttributes($oz_category->oz_category_id);
                    if($attributes) {
                        $attributes = json_decode($attributes);
                        foreach($attributes->result[0]->attributes as $attribute) {
                            if($attribute->is_required) {
                                $att = [
                                    'complex_id' => 0,
                                    'id' => $attribute->id,
                                ];

                                if($attribute->id == 85) {
                                    $brand = (strtolower($product->brand) == 'no name') ? 'Нет бренда' : trim($product->brand);
                                    $att['values'][] = [
                                        'value' => $brand
                                    ];
                                }

                                /*if($attribute->id == 8229) {
                                    $att['values'][] = [
                                        //'dictionary_value_id' => 97011,
                                        //'value' => 'Чехол для смартфона'
                                        'value' => 'Смарт часы'
                                    ];
                                }*/

                                /*if($attribute->id == 9461) {
                                    $att['values'][] = [
                                        //'dictionary_value_id' => 97011,
                                        'value' => 'Смарт часы'
                                    ];
                                }*/

                                if($attribute->id == 9048) {
                                    $att['values'][] = [
                                        'value' => $product->name
                                    ];
                                }

                                if($attribute->id == 4385) {
                                    $att['values'][] = [
                                        'value' => "12"
                                    ];
                                }

                                if(is_array($product_feature) && isset($product_feature[0])) {
                                    $feature = json_decode(json_encode($product_feature[0]->properties), true);
                                    if($attribute->id == 4381) {
                                        $att['values'][] = [
                                            'value' => (string) $product_feature[0]->article_pn
                                        ];
                                    }

                                    if($attribute->id == 4191) {
                                        $att['values'][] = [
                                            'value' => $product_feature[0]->detailtext
                                        ];
                                    }

                                    if($attribute->id == 5784 && isset($feature['Встроенная память'])) {
                                        $att['values'][] = [
                                            'value' => $feature['Встроенная память']
                                        ];
                                    }

                                    if($attribute->id == 9622 && isset($feature['Оперативная память'])) {
                                        $att['values'][] = [
                                            'value' => (int) $feature['Оперативная память']
                                        ];
                                    }

                                    if($attribute->id == 10313 && isset($feature['Процессор'])) {
                                        $att['values'][] = [
                                            'value' => $feature['Процессор']
                                        ];
                                    }

                                    if($attribute->id == 10317 && isset($feature['Частота процессора'])) {
                                        $att['values'][] = [
                                            'value' => (float) str_replace(",", '.', $feature['Частота процессора'])
                                        ];
                                    }

                                    if($attribute->id == 10318 && isset($feature['Количество ядер'])) {
                                        $att['values'][] = [
                                            'value' => (string) $feature['Количество ядер']
                                        ];
                                    }

                                    if($attribute->id == 10096 && isset($feature['Цвет'])) {
                                        $att['values'][] = [
                                            'value' => (string) $feature['Цвет']
                                        ];
                                    }

                                    if($attribute->id == 8587 && isset($feature['Диагональ экрана'])) {
                                        $att['values'][] = [
                                            'value' => (float) $feature['Диагональ экрана']
                                        ];
                                    }

                                    if($attribute->id == 5186 && isset($feature['Разрешение экрана'])) {
                                        $att['values'][] = [
                                            'value' => (string) $feature['Разрешение экрана']
                                        ];
                                    }

                                    if($attribute->id == 4465 && isset($feature['Wi-Fi'])) {
                                        $att['values'][] = [
                                            'value' => (string) $feature['Wi-Fi']
                                        ];
                                    }

                                    if($attribute->id == 4422 && isset($feature['Основная камера'])) {
                                        $att['values'][] = [
                                            'value' => (float) $feature['Основная камера']
                                        ];
                                    }

                                    if($attribute->id == 4421 && isset($feature['Фронтальная камера'])) {
                                        $att['values'][] = [
                                            'value' => (float) $feature['Фронтальная камера']
                                        ];
                                    }

                                    if($attribute->id == 4414 && isset($feature['Bluetooth'])) {
                                        $att['values'][] = [
                                            'value' => (string) $feature['Bluetooth']
                                        ];
                                    }

                                    if($attribute->id == 4407 && isset($feature['Количество SIM-карт'])) {
                                        $att['values'][] = [
                                            'value' => (string) $feature['Количество SIM-карт']
                                        ];
                                    }

                                    if($attribute->id == 4383 && isset($feature['Вес'])) {
                                        $att['values'][] = [
                                            'value' => (float) $feature['Вес']
                                        ];
                                    }

                                    if($attribute->id == 10314 && isset($feature['Видеопроцессор'])) {
                                        $att['values'][] = [
                                            'value' => (string) $feature['Видеопроцессор']
                                        ];
                                    }

                                }

                                $arr['attributes'][] = $att;
                            }
                        }
                    }

                    $data['items'][] = $arr;
                    $count++;
                }

                $response = OZON::createOrUpdate($data);

                if(!$response) {
                    $this->info("Product {$product->article} don't created.");
                    //continue;
                }

                $response = json_decode($response);
                if(isset($response->result)) {
                    $this->info("The product with $product->article successfully added. Task ID: " . $response->result->task_id);
                } else {
                    $this->info("The product with $product->article failed.");
                }
           // }

            $this->info('The process "ozon:sync-products" is finished.');
       // }
    }
}
