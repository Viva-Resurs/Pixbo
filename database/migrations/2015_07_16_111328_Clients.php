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
			$table->string('ip_address')->nullable();
			$table->string('mac_address')->nullable();

			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')
				->references('id')->on('users')->onDelete('cascade');

			$table->integer('screengroup_id')->unsigned();
			$table->foreign('screengroup_id')
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
