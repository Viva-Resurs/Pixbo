<?php

namespace App\Api\V1\Controllers;

use Gate;

use App\Models\Activity;

use App\Api\V1\Transformers\Activity\ActivityTransformer;


class ActivityController extends BaseController
{

    public function index($user_id = false) {

        if (Gate::denies('view_activity'))
            $this->response->error('permission_denied', 401);

        if ($user_id)
            return $this->collection(Activity::where('user_id',$user_id)->get(), new ActivityTransformer());

        return $this->collection(Activity::all(), new ActivityTransformer());
    }

    public function show($id) {

        if (Gate::denies('view_activity'))
            $this->response->error('permission_denied', 401);

        $activity = Activity::find($id);

        if(!$activity)
            $this->response->error('not_found', 404);

        return $activity;
    }

    public function destroy($id) {

        if (Gate::denies('edit_activity'))
            $this->response->error('permission_denied', 401);

        $activity = Activity::find($id);

        if(!$activity)
            $this->response->error('not_found', 404);

        if ($activity->delete())
            return $this->response->noContent();
        else
            return $this->response->error('could_not_delete_activity', 500);
    }

}
