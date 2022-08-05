<?php


namespace App\Classes;

use App\Models\MarketPlace;
use App\Models\Product;
use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Style;
use Illuminate\Support\Facades\Http;

class Halyk
{
    protected $api = '';
    protected $access_token = '';

    public function __construct()
    {
        $marketplace = MarketPlace::where(['title' => 'halykmarket'])->first();
        if(!$marketplace) {
            abort(500, 'В таблице marketplaces отсутствует запись про Халык Маркет');
        }

        $this->api = $marketplace->api;

        if(is_null($marketplace->expires_date) || Carbon::now()->gt($marketplace->expires_date)) {
            $client = new Client(['base_uri' => $this->api]);
            $data = [
                'grant_type' => 'client_credentials',
                'client_id' => $marketplace->client_id,
                'client_secret' => $marketplace->client_secret
            ];

            $request = $client->request('POST', 'auth', [
                'headers' => [
                    'Content-type' => 'application/json'
                ],
                'body' => json_encode($data)
            ]);

            $res = json_decode($request->getBody()->getContents());

            if(isset($res->success) && $res->success) {
                $marketplace->access_token = $res->access_token;
                $marketplace->token_type = $res->token_type;
                $marketplace->expires_date = Carbon::now()->addSeconds($res->expires_in);
                $marketplace->save();

                $this->access_token = $res->access_token;
            } else {
                abort(500, 'Ошибка при получение токена. Попробуйте позже');
            }
        } else {
            $this->access_token = $marketplace->access_token;
        }
    }

    public function createOrUpdate()
    {
        $apiUrl = $this->api . 'offers/upload/';
        $response = Http::withToken($this->access_token)->attach(
            'file', file_get_contents(public_path() . '/storage/halyk/stocks.xml'), 'stocks.xml'
        )->post($apiUrl);

        return ($response->successful()) ? true : false;
    }
}
