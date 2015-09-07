<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class EventMetas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('eventmetas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');

            $table->integer('frequency')->unsigned()->nullable();
            $table->string('recur_type')->nullable();
            $table->string('recur_day_num')->nullable();
            $table->string('recur_day')->nullable();
            $table->date('recur_end')->nullable();
            // Screens /ScreenGroups?

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
        Schema::drop('eventmetas');
    }
}
