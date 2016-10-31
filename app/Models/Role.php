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
    protected $table = 'roles';

    /**
     * Permissions association
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions() {
        return $this->belongsToMany(Permission::class);
    }


    public function givePermissionTo($permission) {
        // Attach permission-association using a permission-name
        $p = Permission::where('name', $permission)->first();
        if ($p)
            return $this->permissions()->save( $p );
    }

}
