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

			// Event
			$table->integer('event_id')->unsigned()->nullable();
			$table->foreign('event_id')
			->references('id')->on('events');

			// Users
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')
			->references('id')->on('users');

			$table->timestamps();
		});

		Schema::create('screen_screen_group', function (Blueprint $table) {
			$table->integer('screen_group_id')->unsigned()->index();
			$table->foreign('screen_group_id')->references('id')->on('screengroups')->onDelete('cascade');
			$table->integer('screen_id')->unsigned()->index();
			$table->foreign('screen_id')->references('id')->on('screens')->onDelete('cascade');
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
		Schema::drop('screen_screen_group');
	}
}
