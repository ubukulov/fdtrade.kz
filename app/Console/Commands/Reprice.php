<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class Reprice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'style:reprice';

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
        Product::chunk(50, function($products){
            foreach($products as $product) {
                if($product->quantity == '0') continue;
                $category = $product->category;
                $product->price = $product->price2 + ($product->price2 * ($category->margin / 100));
                $product->save();
            }
        });
    }
}
