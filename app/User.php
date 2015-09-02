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
    protected $fillable = ['name', 'email', 'password'];

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
    public function clients()
    {
        return $this->hasMany('\App\Client');
    }

/**
 * ScreenGroup association
 * @return [type] [description]
 */
    public function screengroups()
    {
        return $this->hasMany('\App\ScreenGroup');
    }

/**
 * Event association
 * @return [type] [description]
 */
    public function events()
    {
        return $this->hasMany('\App\Event');
    }

    public function screens()
    {
        return $this->hasMany('\App\Screen');
    }
}
