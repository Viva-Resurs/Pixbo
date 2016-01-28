<?php

use App\Models\Permission;
use App\Models\Role;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run() {
		Model::unguard();

		$this->call(RolesTablesSeeder::class);
		$this->call(UserTableSeeder::class);

		Model::reguard();
	}
}

class RolesTablesSeeder extends Seeder {
	public function run() {
		DB::table('roles')->delete();
		DB::table('permissions')->delete();

		/**
		 * Permissions
		 */

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

		/**
		 * Roles
		 */

		// Admin
		$admin = Role::create([
			'name'  => 'admin',
			'label' => 'auth.administrator',
		]);

		$admin->givePermissionTo($dash);
		$admin->givePermissionTo($player);
		// Clients
		$admin->givePermissionTo($view_clients);
		$admin->givePermissionTo($add_clients);
		$admin->givePermissionTo($edit_clients);
		$admin->givePermissionTo($remove_clients);

		// ScreenGroup
		$admin->givePermissionTo($view_screengroup);
		$admin->givePermissionTo($add_screengroups);
		$admin->givePermissionTo($edit_screengroup);
		$admin->givePermissionTo($remove_screengroup);

		// Screen
		$admin->givePermissionTo($view_screens);
		$admin->givePermissionTo($add_screens);
		$admin->givePermissionTo($edit_screens);
		$admin->givePermissionTo($remove_screens);

		// User
		$admin->givePermissionTo($view_users);
		$admin->givePermissionTo($add_users);
		$admin->givePermissionTo($edit_users);
		$admin->givePermissionTo($remove_users);

		// Role
		$admin->givePermissionTo($view_roles);
		$admin->givePermissionTo($add_roles);
		$admin->givePermissionTo($edit_roles);
		$admin->givePermissionTo($remove_roles);

		// Ticker
		$admin->givePermissionTo($view_tickers);
		$admin->givePermissionTo($add_tickers);
		$admin->givePermissionTo($edit_tickers);
		$admin->givePermissionTo($remove_tickers);

		// Moderator
		$moderator = Role::create([
			'name'  => 'moderator',
			'label' => 'auth.moderator',
		]);
		$moderator->givePermissionTo($dash);
		$moderator->givePermissionTo($view_screengroup);
		$moderator->givePermissionTo($edit_screengroup);
		$moderator->givePermissionTo($view_screens);
		$moderator->givePermissionTo($add_screens);
		$moderator->givePermissionTo($edit_screens);
		$moderator->givePermissionTo($remove_screens);

		// Ticker
		$moderator->givePermissionTo($view_tickers);
		$moderator->givePermissionTo($add_tickers);
		$moderator->givePermissionTo($edit_tickers);
		$moderator->givePermissionTo($remove_tickers);

		// Client
		$client = Role::create([
			'name'  => 'client',
			'label' => 'auth.client',
		]);
		$client->givePermissionTo($player);
	}
}

class UserTableSeeder extends Seeder {
	public function run() {
		DB::table('users')->delete();

		$admin = User::create([
			'email'    => 'admin@viva.se',
			'name'     => 'admin',
			'password' => 'admin',
		]);

		$moderator = User::create([
			'email'    => 'moderator@viva.se',
			'name'     => 'moderator',
			'password' => 'moderator',
		]);

		$admin->assignRole('admin');
		$moderator->assignRole('moderator');

		foreach (DB::table("users")->get() as $user) {
			DB::table("users")
				->where("id", $user->id)
				->update(array("password" => Hash::make($user->password)));
		}
	}
}
