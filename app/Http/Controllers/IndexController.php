<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use WB;
use Style;

class IndexController extends Controller
{
    public function index()
    {
        $childs = WB::getCategoryChild("Модули зажигания");
        dd(json_decode($childs));
        $product = Product::find(7587);

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

        $category = $product->category;
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
                                ]
                            ]
                        ],
                        [
                            "type"=> "Описание",
                            "params"=> [
                                [
                                    "value"=> $product_feature->detailtext,
                                ]
                            ]
                        ],
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
                    "countryProduction"=> "Казахстан",
                    //"createdAt"=> "2022-05-18T09=>37=>19.706Z",
                    //"id"=> WB::getSupplierId(),
                    "imtId"=> 0,
                    "imtSupplierId"=> 0,
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
                            "id"=> WB::getSupplierId(),
                            "isArchive"=> false,
                            "nmId"=> 0,
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
                                    "id"=> WB::getSupplierId()
                                ]
                            ],
                            "vendorCode"=> "$product->article"
                        ]
                    ],
                    "object"=> 'Клавиатуры',
                    //"parent"=> "string",
                    "supplierId"=> WB::getSupplierId(),
                    "supplierVendorCode"=> $article_pn,
                    //"updatedAt"=> "2022-05-18T09=>37=>19.706Z",
                    //"uploadID"=> "92a14265-9512-4ef8-85c1-8c2f5c672957",
                    //"userId"=> 1
                ],
                "supplierID"=> WB::getSupplierId()
            ]
        ];

        WB::createProduct($data);
    }
}
