<?php
/**
 * Created by PhpStorm.
 * User: Christoffer
 * Date: 2016-06-09
 * Time: 14:17
 */

namespace App\Traits;

use App\Models\Role;
use App\Models\Permission;

trait HasRoles
{
    /***********************************************************************************
     *                      ACL                                                        *
     **********************************************************************************/

    /**
     * Role association
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles() {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Check if the User have a given role
     *
     * @param $role
     * @return bool
     */
    public function hasRole($role) {
        if (is_string($role))
            return $this->roles->contains('name', $role);

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
