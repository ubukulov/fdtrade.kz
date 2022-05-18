<?php


namespace App\Classes;

use GuzzleHttp\Client;

class WB
{
    protected $supplierId = '92a14265-9512-4ef8-85c1-8c2f5c672957';
    protected $token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJhY2Nlc3NJRCI6IjEyZWVjYTI3LWM4NzAtNDZiNi04YzczLWM2NzIwMmJiMGJjYSJ9.yivi1D6nyAwA1ScI-opX2tmejPqN0DH3hMDUqP4pqgA';
    protected $api = 'https://suppliers-api.wildberries.ru/';

    public function getSupplierId()
    {
        return $this->supplierId;
    }

    public function createProduct($data)
    {
        $client = new Client(['base_uri' => $this->api]);
        $request = $client->request('POST', 'card/create', [
            'headers' => [
                'Authorization' => "Bearer " . $this->token,
                'Content-type' => 'application/json'
            ],
            /*'json' => [
                'jsonrpc' => '2.0',
                'method' => 'create',
                'params' => $data,
                'id' => 444,
            ]*/
            'body' => json_encode($data, JSON_UNESCAPED_UNICODE)
        ]);

        $response = $request->getBody()->getContents();
        dd($response);
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
