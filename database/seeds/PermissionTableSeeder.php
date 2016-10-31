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
        DB::table('permissions')->delete();

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
            'name'  => 'view_clients',
            'label' => 'auth.view_clients',
        ]);

        $add_clients = Permission::create([
            'name'  => 'add_clients',
            'label' => 'auth.add_clients',
        ]);

        $edit_clients = Permission::create([
            'name'  => 'edit_clients',
            'label' => 'auth.edit_clients',
        ]);

        $remove_clients = Permission::create([
            'name'  => 'remove_clients',
            'label' => 'auth.remove_clients',
        ]);

        // ScreenGroup
        $view_screengroup = Permission::create([
            'name'  => 'view_screengroups',
            'label' => 'auth.view_screengroup',
        ]);

        $add_screengroups = Permission::create([
            'name'  => 'add_screengroups',
            'label' => 'auth.add_screengroups',
        ]);

        $edit_screengroup = Permission::create([
            'name'  => 'edit_screengroups',
            'label' => 'auth.edit_screengroup',
        ]);

        $remove_screengroup = Permission::create([
            'name'  => 'remove_screengroups',
            'label' => 'auth.remove_screengroup',
        ]);

        // Screens
        $view_screens = Permission::create([
            'name'  => 'view_screens',
            'label' => 'auth.view_screens',
        ]);

        $add_screens = Permission::create([
            'name'  => 'add_screens',
            'label' => 'auth.add_screens',
        ]);

        $edit_screens = Permission::create([
            'name'  => 'edit_screens',
            'label' => 'auth.edit_screens',
        ]);

        $remove_screens = Permission::create([
            'name'  => 'remove_screens',
            'label' => 'auth.remove_screens',
        ]);

        // Users
        $view_users = Permission::create([
            'name'  => 'view_users',
            'label' => 'auth.view_users',
        ]);

        $add_users = Permission::create([
            'name'  => 'add_users',
            'label' => 'auth.add_users',
        ]);

        $edit_users = Permission::create([
            'name'  => 'edit_users',
            'label' => 'auth.edit_users',
        ]);

        $remove_users = Permission::create([
            'name'  => 'remove_users',
            'label' => 'auth.remove_users',
        ]);

        // Roles
        $view_roles = Permission::create([
            'name'  => 'view_roles',
            'label' => 'auth.view_roles',
        ]);

        $add_roles = Permission::create([
            'name'  => 'add_roles',
            'label' => 'auth.add_roles',
        ]);

        $edit_roles = Permission::create([
            'name'  => 'edit_roles',
            'label' => 'auth.edit_roles',
        ]);

        $remove_roles = Permission::create([
            'name'  => 'remove_roles',
            'label' => 'auth.remove_roles',
        ]);

        // Tickers
        $view_tickers = Permission::create([
            'name'  => 'view_tickers',
            'label' => 'auth.view_tickers',
        ]);

        $add_tickers = Permission::create([
            'name'  => 'add_tickers',
            'label' => 'auth.add_tickers',
        ]);

        $edit_tickers = Permission::create([
            'name'  => 'edit_tickers',
            'label' => 'auth.edit_tickers',
        ]);

        $remove_tickers = Permission::create([
            'name'  => 'remove_tickers',
            'label' => 'auth.remove_tickers',
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

    }
}
