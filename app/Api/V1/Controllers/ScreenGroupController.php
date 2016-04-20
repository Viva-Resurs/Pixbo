<?php

namespace App\Api\V1\Controllers;

use App\Models\ScreenGroup;

use Illuminate\Http\Request;
use App\Http\Requests;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ScreenGroupController extends BaseController
{
    public function index() {
        
        // TODO: Add Authorization;
        return ScreenGroup::all();
    }

    public function store(Request $request) {
        $screengroup = new ScreenGroup;

        $screengroup->fill([
            'name' => $request->get('name'),
            'desc' => $request->get('desc')
        ]);
        
        if($this->user->screengroups()->save($screengroup))
            return $this->response->created();
        else
            return $this->response->error('could_not_create_screengroup', 500);
    }

    public function show($id) {
        $screengroup = ScreenGroup::find($id);
        if(!$screengroup)
            throw new NotFoundHttpException;

        return $screengroup;
    }

    public function update(Request $request, $id) {
        $screengroup = ScreenGroup::find($id);

        if(!$screengroup)
            throw new NotFoundHttpException;

        if($screengroup->update($request->all())) {
            return $this->response->noContent();
        }

        else
            return $this->response->error('could_not_update_screengroup', 500);
    }

    public function destroy($id) {
        $screengroup = ScreenGroup::find($id);

        if(!$screengroup)
            throw new NotFoundHttpException;

        if($screengroup->delete())
            return $this->response->noContent();
        else
            return $this->response->error('could_not_delete_screengroup', 500);
    }
}
