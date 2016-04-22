<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTickersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickers', function (Blueprint $table) {
            $table->increments('id');
            $table->text('text');

            $table->timestamps();
        });

        Schema::create('screen_group_ticker', function (Blueprint $table) {

            $table->integer('screen_group_id')->unsigned()->index();
            $table->foreign('screen_group_id')->references('id')->on('screengroups')->onDelete('cascade');
            $table->integer('ticker_id')->unsigned()->index();
            $table->foreign('ticker_id')->references('id')->on('tickers')->onDelete('cascade');

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
        Schema::drop('tickers');
        Schema::drop('screen_group_ticker');
    }
}
