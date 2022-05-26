<?php


namespace App\Classes;

use GuzzleHttp\Client;

class Style
{
    protected $access_token = 'OdM23VfnTSfc0RU_prZBTfuljB242Wre';
    public $api = 'https://api.al-style.kz/api/';

    public function getCategories()
    {
        $client = new Client(['base_uri' => $this->api]);
        $response = $client->request('GET', 'categories?access-token=' . $this->access_token);

        return $response->getBody()->getContents();
    }

    public function getProducts($offset = 0)
    {
        $client = new Client(['base_uri' => $this->api]);
        $response = $client->request('GET', 'elements?access-token=' . $this->access_token . '&limit=250&offset=' . $offset);
        return $response->getBody()->getContents();
    }

    public function getProductInfo($article)
    {
        $client = new Client(['base_uri' => $this->api]);
        $response = $client->request('GET', 'images?access-token=' . $this->access_token . '&article=' . $article);

        $arrImages = [];

        $result = $response->getBody()->getContents();
        $result = (array) json_decode($result);
        $arrImages['images'] = $result[$article];

        $response = $client->request('GET', 'images?access-token=' . $this->access_token . '&article=' . $article . '&thumbs=1');

        $result = $response->getBody()->getContents();
        $result = (array) json_decode($result);
        $arrImages['thumbs'] = $result[$article];

        return $arrImages;
    }

    public function getProductFeature($article)
    {
        $client = new Client(['base_uri' => $this->api]);
        $params = [
            'description',
            'brand',
            'weight',
            'warranty',
            'barcode',
            'reducedprice',
            'expectedArrivalDate',
            'detailtext',
            'properties',
        ];

        $response = $client->request('GET', 'element-info?access-token=' . $this->access_token . '&article=' . $article . '&additional_fields=' . implode(",", $params));

        return json_decode($response->getBody()->getContents());
    }

    public function getProductPriceAndQuantity($article)
    {
        $client = new Client(['base_uri' => $this->api]);
        $response = $client->request('GET', 'quantity-price?access-token=' . $this->access_token . '&article=' . $article);

        $result = json_decode($response->getBody()->getContents());
        return (array) $result;
    }
}
