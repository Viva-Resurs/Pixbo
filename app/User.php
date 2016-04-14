<?php

namespace App;

use App\Models\Client;
use App\Models\Online;
use App\Models\Role;
use App\Models\ScreenGroup;
use Carbon\Carbon;
use Config;
use DB;
use Hash;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract {
	use Authenticatable, CanResetPassword;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = ['name', 'email', 'password'];
	protected $appends  = ['last_activity', 'role'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = ['password', 'remember_token'];

/**
 * Client association
 * @return [type] [description]
 */
	public function client() {
		return $this->hasOne(Client::class);
	}

/**
 * ScreenGroup association
 * @return [type] [description]
 */
	public function screengroups() {
		return $this->hasMany(ScreenGroup::class);
	}

	public function roles() {
		return $this->belongsToMany(Role::class);
	}

	public function hasRole($role) {
		if (is_string($role)) {
			return $this->roles->contains('name', $role);
		}

		return !!$role->intersect($this->roles)->count();
	}

	public function assignRole($role) {
		if (is_string($role)) {
			$role_model = Role::where('name', $role)->firstOrFail();
			return $this->roles()->save($role_model);
		}

		return $this->roles()->save($role);
	}

	public function online() {
		return $this->hasOne(Online::class);
	}

	public function getLastActivityAttribute() {
		if (!is_null($this->online)) {
			$time = Carbon::now()->timestamp($this->online->last_activity);
			$time->setLocale(Config::get('app.locale'));
			return $time->diffForHumans();
		} else {
			return trans('messages.offline');
		}
	}

	public function getRoleAttribute() {
		$roles       = $this->roles;
		$roles_array = [];
		foreach ($roles as $role) {
			array_push($roles_array, $role->name);
		}
		return $roles_array;
	}

	public static function createUserFromRequest($request) {
		$result = DB::transaction(function () use ($request) {
			$user = new User;
			$user->fill([
				'name'     => $request->input('name'),
				'email'    => $request->input('name') . '@' . Config::get('app.domain'),
				'password' => Hash::make($request->input('password')),
			])->save();
			$role = Role::find($request->input('role_id'))->first();
			$user->roles()->save($role);

			$user->save();
		});
		return is_null($result) ? true : false;
	}

	public function updateUserFromRequest($request) {
		$that = $this;
		$result = DB::transaction(function() use ($request, $that) {
			$that->update($request->all());
			$that->roles()->sync([$request->input('role_id')]);
			$that->save();
		});
		return $result;
	}

	public function setPasswordAttribute($value) {
		// Don't update the password if it's blank!
		if($value != "")
			$this->attributes['password'] = Hash::make($value);
	}
}
