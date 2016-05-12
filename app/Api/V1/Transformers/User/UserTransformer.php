<?php

/**
 * Created by PhpStorm.
 * User: xergo
 * Date: 20-Apr-16
 * Time: 7:24 PM
 */

namespace App\Api\V1\Transformers;

use App\Models\User;
use App\Api\V1\Transformers\RoleTransformer;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' 	            => (int) $user->id,
            'name'              => $user->name,
            'email'	            => $user->email,
            'roles'             => $user->roles,
        ];
    }
}