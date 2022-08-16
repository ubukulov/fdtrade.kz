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
    protected $access_token = '';

    public function __construct()
    {
        if($this->clientId == '' || $this->token == '' || $this->api == '') {
            $marketplace = MarketPlace::where(['title' => 'ozon'])->first();
            if(!$marketplace) {
                abort(500, 'В таблице marketplaces отсутствует запись про Wildberries');
            }

            $this->clientId     = $marketplace->client_id;
            $this->api          = $marketplace->api;
            $this->token        = $marketplace->client_secret;
        }
    }
}
