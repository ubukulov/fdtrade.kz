<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;
use Style;

class GetStyleProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'style:get-products';

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
        $i = 0;
        while($i < 7800) {
            $products = json_decode(Style::getProducts($i));
            $this->create($products);
            $i+= 250;
        }

        $this->info('The process finished.');
    }

    public function create($products)
    {
        foreach($products as $product){
            $category = Category::where(['foreign_id' => $product->category])->first();
            $category_id = ($category) ? $category->id : null;
            $pro = Product::where(['article' => $product->article])->first();
            if(!$pro) {
                Product::create([
                    'article' => $product->article, 'category_id' => $category_id, 'name' => $product->name,
                    'full_name' => $product->full_name, 'sort' => $product->sort, 'price1' => $product->price1,
                    'price2' => $product->price2, 'quantity' => $product->quantity, 'isnew' => $product->isnew,
                    'ishit' => $product->ishit, 'ispromo' => $product->ispromo, 'article_pn' => $product->article_pn,
                    'active' => 1
                ]);
            }
        }
    }
}
