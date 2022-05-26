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
        $product_feature = json_decode(Style::getProductFeature($product->article));
        $product_feature = $product_feature[0];

        $product_images = [];
        foreach($product->images as $image) {
            if($image->thumbs == 0) {
                $product_images[]['value'] = $image->path;
            }
        }


        $article_pn = str_replace(" ", '-', $product->article_pn);
        $barcode = $this->getGeneratedBarcodeForProduct();
        $arr = (array) $product_feature->properties;
        $complex_name = $product->name . " - 1" . $arr['Базовая единица'];
        $general_color = (isset($arr['Цвет'])) ? $arr['Цвет'] : "";

        $data = [
            "id"=> (string) Str::uuid(),
            "jsonrpc"=> "2.0",
            "params"=> [
                "card"=> [
                    "addin"=> [
                        [
                            "params"=> [
                                [
                                    "value"=> $product_feature->brand
                                ]
                            ],
                            "type"=> "Бренд"
                        ],
                        [
                            "params"=> [
                                [
                                    "value"=> $product->name
                                ]
                            ],
                            "type"=> "Наименование"
                        ],
                        [
                            "type"=> "Комплектация",
                            "params"=> [
                                [
                                    "value"=> $complex_name
                                ]
                            ]
                        ],
                        /*[
                            "type"=> "Описание",
                            "params"=> [
                                [
                                    "value"=> Str::limit(strip_tags($product_feature->detailtext), 1000),
                                ]
                            ]
                        ],*/
                        [
                            "type"=> "Гарантийный срок",
                            "params"=> [
                                [
                                    "value"=> $product_feature->warranty,
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
                        /*[
                            "type"=> "Основной цвет",
                            "params"=> [
                                [
                                    "value"=> $general_color,
                                ]
                            ]
                        ]*/
                    ],
                    "countryProduction"=> "Китай",
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
                                            'value' => $product_images[0]['value']
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
                                                    "count"=> $product->price,
                                                    "units" => "тенге"
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
                            "vendorCode"=> "$product->article"
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

        $request = $client->request('POST', '/api/v2/stocks', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
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

    public function getProductCardList($limit = 0, $offset = 0)
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
            "price" => (int) $product->price
        ];

        $request = $client->request('POST', '/public/api/v1/prices', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
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
}
