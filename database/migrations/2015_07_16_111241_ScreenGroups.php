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
			$table->timestamps();
		});

		Schema::create('tickers', function (Blueprint $table) {
			$table->increments('id');
			$table->text('text');

			$table->integer('screen_group_id')->unsigned()->index();
			$table->foreign('screen_group_id')->references('id')->on('screengroups')->onDelete('cascade');

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
		Schema::drop('tickers');
	}
}
