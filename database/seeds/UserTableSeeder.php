<?php

use App\Models\User;

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->delete();

        $admin = User::create([
            'email'    => config('pixbo.settings.administration.administrator.email'),
            'name'     => config('pixbo.settings.administration.administrator.username'),
            'password' => config('pixbo.settings.administration.administrator.password'),
        ]);
        $admin->assignRole('admin');

        $moderator = User::create([
            'email'    => config('pixbo.settings.administration.moderator.email'),
            'name'     => config('pixbo.settings.administration.moderator.username'),
            'password' => config('pixbo.settings.administration.moderator.password'),
        ]);
        $moderator->assignRole('moderator');

    }
}
