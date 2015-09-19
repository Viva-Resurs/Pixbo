<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateShadowEventTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('shadow_events', function (Blueprint $table) {
			$table->increments('id');

			$table->string('title');
			$table->boolean('isAllDay');
			$table->dateTime('start_time');
			$table->dateTime('end_time');
			$table->integer('event_id')->unsigned();
			$table->timestamps();

			$table->foreign('event_id')
			->references('id')
			->on('events')
			->onDelete('cascade');;
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('shadow_events');
	}
}
