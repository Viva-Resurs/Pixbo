<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;


/**
 * App\Models\User
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\ScreenGroup[] $screengroups
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;

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

    protected $appends = ['role'];

    /**
     * This mutator automatically hashes the password.
     *
     * @var string
     */
    public function setPasswordAttribute($value)
    {
        if($value != "" || $value != null)
            $this->attributes['password'] = \Hash::make($value);
    }


    /***********************************************************************************
     *                      Associations                                               *
     **********************************************************************************/

    /**
     * Screengroup association
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function screengroups() {
        return $this->hasMany(ScreenGroup::class);
    }

    /**
     * Client association
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function clients() {
        return $this->hasMany(Client::class);
    }

    /**
     * Role association
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    /***********************************************************************************
     *                      ACL                                                        *
     **********************************************************************************/

    /**
     * Check if the User have a given role
     *
     * @param $role
     * @return bool
     */
    public function hasRole($role) {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return !!$role->intersect($this->roles)->count();
    }

    /**
     * Assign a given role to the User
     *
     * @param $role
     * @return Model
     */
    public function assignRole($role) {
        if (is_string($role)) {
            $role_model = Role::where('name', $role)->firstOrFail();
            return $this->roles()->save($role_model);
        }

        return $this->roles()->save($role);
    }

    /**
     * Get an array of the Users roles
     *
     * @return array
     */
    public function getRoleAttribute() {
        $roles       = $this->roles;
        $roles_array = [];
        foreach ($roles as $role) {
            array_push($roles_array, $role->name);
        }
        return $roles_array;
    }
}