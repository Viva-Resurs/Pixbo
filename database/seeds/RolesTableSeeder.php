<?php

use App\Models\Role;

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->delete();

        // Admin
        $admin = Role::create([
          'name'  => 'admin',
          'label' => 'auth.administrator',
        ]);

        $admin->givePermissionTo('view_dashboard');
        $admin->givePermissionTo('view_player');

        // Clients
        $admin->givePermissionTo('view_clients');
        $admin->givePermissionTo('add_clients');
        $admin->givePermissionTo('edit_clients');
        $admin->givePermissionTo('remove_clients');

        // ScreenGroup
        $admin->givePermissionTo('view_screengroup');
        $admin->givePermissionTo('add_screengroups');
        $admin->givePermissionTo('edit_screengroup');
        $admin->givePermissionTo('remove_screengroup');

        // Screen
        $admin->givePermissionTo('view_screens');
        $admin->givePermissionTo('add_screens');
        $admin->givePermissionTo('edit_screens');
        $admin->givePermissionTo('remove_screens');

        // User
        $admin->givePermissionTo('view_users');
        $admin->givePermissionTo('add_users');
        $admin->givePermissionTo('edit_users');
        $admin->givePermissionTo('remove_users');

        // Role
        $admin->givePermissionTo('view_roles');
        $admin->givePermissionTo('add_roles');
        $admin->givePermissionTo('edit_roles');
        $admin->givePermissionTo('remove_roles');

        // Ticker
        $admin->givePermissionTo('view_tickers');
        $admin->givePermissionTo('add_tickers');
        $admin->givePermissionTo('edit_tickers');
        $admin->givePermissionTo('remove_tickers');

        // Categories
        $admin->givePermissionTo('view_category');
        $admin->givePermissionTo('add_category');
        $admin->givePermissionTo('edit_category');
        $admin->givePermissionTo('remove_category');

        // Site Settings
        $admin->givePermissionTo('edit_site_settings');
        $admin->givePermissionTo('view_activity');


        // Moderator
        $moderator = Role::create([
          'name'  => 'moderator',
          'label' => 'auth.moderator',
        ]);
        $moderator->givePermissionTo('dash');
        $moderator->givePermissionTo('player');

        // ScreenGroup
        $moderator->givePermissionTo('view_screengroup');

        // Screen
        $moderator->givePermissionTo('view_screens');
        $moderator->givePermissionTo('add_screens');
        $moderator->givePermissionTo('edit_screens');
        $moderator->givePermissionTo('remove_screens');

        // Ticker
        $moderator->givePermissionTo('view_tickers');
        $moderator->givePermissionTo('add_tickers');
        $moderator->givePermissionTo('edit_tickers');
        $moderator->givePermissionTo('remove_tickers');

        // Categories
        $moderator->givePermissionTo('view_category');
        $moderator->givePermissionTo('add_category');


        // Client
        $client = Role::create([
          'name'  => 'client',
          'label' => 'auth.client',
        ]);

    }
}
