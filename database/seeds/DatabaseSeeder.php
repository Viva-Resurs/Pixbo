<?php

use App\Permission;
use App\Role;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(RolesTablesSeeder::class);
        $this->call(UserTableSeeder::class);

        Model::reguard();
    }
}

class RolesTablesSeeder extends Seeder
{
    public function run()
    {
        DB::table('roles')->delete();
        DB::table('permissions')->delete();

        /**
         * Permissions
         */

        // Dashboard
        $dash = Permission::create([
            'name' => 'view_dashboard',
            'label' => 'auth.view_dashboard',
        ]);

        // Player
        $player = Permission::create([
            'name' => 'view_player',
            'label' => 'auth.view_player',
        ]);

        // Client
        $view_clients = Permission::create([
            'name' => 'view_clients',
            'label' => 'auth.view_clients',
        ]);

        $add_clients = Permission::create([
            'name' => 'add_clients',
            'label' => 'auth.add_clients',
        ]);

        $edit_clients = Permission::create([
            'name' => 'edit_clients',
            'label' => 'auth.edit_clients',
        ]);

        $remove_clients = Permission::create([
            'name' => 'remove_clients',
            'label' => 'auth.remove_clients',
        ]);

        // ScreenGroup
        $view_screengroup = Permission::create([
            'name' => 'view_screengroup',
            'label' => 'auth.view_screengroup',
        ]);

        $add_screengroups = Permission::create([
            'name' => 'add_screengroups',
            'label' => 'auth.add_screengroups',
        ]);

        $edit_screengroup = Permission::create([
            'name' => 'edit_screengroup',
            'label' => 'auth.edit_screengroup',
        ]);

        $remove_screengroup = Permission::create([
            'name' => 'remove_screengroup',
            'label' => 'auth.remove_screengroup',
        ]);

        // Screens
        $view_screens = Permission::create([
            'name' => 'view_screens',
            'label' => 'auth.view_screens',
        ]);

        $add_screens = Permission::create([
            'name' => 'add_screens',
            'label' => 'auth.add_screens',
        ]);

        $edit_screens = Permission::create([
            'name' => 'edit_screens',
            'label' => 'auth.edit_screens',
        ]);

        $remove_screens = Permission::create([
            'name' => 'remove_screens',
            'label' => 'auth.remove_screens',
        ]);

        // Users
        $view_users = Permission::create([
            'name' => 'view_users',
            'label' => 'auth.view_users',
        ]);

        $add_users = Permission::create([
            'name' => 'add_users',
            'label' => 'auth.add_users',
        ]);

        $edit_users = Permission::create([
            'name' => 'edit_users',
            'label' => 'auth.edit_users',
        ]);

        $remove_users = Permission::create([
            'name' => 'remove_users',
            'label' => 'auth.remove_users',
        ]);

        /**
         * Roles
         */

        // Admin
        $admin = Role::create([
            'name' => 'admin',
            'label' => 'auth.administrator',
        ]);

        $admin->givePermissionTo($dash);
        $admin->givePermissionTo($player);
        $admin->givePermissionTo($view_clients);
        $admin->givePermissionTo($add_clients);
        $admin->givePermissionTo($edit_clients);
        $admin->givePermissionTo($remove_clients);
        $admin->givePermissionTo($view_screengroup);
        $admin->givePermissionTo($add_screengroups);
        $admin->givePermissionTo($edit_screengroup);
        $admin->givePermissionTo($remove_screengroup);
        $admin->givePermissionTo($view_screens);
        $admin->givePermissionTo($add_screens);
        $admin->givePermissionTo($edit_screens);
        $admin->givePermissionTo($remove_screens);
        $admin->givePermissionTo($view_users);
        $admin->givePermissionTo($add_users);
        $admin->givePermissionTo($edit_users);
        $admin->givePermissionTo($remove_users);

        // Moderator
        $moderator = Role::create([
            'name' => 'moderator',
            'label' => 'auth.moderator',
        ]);
        $moderator->givePermissionTo($dash);
        $moderator->givePermissionTo($view_screengroup);
        $moderator->givePermissionTo($edit_screengroup);
        $moderator->givePermissionTo($view_screens);
        $moderator->givePermissionTo($add_screens);
        $moderator->givePermissionTo($edit_screens);
        $moderator->givePermissionTo($remove_screens);

        // Client
        $client = Role::create([
            'name' => 'client',
            'label' => 'auth.client',
        ]);
        $client->givePermissionTo($player);
    }
}

class UserTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->delete();

        $user = User::create([
            'email' => 'admin@viva.se',
            'name' => 'admin',
            'password' => 'admin',
        ]);

        $user->assignRole('admin');

        foreach (DB::table("users")->get() as $user) {
            DB::table("users")
                ->where("id", $user->id)
                ->update(array("password" => Hash::make($user->password)));
        }
    }
}
