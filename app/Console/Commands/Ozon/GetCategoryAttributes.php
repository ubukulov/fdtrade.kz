<?php

namespace App\Console\Commands\Ozon;

use App\Models\OZONCategory;
use App\Models\OzonCategoryAttribute;
use Illuminate\Console\Command;
use OZON;

class GetCategoryAttributes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ozon:get-category-attributes';

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
        OZONCategory::chunk(100, function($ozon_categories){
            foreach($ozon_categories as $ozon_category) {
                $attributes = OZON::getCategoryAttributes($ozon_category->oz_category_id);
                if($attributes) {
                    $attributes = json_decode($attributes);
                    foreach($attributes->result[0]->attributes as $attribute) {
                        if(!OzonCategoryAttribute::exists($ozon_category->id, $attribute->id)) {
                            OzonCategoryAttribute::create([
                                'ozon_category_id' => $ozon_category->id, 'attribute_id' => $attribute->id, 'name' => $attribute->name,
                                'description' => $attribute->description, 'type' => $attribute->type, 'is_collection' => $attribute->is_collection,
                                'is_required' => $attribute->is_required, 'group_id' => $attribute->group_id, 'group_name' => $attribute->group_name,
                                'dictionary_id' => $attribute->dictionary_id,
                            ]);
                        }
                    }
                }
            }
        });
        $this->info('The process is end.');
    }
}
