<?php

namespace App\Console\Commands\Halyk;

use Illuminate\Console\Command;
use HK;

class SyncHalyk extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:halyk';

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
        if (HK::createOrUpdate()) {
            $this->info('Halyk: success.');
        } else {
            $this->warn('Halyk: failed.');
        }
    }
}
