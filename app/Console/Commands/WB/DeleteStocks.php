<?php

namespace App\Console\Commands\WB;

use App\Models\Product;
use Illuminate\Console\Command;
use WB;

class DeleteStocks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wb:delete-stocks';

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
        $getProductCardList = WB::getProductCardList();
        foreach($getProductCardList->data->cards as $item) {
            if(!empty($item->vendorCode)) {
                $barcode = $item->sizes[0]->skus[0];
                $updateStocks = json_decode(WB::deleteStocks($barcode));
                /*if($updateStocks->error) {
                    $this->info("{$barcode} stocks failed.");
                } else {
                    $this->info("{$barcode} stocks deleted.");
                }*/
            }
        }
    }
}
