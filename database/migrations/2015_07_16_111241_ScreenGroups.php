<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ScreenGroups extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('screengroups', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->text('desc');
			$table->text('rss_feed')->nullable();

			// Screens

			// Event
			$table->integer('event_id')->unsigned();
			$table->foreign('event_id')
			->references('id')->on('events');

			// Users
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')
			->references('id')->on('users');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('screengroups');
	}
}
