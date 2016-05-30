<?php

namespace App\Api\V1\Controllers;


use App\Models\ScreenGroup;
use Gate;
use Illuminate\Http\Request;
use App\Http\Requests;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Activity;
use Input;

class ScreenGroupScreenController extends BaseController
{

    public function store(Request $request, Screengroup $screengroup, Screen $screen) {
        if (Gate::denies('edit_screengroups')) {
            $this->response->error('permission_denied', 401);
        }

        $screengroup = new ScreenGroup;
        $screengroup->fill($request->only(['name', 'desc']));
        
        if($this->user->screengroups()->save($screengroup)) {
            Activity::log([
                'contentId' => $screengroup->id,
                'contentType' => 'Screengroup',
                'action' => 'Create',
                'description' => 'Created a ScreenGroup',
                'details' => $screengroup->toJson(),
            ]);
            return $this->response->created();
        }
        else {
            return $this->response->error('could_not_create_screengroup', 500);
        }
    }

    public function destroy(Request $request, ScreenGroup $screengroup, Screen $screen) {
        if (Gate::denies('edit_screengroups')) {
            $this->response->error('permission_denied', 401);
        }


        if($screengroup->delete()) {
            Activity::log([
               'contentId' => $screengroup->id,
                'contentType' => 'Screengroup',
                'action' => 'Delete',
                'description' => 'Deleted a ScreenGroup',
                'details' => $screengroup->toJson(),
            ]);
            return $this->response->noContent();
        } else {
            return $this->response->error('could_not_delete_screengroup', 500);
        }
    }
}
