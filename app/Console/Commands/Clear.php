<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Clear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'laravel:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run clear cache, views and then do a dump autoload';

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
     * @return mixed
     */
    public function handle()
    {
        $this->call('cache:clear');
        $this->call('config:cache');
        $this->call('view:clear');
    }
}
