<?php

namespace App\Console\Commands\WB;

use App\Models\WBCategory;
use Illuminate\Console\Command;
use WB;

class GetWBCategoryChilds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wb:get-category-childs';

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
        $wb_parent_categories = WBCategory::whereNull('parent_id')->get();
        foreach($wb_parent_categories as $wb_parent_category) {
            $wb_category_childs = json_decode(WB::getCategoryChild($wb_parent_category->name));
            if(!$wb_category_childs->error) {
                foreach($wb_category_childs->data as $datum) {
                    $wb_category = WBCategory::whereName($datum->name)->first();
                    if(!$wb_category) {
                        WBCategory::create([
                            'name' => $datum->name, 'parent_id' => $datum->parent_id, 'rv' => $datum->rv,
                            'foreign_id' => $datum->id
                        ]);
                    }
                }

                $wb_parent_category->foreign_id = $wb_category_childs->data[0]->parent_id;
                $wb_parent_category->save();
            }
        }

        $this->info('The process is finished.');
    }
}
