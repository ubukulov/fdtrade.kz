<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class Test2 extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:update';

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
        $contents = file_get_contents("https://europe-west1-kaspi-2e75a.cloudfunctions.net/api/datasources/products/export/halykxml/tLWdxIAofeO84yYhz0gBaaBVyeDetIti");
        $xmlObject = simplexml_load_string($contents);
        $json = json_encode($xmlObject);
        $phpArray = json_decode($json, true);

        $count = 0;

        foreach ($phpArray['good'] as $item){
            $sku = $item['@attributes']['sku'];
            $name = $item['name'];
            $product = Product::where(['article' => (int) $sku])->first();
            if($product) {
                $product->name = $name;
                $product->save();
                $count++;
            }
        }

        $this->info("$count products is updated.");
    }
}
