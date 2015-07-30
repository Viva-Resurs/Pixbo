<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Images extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('images', function (Blueprint $table) {
			$table->increments('id');
			$table->string('path');
			$table->boolean('archived');
			$table->integer('imageable_id');
			$table->string('imageable_type');

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
		Schema::drop('images');
	}
}
