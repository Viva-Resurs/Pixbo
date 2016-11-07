<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Role extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'role';


    public function givePermission($permission) {
        if (is_string($permission)) {
            $permission_model = Permission::where('name', $permission)->first();
            if ($permission_model)
                return $this->permissions()->save($permission_model);
        }
        else
            return $this->permissions()->save( $permission );
    }

    /**
     * Permission association
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }

}
