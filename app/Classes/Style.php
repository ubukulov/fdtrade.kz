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
}
