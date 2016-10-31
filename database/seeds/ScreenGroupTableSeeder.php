<?php

use App\Models\ScreenGroup;

use Illuminate\Database\Seeder;

class ScreenGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('screengroups')->delete();

        $screengroup = ScreenGroup::create([
            'id' => 1,
            'name' => config('pixbo.settings.screengroup.dummy_name'),
            'desc' => '',
            'user_id' => 1
        ]);

    }
}
