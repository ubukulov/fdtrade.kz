<?php

namespace App\Console\Commands;

use App\Models\WBCategory;
use Illuminate\Console\Command;
use WB;

class GetWBCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wb:get-category-parents';

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
        $wb_categories = json_decode(WB::getCategories());
        foreach($wb_categories->data as $datum) {
            $wb_category = WBCategory::whereName($datum->name)->first();
            if(!$wb_category){
                WBCategory::create([
                    'name' => $datum->name
                ]);
            }
        }

        $this->info('The process is finished.');
    }
}
