<?php

use App\Models\Settings;

use Illuminate\Database\Seeder;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->delete();

        $settings = Settings::create([
            'vegas_delay' => config('pixbo.settings.player.vegas.delay'),
            'ticker_speed' => config('pixbo.settings.player.ticker.speed')
        ]);

    }
}
