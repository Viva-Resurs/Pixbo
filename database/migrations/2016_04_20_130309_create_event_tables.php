<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEventTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');

            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

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

        Schema::create('shadow_events', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
            $table->boolean('isAllDay');
            $table->dateTime('start');
            $table->dateTime('end');
            $table->integer('event_id')->unsigned();
            $table->timestamps();

            $table->foreign('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('events');
        Schema::drop('shadow_events');
    }
}
