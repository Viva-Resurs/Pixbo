<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Screens extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('screens', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');

			// ScreenGroup
			$table->integer('screen_group_id')->unsigned();
			$table->foreign('screen_group_id')
			->references('id')->on('screengroups');

			// Event
			$table->integer('event_id')->unsigned()->nullable();
			$table->foreign('event_id')
			->references('id')->on('events');

			// Images
			$table->integer('photo_id')->unsigned();
			$table->foreign('photo_id')
			->references('id')->on('photos');

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
		Schema::drop('screens');
	}
}
