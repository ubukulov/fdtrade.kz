<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ExchangeRate;

class GetActualRates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get:actual-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.apilayer.com/fixer/latest?symbols=RUB%2CUSD%2CEUR&base=KZT",
            CURLOPT_HTTPHEADER => array(
                "Content-Type: text/plain",
                "apikey: aSIu0g3TEMSkq0SrXx4rKzHFI06gxYua"
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET"
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $response = json_decode($response);
        if($response->success) {
            $rates = $response->rates;
            $exchange_rate = ExchangeRate::find(1);
            if($exchange_rate) {
                $exchange_rate->EUR = $rates->EUR;
                $exchange_rate->USD = $rates->USD;
                $exchange_rate->RUB = $rates->RUB;
                $exchange_rate->date = $response->date;
                $exchange_rate->save();
            } else {
                ExchangeRate::create([
                    'KZT' => 1, 'EUR' => $rates->EUR, 'USD' => $rates->USD, 'RUB' => $rates->RUB, 'date' => $response->date
                ]);
            }
            $this->info('The current exchange rates was get successfully.');
        } else {
            $this->info('An error occurred while getting the current exchange rates');
        }
    }
}
