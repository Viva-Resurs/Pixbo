<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Photos extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('photos', function (Blueprint $table) {
			$table->increments('id');

			$table->integer('screen_id')->nullable();
			$table->foreign('screen_id')
			->references('id')->on('screens');

			$table->string('name');
			$table->string('path');
			$table->string('thumb_path');
			$table->boolean('archived');
			$table->string('sha1');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('photos');
	}
}
