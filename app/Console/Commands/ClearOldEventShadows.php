<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ShadowEvent;

class ClearOldEventShadows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pixbo:clear-old-shadows';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all old event shadows';

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
        ShadowEvent::clearAllOldEvents();
    }
}
