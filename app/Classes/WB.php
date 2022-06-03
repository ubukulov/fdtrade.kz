<?php


namespace App\Classes;

use App\Models\Product;
use GuzzleHttp\Client;
use Style;
use Illuminate\Support\Str;

class WB
{
    protected $supplierId = 'f24a7a98-07b8-4b76-841c-3701f8779b6c';
    protected $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2Nlc3NJRCI6IjEyZWVjYTI3LWM4NzAtNDZiNi04YzczLWM2NzIwMmJiMGJjYSJ9.yivi1D6nyAwA1ScI-opX2tmejPqN0DH3hMDUqP4pqgA';
    protected $api = 'https://suppliers-api.wildberries.ru/';
    protected $warehouseId = 248653;

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
                    //"createdAt"=> "2022-05-18T09=>37=>19.706Z",
                    "id"=> (string) Str::uuid(),
                    //"imtId"=> $product->article,
                    //"imtSupplierId"=> $product->id,
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
                            //"nmId"=> $product->id,
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
                    //"parent"=> "string",
                    "supplierId"=> $this->supplierId,
                    "supplierVendorCode"=> (string) $product->article,
                    //"updatedAt"=> "2022-05-18T09=>37=>19.706Z",
                    //"uploadID"=> "92a14265-9512-4ef8-85c1-8c2f5c672957",
                    //"userId"=> 1
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

        $request = $client->request('POST', '/api/v2/stocks', [
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
            "id"=> (string) Str::uuid(),
            "jsonrpc"=> "2.0",
            "params" => [
                "quantity" => 1,
            ]
        ];

        $request = $client->request('POST', '/card/getBarcodes', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        $barcode = json_decode($request->getBody()->getContents());
        return $barcode->result->barcodes[0];
    }

    public function getProductCardList($limit = 1000, $offset = 0)
    {
        $client = new Client(['base_uri' => $this->api]);
        $data = [
            "id"=> (string) Str::uuid(),
            "jsonrpc"=> "2.0",
            "params" => [
                "filter" => [
                    "order" => [
                        "column"    => "updatedAt",
                        "order"     => "desc"
                    ]
                ],
                "query" => [
                    "limit"     => $limit,
                    "offset"    => $offset
                ]
            ]
        ];

        $request = $client->request('POST', '/card/list', [
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

        $request = $client->request('POST', '/public/api/v1/prices', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => $data
        ]);

        return $request->getBody()->getContents();
    }

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
            $properties['complex_name'] = str_replace("/", " ", $product->name) . " - 1" . $arr['Базовая единица'];
            $properties['brand'] = (isset($product_feature->brand)) ? $product_feature->brand : 'No name';
            $properties['warranty'] = (isset($product_feature->warranty)) ? $product_feature->warranty : null;
            $properties['detail_text'] = Str::limit(strip_tags($product_feature->detailtext), 999);
            $properties['detail_text'] = str_replace("/", " ", $properties['detail_text']);
            $properties['country'] = (isset($arr['Страна производства'])) ? $arr['Страна производства'] : "Китай";
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
        } else {
            $properties['name'] = $this->removeSymbols($product->name);
            $properties['complex_name'] = str_replace("/", " ", $product->name) . " - 1шт";
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
            '/', '*', '#', '@', '$', '%'
        ];
        foreach($symbols as $symbol) {
            $string = str_replace($symbol, ' ', $string);
        }
        return $string;
    }
}
