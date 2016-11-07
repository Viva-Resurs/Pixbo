<?php

/**
 * Created by PhpStorm.
 * User: xergo
 * Date: 20-Apr-16
 * Time: 7:24 PM
 */

namespace App\Api\V1\Transformers\User;

use App\Models\User;
use League\Fractal\TransformerAbstract;

use App\Api\V1\Transformers\RoleTransformer;

class UserTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];
    protected $defaultIncludes = ['roles'];

    public function transform(User $user)
    {
        return [
            'id'      => (int) $user->id,
            'name'    => ucfirst($user->name),
            'email'   => $user->email,
            'isAdmin' => $user->hasRole('admin'),
        ];
    }

    public function includeRoles(User $user) {
        $roles = $user->roles;
        if ($roles)
            return $this->collection($roles, new RoleTransformer());
    }
}
