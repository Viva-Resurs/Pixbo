<?php

use App\Models\Permission;

use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission')->truncate();

        // Dashboard
        $dash = Permission::create([
            'name'  => 'view_dashboard',
            'label' => 'auth.view_dashboard',
        ]);

        // Player
        $player = Permission::create([
            'name'  => 'view_player',
            'label' => 'auth.view_player',
        ]);

        // Client
        $view_clients = Permission::create([
            'name'  => 'view_client',
            'label' => 'auth.view_client',
        ]);

        $add_clients = Permission::create([
            'name'  => 'add_client',
            'label' => 'auth.add_client',
        ]);

        $edit_clients = Permission::create([
            'name'  => 'edit_client',
            'label' => 'auth.edit_client',
        ]);

        $remove_clients = Permission::create([
            'name'  => 'remove_client',
            'label' => 'auth.remove_client',
        ]);

        // ScreenGroup
        $view_screengroup = Permission::create([
            'name'  => 'view_screengroup',
            'label' => 'auth.view_screengroup',
        ]);

        $add_screengroups = Permission::create([
            'name'  => 'add_screengroup',
            'label' => 'auth.add_screengroup',
        ]);

        $edit_screengroup = Permission::create([
            'name'  => 'edit_screengroup',
            'label' => 'auth.edit_screengroup',
        ]);

        $remove_screengroup = Permission::create([
            'name'  => 'remove_screengroup',
            'label' => 'auth.remove_screengroup',
        ]);

        // Screens
        $view_screens = Permission::create([
            'name'  => 'view_screen',
            'label' => 'auth.view_screen',
        ]);

        $add_screens = Permission::create([
            'name'  => 'add_screen',
            'label' => 'auth.add_screen',
        ]);

        $edit_screens = Permission::create([
            'name'  => 'edit_screen',
            'label' => 'auth.edit_screen',
        ]);

        $remove_screens = Permission::create([
            'name'  => 'remove_screen',
            'label' => 'auth.remove_screen',
        ]);

        // Users
        $view_users = Permission::create([
            'name'  => 'view_user',
            'label' => 'auth.view_user',
        ]);

        $add_users = Permission::create([
            'name'  => 'add_user',
            'label' => 'auth.add_user',
        ]);

        $edit_users = Permission::create([
            'name'  => 'edit_user',
            'label' => 'auth.edit_user',
        ]);

        $remove_users = Permission::create([
            'name'  => 'remove_user',
            'label' => 'auth.remove_user',
        ]);

        // Roles
        $view_roles = Permission::create([
            'name'  => 'view_role',
            'label' => 'auth.view_role',
        ]);

        $add_roles = Permission::create([
            'name'  => 'add_role',
            'label' => 'auth.add_role',
        ]);

        $edit_roles = Permission::create([
            'name'  => 'edit_role',
            'label' => 'auth.edit_role',
        ]);

        $remove_roles = Permission::create([
            'name'  => 'remove_role',
            'label' => 'auth.remove_role',
        ]);

        // Tickers
        $view_tickers = Permission::create([
            'name'  => 'view_ticker',
            'label' => 'auth.view_ticker',
        ]);

        $add_tickers = Permission::create([
            'name'  => 'add_ticker',
            'label' => 'auth.add_ticker',
        ]);

        $edit_tickers = Permission::create([
            'name'  => 'edit_ticker',
            'label' => 'auth.edit_ticker',
        ]);

        $remove_tickers = Permission::create([
            'name'  => 'remove_ticker',
            'label' => 'auth.remove_ticker',
        ]);

        // Categories
        $view_category = Permission::create([
            'name'  => 'view_category',
            'label' => 'auth.view_category',
        ]);

        $add_category = Permission::create([
            'name'  => 'add_category',
            'label' => 'auth.add_category',
        ]);

        $edit_category = Permission::create([
            'name'  => 'edit_category',
            'label' => 'auth.edit_category',
        ]);

        $remove_category = Permission::create([
            'name'  => 'remove_category',
            'label' => 'auth.remove_category',
        ]);

        // Global site permissions
        $edit_site_settings = Permission::create([
            'name' => 'edit_site_settings',
            'label' => 'auth.edit_site_settings'
        ]);

        $view_activity = Permission::create([
            'name' => 'view_activity',
            'label' => 'auth.view_activity'
        ]);

        $view_activity = Permission::create([
            'name' => 'edit_activity',
            'label' => 'auth.edit_activity'
        ]);

    }
}
