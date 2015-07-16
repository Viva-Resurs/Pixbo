<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Events extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('events', function (Blueprint $table) {
			$table->increments('id');

			$table->date('date');
			$table->time('start_time');
			$table->time('end_time');

			$table->integer('eventmeta_id')->unsigned();
			$table->foreign('eventmeta_id')
			->references('id')->on('eventmetas');
			// Screens /ScreenGroups?

			$table->integer('created_by')->unsigned();
			$table->foreign('created_by')
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
		Schema::drop('events');
	}
}
