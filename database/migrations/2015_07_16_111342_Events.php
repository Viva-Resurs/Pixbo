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

			$table->date('start_date');
			$table->date('end_date');

			$table->time('start_time');
			$table->time('end_time');

			$table->integer('frequency')->unsigned()->nullable();
			$table->string('recur_type')->nullable();
			$table->string('recur_day_num')->nullable();
			$table->string('recur_day')->nullable();
			$table->date('recur_end')->nullable();
			$table->integer('days_before_event')->nullable();

			$table->integer('eventable_id');
			$table->string('eventable_type');

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
