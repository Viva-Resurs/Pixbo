<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddScreengroupToShadowevent extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('screen_group_shadow_event', function (Blueprint $table) {
            $table->integer('screen_group_id')->unsigned()->index();
            $table->foreign('screen_group_id')->references('id')->on('screengroups')->onDelete('cascade');

            $table->integer('shadow_event_id')->unsigned()->index();
            $table->foreign('shadow_event_id')->references('id')->on('shadowevents')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('screen_group_shadow_event');
    }
}
