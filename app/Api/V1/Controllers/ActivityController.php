<?php

namespace App\Api\V1\Controllers;

use App\Models\Activity;
use App\Api\V1\Transformers\Activity\ActivityTransformer;
use Gate;
use App\Http\Requests;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ActivityController extends BaseController
{
    public function index() {

        if (Gate::denies('view_activity')) {
            $this->response->error('permission_denied', 401);
        }
        // TODO: Add support for selecting a user
        return $this->collection(Activity::all(), new ActivityTransformer());
    }
    
    public function show($id) {
        if (Gate::denies('view_activity')) {
            $this->response->error('permission_denied', 401);
        }
        $activity = Activity::find($id);
        if(!$activity) {
            throw new NotFoundHttpException;
        }

        return $activity;
    }
}