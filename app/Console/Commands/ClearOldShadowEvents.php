<?php

namespace App\Console\Commands;

use App\Models\ShadowEvent;
use Illuminate\Console\Command;

class ClearOldShadowEvents extends Command {
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'pixbo:clear-old-shadowevents';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all old ShadowEvents';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        ShadowEvent::clearAllOldEvents();
    }
}
