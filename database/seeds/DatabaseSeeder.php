<?php

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

		$this->call(UserTableSeeder::class);

		Model::reguard();
	}
}

class UserTableSeeder extends Seeder {
	public function run() {
		DB::table('users')->delete();

		User::create([
			'email' => 'admin@viva.se',
			'name' => 'admin',
			'password' => 'admin',
		]);

		foreach (DB::table("users")->get() as $user) {
			DB::table("users")
				->where("id", $user->id)
				->update(array("password" => Hash::make($user->password)));
		}
	}
}
