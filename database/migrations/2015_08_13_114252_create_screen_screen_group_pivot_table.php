<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateScreenScreenGroupPivotTable extends Migration {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up() {
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
		Schema::drop('screen_screen_group');
	}
}
