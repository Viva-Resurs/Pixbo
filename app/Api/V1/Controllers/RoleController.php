<?php

namespace App\Api\V1\Controllers;

use Gate;
use App\Models\Role;
use App\Api\V1\Transformers\RoleTransformer;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class RoleController extends BaseController
{
    public function index() {

        if (Gate::denies('view_roles')) {
            return new UnauthorizedHttpException('permission_denied');
            //$this->response->error('permission_denied', 401);
        }
        
        return $this->collection(Role::all(), new RoleTransformer());
    }
}
