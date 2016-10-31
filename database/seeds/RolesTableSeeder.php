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
        DB::table('role')->delete();
        // DB::table('role_permission')->delete();
        // DB::table('role_user')->delete();

        // Admin
        $admin = Role::create([
          'name'  => 'admin',
          'label' => 'auth.administrator',
        ]);

        $admin->givePermission('view_dashboard');
        $admin->givePermission('view_player');

        // Clients
        $admin->givePermission('view_clients');
        $admin->givePermission('add_clients');
        $admin->givePermission('edit_clients');
        $admin->givePermission('remove_clients');

        // ScreenGroup
        $admin->givePermission('view_screengroup');
        $admin->givePermission('add_screengroups');
        $admin->givePermission('edit_screengroup');
        $admin->givePermission('remove_screengroup');

        // Screen
        $admin->givePermission('view_screens');
        $admin->givePermission('add_screens');
        $admin->givePermission('edit_screens');
        $admin->givePermission('remove_screens');

        // User
        $admin->givePermission('view_users');
        $admin->givePermission('add_users');
        $admin->givePermission('edit_users');
        $admin->givePermission('remove_users');

        // Role
        $admin->givePermission('view_roles');
        $admin->givePermission('add_roles');
        $admin->givePermission('edit_roles');
        $admin->givePermission('remove_roles');

        // Ticker
        $admin->givePermission('view_tickers');
        $admin->givePermission('add_tickers');
        $admin->givePermission('edit_tickers');
        $admin->givePermission('remove_tickers');

        // Categories
        $admin->givePermission('view_category');
        $admin->givePermission('add_category');
        $admin->givePermission('edit_category');
        $admin->givePermission('remove_category');

        // Site Settings
        $admin->givePermission('edit_site_settings');
        $admin->givePermission('view_activity');


        // Moderator
        $moderator = Role::create([
          'name'  => 'moderator',
          'label' => 'auth.moderator',
        ]);
        $moderator->givePermission('dash');
        $moderator->givePermission('player');

        // ScreenGroup
        $moderator->givePermission('view_screengroup');

        // Screen
        $moderator->givePermission('view_screens');
        $moderator->givePermission('add_screens');
        $moderator->givePermission('edit_screens');
        $moderator->givePermission('remove_screens');

        // Ticker
        $moderator->givePermission('view_tickers');
        $moderator->givePermission('add_tickers');
        $moderator->givePermission('edit_tickers');
        $moderator->givePermission('remove_tickers');

        // Categories
        $moderator->givePermission('view_category');
        $moderator->givePermission('add_category');


        // Client
        $client = Role::create([
          'name'  => 'client',
          'label' => 'auth.client',
        ]);

    }
}
