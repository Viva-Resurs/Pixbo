<?php

namespace App\Console\Commands;

use App\Models\ShadowEvent;
use Illuminate\Console\Command;

class GenerateNewShadowEvents extends Command {
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'pixbo:generate-new-shadowevents';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Clear all ShadowEvents and generate new ones.';

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
		ShadowEvent::clearAllShadowEvents();
		ShadowEvent::generateAllEvents();
	}
}
