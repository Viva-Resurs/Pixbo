<?php

namespace App\Api\V1\Controllers;

use Gate;

use App\Models\Role;

use App\Api\V1\Transformers\RoleTransformer;


class RoleController extends BaseController
{

    public function index() {

        if (Gate::denies('view_role'))
            $this->response->error('permission_denied: view_role', 401);

        return $this->collection(Role::all(), new RoleTransformer());
    }

}
