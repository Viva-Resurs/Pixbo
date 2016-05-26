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

            $table->time('start_time')->default('07:00');
            $table->time('end_time')->default('17:30');

            $table->integer('frequency')->default(1);
            $table->string('recur_type')->default('none');
            $table->json('weekly_day_num')->default('[]'); // array
            $table->string('monthly_day_num')->default(1); // single value
            $table->string('recur_day')->default(1);
            $table->integer('days_before_event')->default(0);

            $table->morphs('eventable');

            $table->timestamps();
        });

        Schema::create('shadow_events', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title');
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
