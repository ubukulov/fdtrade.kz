<?php


namespace App\Classes;

use App\Models\MarketPlace;
use App\Models\Product;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Style;
use Illuminate\Support\Facades\Http;

class Ozon
{
    protected $clientId = '';
    protected $api = '';
    protected $token = '';

    public function __construct()
    {
        if($this->clientId == '' || $this->token == '' || $this->api == '') {
            $marketplace = MarketPlace::where(['title' => 'ozon'])->first();
            if(!$marketplace) {
                abort(500, 'В таблице marketplaces отсутствует запись про Ozon');
            }

            $this->clientId     = $marketplace->client_id;
            $this->api          = $marketplace->api;
            $this->token        = $marketplace->client_secret;
        }
    }

    public function getCategories()
    {
        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('POST', 'v2/category/tree', [
            'headers' => [
                'Content-type' => 'application/json',
                'Client-Id' => $this->clientId,
                'Api-Key' => $this->token
            ],
        ]);

        return $request->getBody()->getContents();
    }

    public function createOrUpdate($data)
    {
        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('POST', 'v2/product/import', [
            'headers' => [
                'Content-type' => 'application/json',
                'Client-Id' => $this->clientId,
                'Api-Key' => $this->token
            ],
//            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
            'form_params' => $data
        ]);

        return $request->getBody()->getContents();
    }

    public function getCategoryAttributes($category_id)
    {
        $data = [
            'attribute_type' => 'ALL',
            'category_id'    => [$category_id],
            'language' => 'DEFAULT'
        ];
        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('POST', 'v3/category/attribute', [
            'headers' => [
                'Content-type' => 'application/json',
                'Client-Id' => $this->clientId,
                'Api-Key' => $this->token
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        if($request->getStatusCode() === 200) {
            return $request->getBody()->getContents();
        }

        return false;
    }

    /**
     * Метод проверен. Успешно обновляет картинки. Передать в запросе список картинок в виде массива
     * и передат ид продукта (в ОЗОНЕ)
     * @return bool|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateProductPictures()
    {
        $data = [
            'color_image' => 'string',
            'images'    => [
                "https://img.al-style.kz/34061_1.jpg",
                "https://img.al-style.kz/34061_2.jpg",
                "https://img.al-style.kz/34061_3.jpg"
            ],
            'images360' => [
                "https://img.al-style.kz/34061_01.jpg"
            ],
            'product_id' => 355006627
        ];

        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('POST', 'v1/product/pictures/import', [
            'headers' => [
                'Content-type' => 'application/json',
                'Client-Id' => $this->clientId,
                'Api-Key' => $this->token
            ],
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        if($request->getStatusCode() === 200) {
            return $request->getBody()->getContents();
        }

        return false;
    }
}
