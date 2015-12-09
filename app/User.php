<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Model;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
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
    protected $fillable = ['name', 'email', 'password', 'client_id'];

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
    public function client()
    {
        return $this->hasOne(Client::class);
    }

/**
 * ScreenGroup association
 * @return [type] [description]
 */
    public function screengroups()
    {
        return $this->hasMany(ScreenGroup::class);
    }

/**
 * Event association
 * @return [type] [description]
 */
    public function events()
    {
        return $this->hasMany(Event::class);
    }

    public function screens()
    {
        return $this->hasMany(Screen::class);
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return !!$role->intersect($this->roles)->count();
    }

    public function assignRole($role)
    {
        if (is_string($role)) {
            $role_model = Role::where('name', $role)->firstOrFail();
            return $this->roles()->save($role_model);
        }

        return $this->roles()->save($role);
    }
}
