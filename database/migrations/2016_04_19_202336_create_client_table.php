<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address')->unique();
            $table->integer('activity')->nullable();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')->on('user')->onDelete('cascade');
            $table->integer('screen_group_id')->unsigned()->nullable();
            $table->foreign('screen_group_id')
                ->references('id')->on('screengroup');
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
        Schema::drop('client');
    }
}
