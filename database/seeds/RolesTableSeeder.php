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
        DB::table('role')->truncate();
        DB::table('permission_role')->truncate();

        // Admin
        $admin = Role::create([
          'name'  => 'admin',
          'label' => 'auth.administrator',
        ]);

        $admin->givePermission('view_dashboard');
        $admin->givePermission('view_player');

        // Clients
        $admin->givePermission('view_client');
        $admin->givePermission('add_client');
        $admin->givePermission('edit_client');
        $admin->givePermission('remove_client');

        // ScreenGroup
        $admin->givePermission('view_screengroup');
        $admin->givePermission('add_screengroup');
        $admin->givePermission('edit_screengroup');
        $admin->givePermission('remove_screengroup');

        // Screen
        $admin->givePermission('view_screen');
        $admin->givePermission('add_screen');
        $admin->givePermission('edit_screen');
        $admin->givePermission('remove_screen');

        // User
        $admin->givePermission('view_user');
        $admin->givePermission('add_user');
        $admin->givePermission('edit_user');
        $admin->givePermission('remove_user');

        // Role
        $admin->givePermission('view_role');
        $admin->givePermission('add_role');
        $admin->givePermission('edit_role');
        $admin->givePermission('remove_role');

        // Ticker
        $admin->givePermission('view_ticker');
        $admin->givePermission('add_ticker');
        $admin->givePermission('edit_ticker');
        $admin->givePermission('remove_ticker');

        // Categories
        $admin->givePermission('view_category');
        $admin->givePermission('add_category');
        $admin->givePermission('edit_category');
        $admin->givePermission('remove_category');

        // Site Settings
        $admin->givePermission('edit_site_settings');
        $admin->givePermission('view_activity');
        $admin->givePermission('edit_activity');


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
        $moderator->givePermission('view_screen');
        $moderator->givePermission('add_screen');
        $moderator->givePermission('edit_screen');
        $moderator->givePermission('remove_screen');

        // Ticker
        $moderator->givePermission('view_ticker');
        $moderator->givePermission('add_ticker');
        $moderator->givePermission('edit_ticker');
        $moderator->givePermission('remove_ticker');

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
