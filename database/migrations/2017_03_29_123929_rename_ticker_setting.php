<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameTickerSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function($t) {
            $t->renameColumn('ticker_pauseOnItems', 'ticker_speed');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function($t) {
            $t->renameColumn('ticker_speed', 'ticker_pauseOnItems');
        });
    }
}
