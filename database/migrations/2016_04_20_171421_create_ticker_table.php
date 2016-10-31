<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTickerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ticker', function (Blueprint $table) {
            $table->increments('id');
            $table->text('text');

            $table->timestamps();
        });

        Schema::create('screengroup_ticker', function (Blueprint $table) {
            $table->integer('screen_group_id')->unsigned()->index();
            $table->integer('ticker_id')->unsigned()->index();

            $table->foreign('screen_group_id')
                ->references('id')->on('screengroup')->onDelete('cascade');

            $table->foreign('ticker_id')
                ->references('id')->on('ticker')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('ticker');
        Schema::drop('screengroup_ticker');
    }
}
