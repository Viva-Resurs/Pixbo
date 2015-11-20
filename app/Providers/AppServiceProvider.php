<?php

namespace App\Providers;

use App\Event;
use App\EventMeta;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {
	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot() {

		// Fire event when EventMeta changes.
		EventMeta::saved(function ($meta) {
			event('GenerateFromEventMeta', $meta);
		});

		// Fire event when Event changes.
		Event::updated(function ($event) {
			event('GenerateFromEvent', $event);
		});

		Event::deleted(function ($event) {
			event('RemoveFromEvent', $event);
		});
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
		if ($this->app->environment() == 'local') {
			$this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
		}
	}
}
