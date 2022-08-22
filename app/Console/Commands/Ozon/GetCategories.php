<?php

namespace App\Console\Commands\Ozon;

use Illuminate\Console\Command;
use App\Models\OZONCategory;
use Ozon;

class GetCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ozon:get-categories';

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
        $categories = json_decode(Ozon::getCategories());
        foreach($categories->result as $item){
            if(!OZONCategory::exists($item->category_id)) {
                $category = OZONCategory::create([
                    'oz_category_id' => $item->category_id, 'name' => $item->title
                ]);
                if(count($item->children) == 0) {
                    continue;
                } else {
                    foreach($item->children as $item2) {
                        if(!OZONCategory::exists($item2->category_id)) {
                            $child = OZONCategory::create([
                                'oz_category_id' => $item2->category_id, 'name' => $item2->title, 'parent_id' => $category->id
                            ]);

                            if(count($item2->children) == 0) {
                                continue;
                            } else {
                                foreach($item2->children as $boy) {
                                    OZONCategory::create([
                                        'oz_category_id' => $boy->category_id, 'name' => $boy->title, 'parent_id' => $child->id
                                    ]);
                                }
                            }
                        }
                    }
                }
            }
        }
        $this->info('The end.');
    }
}
