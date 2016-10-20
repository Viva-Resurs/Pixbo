<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class Clients extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
		Schema::create('clients', function (Blueprint $table) {
			$table->increments('id');
			$table->string('name');
			$table->string('ip_address')->unique();

			$table->integer('screen_group_id')->unsigned()->nullable();
			$table->foreign('screen_group_id')
				->references('id')->on('screengroups');

			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down() {
		Schema::drop('clients');
	}
}
