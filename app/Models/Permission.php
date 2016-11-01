<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Permission extends Model
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'permission';

    /**
     * Role association
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

}
