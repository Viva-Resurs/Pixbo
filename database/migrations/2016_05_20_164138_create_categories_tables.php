<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('user_id')->unsigned();

            $table->foreign('user_id')
                ->references('id')->on('user')->onDelete('cascade');

            $table->timestamps();
        });

        Schema::create('category_screen', function (Blueprint $table) {
            $table->integer('category_id')->unsigned();
            $table->integer('screen_id')->unsigned();
            $table->index(['category_id', 'screen_id']);

            $table->foreign('category_id')
                ->references('id')->on('category')->onDelete('cascade');
            $table->foreign('screen_id')
                ->references('id')->on('screen')->onDelete('cascade');

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
        Schema::drop('categories');
        Schema::drop('category_screen');
    }
}
