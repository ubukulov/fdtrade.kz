<?php


namespace App\Classes;

use App\Models\MarketPlace;
use App\Models\Product;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Style;
use Illuminate\Support\Str;

class WB
{
    protected $supplierId = '';
    protected $token = '';
    protected $api = '';
    protected $warehouseId = 248653;

    public function __construct()
    {
        if($this->supplierId == '' || $this->token == '' || $this->api == '') {
            $marketplace = MarketPlace::where(['title' => 'wildberries'])->first();
            if(!$marketplace) {
                abort(500, 'В таблице marketplaces отсутствует запись про Wildberries');
            }

            $this->supplierId   = $marketplace->client_id;
            $this->api          = $marketplace->api;
            $this->token        = $marketplace->client_secret;
        }
    }

    public function getSupplierId()
    {
        return $this->supplierId;
    }

    public function createProduct($product, $wb_category)
    {
        $properties = $this->getStyleProductProperties($product);

        $product_images = [];
        $images = $product->images;
        if($images) {
            foreach($images as $image) {
                if($image->thumbs == 0) {
                    $product_images[]['value'] = $image->path;
                }
            }
            $product_image = (isset($product_images[0])) ? $product_images[0]['value'] : 'https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg';
        } else {
            $product_image = "https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg";
        }


        $article_pn = str_replace(" ", '-', $product->article_pn);
        $barcode = $this->getGeneratedBarcodeForProduct();
        if(!$barcode) {
            return false;
        }

        $data = [
            "id"=> (string) Str::uuid(),
            "jsonrpc"=> "2.0",
            "params"=> [
                "card"=> [
                    "addin"=> [
                        [
                            "params"=> [
                                [
                                    "value"=> $properties['brand']
                                ]
                            ],
                            "type"=> "Бренд"
                        ],
                        [
                            "params"=> [
                                [
                                    "value"=> $properties['name']
                                ]
                            ],
                            "type"=> "Наименование"
                        ],
                        [
                            "type"=> "Комплектация",
                            "params"=> [
                                [
                                    "value"=> $properties['complex_name']
                                ]
                            ]
                        ],
                        [
                            "type"=> "Описание",
                            "params"=> [
                                [
                                    "value"=> $properties['detail_text'],
                                ]
                            ]
                        ],
                        [
                            "type"=> "Артикул поставщика",
                            "params"=> [
                                [
                                    "value"=> "$product->article",
                                ]
                            ]
                        ],
                    ],
                    "countryProduction"=> $properties['country'],
                    "id"=> (string) Str::uuid(),
                    "nomenclatures"=> [
                        [
                            "addin"=> [
                                [
                                    "type"=> "Фото",
                                    "params"=> [
                                        [
                                            'value' => $product_image
                                        ]
                                    ]
                                ]
                            ],
                            "concatVendorCode"=> $article_pn,
                            "id"=> (string) Str::uuid(),
                            "isArchive"=> false,
                            "variations"=> [
                                [
                                    "addin"=> [
                                        [
                                            "type"=> "Розничная цена",
                                            "params"=> [
                                                [
                                                    "count"=> $product->convertPrice(),
                                                    "units" => "рубли",
                                                    "value" => "рубли"
                                                ]
                                            ]
                                        ]
                                    ],
                                    "barcode"=> $barcode,
                                    "barcodes"=> [
                                        $barcode
                                    ],
                                    "chrtId"=> 0,
                                    "errors"=> [
                                        "string"
                                    ],
                                    "id"=> (string) Str::uuid()
                                ]
                            ],
                            "vendorCode"=> (string) $product->article
                        ]
                    ],
                    "object"=> $wb_category->name,
                    "supplierId"=> $this->supplierId,
                    "supplierVendorCode"=> (string) $product->article,
                ],
                "supplierID"=> $this->supplierId
            ]
        ];

        if(!is_null($properties['warranty'])) {
            $data['params']['card']['addin'][] = [
                "type"=> "Гарантийный срок",
                "params"=> [
                    [
                        "value"=> $properties['warranty'],
                    ]
                ]
            ];
        }

        if(!is_null($properties['general_color'])) {
            $data['params']['card']['addin'][] = [
                "type"=> "Основной цвет",
                "params"=> [
                    [
                        "value"=> $properties['general_color'],
                    ]
                ]
            ];
        }

        if(count($product_images) > 1) {
            foreach($product_images as $key=>$arr) {
                if($key == 0) {
                    continue;
                }

                $data['params']['card']['nomenclatures'][0]['addin'][] = [
                    "type"=> "Фото",
                    "params"=> [
                        [
                            "value"=> $arr['value'],
                        ]
                    ]
                ];
            }
        }


        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('POST', 'card/create', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        return $request->getBody()->getContents();
    }

    public function uploadProduct($product, $wb_category)
    {
        $properties = $this->getStyleProductProperties($product);

        $product_images = [];
        $images = $product->images;
        if($images) {
            foreach($images as $image) {
                if($image->thumbs == 0) {
                    $product_images[]['value'] = $image->path;
                }
            }
            $product_image = (isset($product_images[0])) ? $product_images[0]['value'] : 'https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg';
        } else {
            $product_image = "https://upload.wikimedia.org/wikipedia/commons/a/ac/No_image_available.svg";
        }


        $article_pn = str_replace(" ", '-', $product->article_pn);
        $barcode = $this->getGeneratedBarcodeForProduct();
        if(!$barcode) {
            return false;
        }

        $article = $product->article."".$product->article;

        $data = [[
            'vendorCode' => (string) $article,
            'characteristics' => [
                [
                    'Наименование' => (string) Str::limit($properties['name'], 40, '')
                ],
                [
                    'Бренд' => (string) $properties['brand']
                ],
                [
                    'Комплектация' => (string) $properties['complex_name']
                ],
                [
                    'Описание' => (string) $properties['detail_text']
                ],
                [
                    'Гарантийный срок' => (string) $properties['warranty']
                ],
                [
                    'Предмет' => (string) $wb_category->name
                ],
                [
                    'Страна производства' => (string) $properties['country']
                ],
                [
                    'Ширина упаковки' => 100
                ],
                [
                    'Глубина упаковки' => 100
                ],
                [
                    'Высота упаковки' => 100
                ],
            ],
            'sizes' => [
                [
                    'techSize' => '',
                    'wbSize' => '',
                    'price' => (int) $product->convertPrice(),
                    'skus' => [
                        (string) $barcode
                    ]
                ]
            ]
        ]];

        /*$arrImages = [];
        if(count($product_images) > 1) {
            foreach($product_images as $key=>$arr) {
                if($key == 0) {
                    continue;
                }

                $arrImages[] = $arr['value'];
            }

            $data[0]['characteristics'][]['Фото'] = $arrImages;
        }*/

        //dd($data, json_encode($data, JSON_UNESCAPED_UNICODE));

        $data = json_encode($data, JSON_UNESCAPED_UNICODE);
        $data = "[".$data."]";

        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('POST', 'content/v1/cards/upload', [
            'headers' => [
                'Authorization' => $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => $data
        ]);

        $result = json_decode($request->getBody()->getContents());

        if($result->error) {
            return false;
        }

        return $result;
    }

    public function getCategories()
    {
        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('GET', '/api/v1/config/get/object/parent/list?top=1000', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ]
        ]);
        return $request->getBody()->getContents();
    }

    public function getCategoryChild($parent_name)
    {
        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('GET', '/api/v1/config/object/byparent?parent=' . $parent_name, [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ]
        ]);
        return $request->getBody()->getContents();
    }

    public function getProductStocks()
    {
        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('GET', '/api/v2/stocks?skip=0&take=1000', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ]
        ]);
        return json_decode($request->getBody()->getContents());
    }

    public function getWarehouses()
    {
        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('GET', '/api/v2/warehouses', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ]
        ]);
        return $request->getBody()->getContents();
    }

    public function updateStocks($product)
    {
        $client = new Client(['base_uri' => $this->api]);
        $data = [
            "barcode" => (string) $product->wb_barcode,
            "stock" => (int) $product->getQuantity(),
            "warehouseId" => (int) $this->warehouseId
        ];


        $data = "[".json_encode($data)."]";

        $request = $client->request('POST', 'api/v2/stocks', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => $data
        ]);

        return $request->getBody()->getContents();
    }

    public function cancelStocks($product)
    {
        $client = new Client(['base_uri' => $this->api]);
        $data = [
            "barcode" => (string) $product->wb_barcode,
            "stock" => 0,
            "warehouseId" => (int) $this->warehouseId
        ];


        $data = "[".json_encode($data)."]";

        $request = $client->request('POST', 'api/v2/stocks', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => $data
        ]);

        return $request->getBody()->getContents();
    }

    public function getGeneratedBarcodeForProduct()
    {
        $client = new Client(['base_uri' => $this->api]);

        $data = [
            'count' => 1
        ];

        $request = $client->request('POST', 'content/v1/barcodes', [
            'headers' => [
                'Authorization' => $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        $barcode = json_decode($request->getBody()->getContents());
        if($barcode->error == false) {
            return $barcode->data[0];
        }

        return false;
    }

    public function getProductCardList($limit = 1000, $offset = 0)
    {
        $client = new Client(['base_uri' => $this->api]);

        $data = [
            'sort' => [
                'limit' => $limit,
                'offset' => $offset,
                'searchValue' => '',
                'sortColumn' => 'updateAt',
                'ascending' => false
            ]
        ];

        $request = $client->request('POST', 'content/v1/cards/list', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        return json_decode($request->getBody()->getContents());
    }

    public function updatePrices($product, $nmId)
    {
        $client = new Client(['base_uri' => $this->api]);
        $data = [
            "nmId" => (int) $nmId,
            "price" => (int) $product->convertPrice()
        ];

        $data = "[" . json_encode($data) . "]";

        $request = $client->request('POST', 'public/api/v1/prices', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => $data
        ]);

        return $request->getBody()->getContents();
    }

    // Метод устарел
    public function getProductByImtId($product)
    {
        $client = new Client(['base_uri' => $this->api]);
        $data = [
            "id" => (string) Str::uuid(),
            "jsonrpc" => "2.0",
            "params" => [
                "imtID" => (int) $product->wb_imtId,
                "supplierID" => $this->supplierId
            ]
        ];

        $request = $client->request('POST', '/card/cardByImtID', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        return json_decode($request->getBody()->getContents());
    }

    public function getProductByArticle($product)
    {
        $client = new Client(['base_uri' => $this->api]);
        /*$data = [
            "id" => (string) Str::uuid(),
            "jsonrpc" => "2.0",
            "params" => [
                "imtID" => (int) $product->wb_imtId,
                "supplierID" => $this->supplierId
            ]
        ];*/

        $article = $product->article."".$product->article;

        $data = [
            'vendorCodes' => [
                (string) $article
            ]
        ];

        $request = $client->request('POST', 'content/v1/cards/filter', [
            'headers' => [
                'Authorization' => $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        return json_decode($request->getBody()->getContents());
    }

    public function updateProduct($wb_product, $product)
    {
        $product_feature = Style::getProductFeature($product->article);
        $product_feature = $product_feature[0];

        $product_images = [];
        foreach($product->images as $image) {
            if($image->thumbs == 0) {
                $product_images[]['value'] = $image->path;
            }
        }


        $article_pn = str_replace(" ", '-', $product->article_pn);
        $barcode = $product->wb_barcode;
        $nmId = $wb_product->result->card->nomenclatures[0]->nmId;
        $cat = $wb_product->result->card->object;
        $parent = $wb_product->result->card->parent;

        $data = [
            "id"=> (string) Str::uuid(),
            "jsonrpc"=> "2.0",
            "params"=> [
                "card"=> [
                    "addin"=> [
                        [
                            [
                                "type"=> "Описание",
                                "params"=> [
                                    [
                                        "value"=> (string) Str::limit(strip_tags($product_feature->detailtext), 1000),
                                    ]
                                ]
                            ]
                        ]
                    ],
                    "countryProduction"=> "Китай",
                    //"createdAt"=> "2022-05-26T08=>09=>14.805Z",
                    "id"=> (string) Str::uuid(),
                    "imtId"=> $product->wb_imtId,
                    //"imtSupplierId"=> 0,
                    "nomenclatures"=> [
                        [
//                            "addin"=> [
//                                [
//                                    "type"=> "Фото",
//                                    "params"=> [
//                                        [
//                                            'value' => $product_images[0]['value']
//                                        ]
//                                    ]
//                                ]
//                            ],
                            "concatVendorCode"=> $article_pn,
                            "id"=> (string) Str::uuid(),
                            "isArchive"=> false,
                            "nmId"=> $nmId,
                            "variations"=> [
                                [
                                    "addin"=> [
                                        [
                                            "type"=> "Розничная цена",
                                            "params"=> [
                                                [
                                                    "count"=> (int) $product->convertPrice(),
                                                    "units" => "рубли",
                                                    "value" => "рубли"
                                                ]
                                            ]
                                        ]
                                    ],
                                    "barcode"=> $barcode,
                                    "barcodes"=> [
                                        $barcode
                                    ],
                                    "chrtId"=> 0,
                                    "errors"=> [
                                        "string"
                                    ],
                                    "id"=> (string) Str::uuid()
                                ]
                            ],
                            "vendorCode"=> (string) $product->article
                        ]
                    ],
                    "object"=> $cat,
                    "parent"=> $parent,
                    "supplierId"=> $this->supplierId,
                    "supplierVendorCode"=> (string) $product->article,
                    //"updatedAt"=> "2022-05-26T08=>09=>14.805Z",
                    //"uploadID"=> "3fa85f64-5717-4562-b3fc-2c963f66afa6",
                    "userId"=> 0
                ],
                "supplierID"=> $this->supplierId
            ]
        ];

        /*foreach($product_images as $image) {
            $data["params"]["card"]["nomenclatures"][0]["addin"][] = [
                "type"=> "Фото",
                "params"=> [
                    [
                        'value' => $image['value']
                    ]
                ]
            ];
        }*/

        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('POST', 'card/update', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        return $request->getBody()->getContents();

    }

    public function getStyleProductProperties($product) :array
    {
        $properties = [];
        $product_feature = Style::getProductFeature($product->article);
        if(isset($product_feature[0])) {
            $product_feature = $product_feature[0];
            $arr = (array) $product_feature->properties;
            $properties['name'] = $this->removeSymbols($product->name);
            $properties['complex_name'] = $this->removeSymbols($product->name) . " - 1" . $arr['Базовая единица'];
            $properties['brand'] = (isset($product_feature->brand)) ? $product_feature->brand : 'No name';
            $properties['warranty'] = (isset($product_feature->warranty)) ? $product_feature->warranty : null;
            $properties['detail_text'] = Str::limit($product_feature->detailtext, 999);
            $properties['detail_text'] = $this->removeSymbols($properties['detail_text']);
            $properties['country'] = (isset($arr['Страна производства'])) ? $arr['Страна производства'] : "Китай";
            $properties['country'] = ($properties['country'] == 'Сделано в Китае') ? "Китай" : $properties['country'];
            $properties['main_camera'] = (isset($arr['Основная камера'])) ? $arr['Основная камера'] : null;
            $properties['ram'] = (isset($arr['Оперативная память'])) ? $arr['Оперативная память'] : null;
            $properties['cpu'] = (isset($arr['Процессор'])) ? $arr['Процессор'] : null;
            $properties['cpu_frequency'] = (isset($arr['Частота процессора'])) ? $arr['Частота процессора'] : null;
            $properties['battery'] = (isset($arr['Аккумулятор'])) ? $arr['Аккумулятор'] : null;
            $properties['number_cores'] = (isset($arr['Количество ядер'])) ? $arr['Количество ядер'] : null;
            $properties['built_memory'] = (isset($arr['Встроенная память'])) ? $arr['Встроенная память'] : null;
            $properties['screen_diagonal'] = (isset($arr['Диагональ экрана'])) ? $arr['Диагональ экрана'] : null;
            $properties['screen_resolution'] = (isset($arr['Разрешение экрана'])) ? $arr['Разрешение экрана'] : null;
            $properties['wifi'] = (isset($arr['Wi-Fi'])) ? $arr['Wi-Fi'] : null;
            $properties['front_camera'] = (isset($arr['Фронтальная камера'])) ? $arr['Фронтальная камера'] : null;
            $properties['bluetooth'] = (isset($arr['Bluetooth'])) ? $arr['Bluetooth'] : null;
            $properties['sim_card'] = (isset($arr['Количество SIM-карт'])) ? $arr['Количество SIM-карт'] : null;
            $properties['weight'] = (isset($arr['Вес'])) ? $arr['Вес'] : null;
            $properties['wireless_charger'] = (isset($arr['Беспроводная зарядка'])) ? $arr['Беспроводная зарядка'] : null;
            $properties['general_color'] = (isset($arr['Цвет'])) ? $arr['Цвет'] : null;
            $properties['general_color'] = ($properties['general_color'] == 'Чёрный') ? 'Черный' : $properties['general_color'];
            $properties['general_color'] = ($properties['general_color'] == 'Чрный') ? 'Черный' : $properties['general_color'];
            $properties['general_color'] = mb_strtolower($properties['general_color']);
        } else {
            $properties['name'] = $this->removeSymbols($product->name);
            $properties['complex_name'] = $this->removeSymbols($product->name) . " - 1шт";
            $properties['brand'] = "No name";
            $properties['warranty'] = null;
            $properties['detail_text'] = "";
            $properties['country'] = 'Китай';
            $properties['main_camera'] = null;
            $properties['ram'] = null;
            $properties['cpu'] = null;
            $properties['cpu_frequency'] = null;
            $properties['battery'] = null;
            $properties['built_memory'] = null;
            $properties['screen_diagonal'] = null;
            $properties['screen_resolution'] = null;
            $properties['wifi'] = null;
            $properties['front_camera'] = null;
            $properties['bluetooth'] = null;
            $properties['sim_card'] = null;
            $properties['weight'] = null;
            $properties['wireless_charger'] = null;
            $properties['general_color'] = null;
        }

        return $properties;
    }

    public function removeSymbols($string) :string
    {
        $symbols = [
            '/', '*', '#', '@', '$', '®'
        ];
        foreach($symbols as $symbol) {
            $string = str_replace($symbol, ' ', $string);
        }
        return $string;
    }
}
