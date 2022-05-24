<?php


namespace App\Classes;

use App\Models\Product;
use GuzzleHttp\Client;
use Style;
use Illuminate\Support\Str;

class WB
{
    protected $supplierId = '92a14265-9512-4ef8-85c1-8c2f5c672957';
    protected $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2Nlc3NJRCI6IjEyZWVjYTI3LWM4NzAtNDZiNi04YzczLWM2NzIwMmJiMGJjYSJ9.yivi1D6nyAwA1ScI-opX2tmejPqN0DH3hMDUqP4pqgA';
    protected $api = 'https://suppliers-api.wildberries.ru/';

    public function getSupplierId()
    {
        return $this->supplierId;
    }

    public function createProduct($product, $wb_category)
    {
        $product_feature = json_decode(Style::getProductFeature($product->article));
        $product_feature = $product_feature[0];
        $adds = [];
        foreach($product_feature->properties as $key=>$val) {
            $adds[] = [
                'type' => $key,
                'params' => [
                    'value' => $val
                ]
            ];
        }

        //dd($product_feature, $product);

        $product_images = [];
        foreach($product->images as $image) {
            if($image->thumbs == 0) {
                $product_images[]['value'] = $image->path;
            }
        }

        //dd($product_images);
        $article_pn = str_replace(" ", '-', $product->article_pn);

        $data = [
            "id"=> $product->id,
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
                                    "value"=> $product->name
                                ]
                            ]
                        ],
                        [
                            "type"=> "Розничная цена",
                            "params"=> [
                                [
                                    "count"=> $product->price,
                                    "units" => "тенге"
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
                        ]
                    ],
                    "countryProduction"=> "Китай",
                    //"createdAt"=> "2022-05-18T09=>37=>19.706Z",
                    //"id"=> WB::getSupplierId(),
                    "imtId"=> $product->id,
                    "imtSupplierId"=> $product->id,
                    "nomenclatures"=> [
                        [
                            "addin"=> [
                                [
                                    "type"=> "Розничная цена",
                                    "params"=> [
                                        [
                                            "count"=> $product->price,
                                        ]
                                    ]
                                ],
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
                            "id"=> $this->supplierId,
                            "isArchive"=> false,
                            "nmId"=> $product->id,
                            "variations"=> [
                                [
                                    "addin"=> [
                                        [
                                            "type"=> "Фото",
                                            "params"=> [
                                                [
                                                    'value' => $product_images[0]['value']
                                                ]
                                            ]
                                        ],
                                        [
                                            "type"=> "Розничная цена",
                                            "params"=> [
                                                [
                                                    "count"=> $product->price,
                                                ]
                                            ]
                                        ]
                                    ],
                                    "barcode"=> "17".$product_feature->barcode,
                                    "barcodes"=> [
                                        "string"
                                    ],
                                    "chrtId"=> 0,
                                    "errors"=> [
                                        "string"
                                    ],
                                    "id"=> $this->supplierId
                                ]
                            ],
                            "vendorCode"=> "$product->article"
                        ]
                    ],
                    "object"=> $wb_category->name,
                    //"parent"=> "string",
                    "supplierId"=> $this->supplierId,
                    "supplierVendorCode"=> $article_pn,
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
}
