<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;
use Style;

class GetStyleCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'style:get-categories';

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
        $categories = Style::getCategories();
        foreach (json_decode($categories) as $category) {
            $cat = Category::where('foreign_id', $category->id)->first();
            if(!$cat) {
                Category::create([
                    'foreign_id' => $category->id, 'name' => $category->name, 'left' => $category->left, 'right' => $category->right,
                    'level' => $category->level, 'elements' => $category->elements
                ]);
            }
        }

        $this->info("The process is finished.");
    }
}
