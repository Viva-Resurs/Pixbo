<?php

namespace App\Api\V1\Controllers;

use Gate;
use Activity;

use Illuminate\Http\Request;

use App\Models\ScreenGroup;

use App\Api\V1\Transformers\ScreenGroup\ScreenGroupListTransformer;
use App\Api\V1\Transformers\ScreenGroup\ScreenGroupTransformer;


class ScreenGroupController extends BaseController
{

    public function index() {

        if (Gate::denies('view_screengroup'))
            $this->response->error('permission_denied: view_screengroup', 401);

        $screengroups = ScreenGroup::all();

        return $this->collection($screengroups, new ScreenGroupListTransformer());
    }

    public function store(Request $request) {

        if (Gate::denies('add_screengroup'))
            $this->response->error('permission_denied: add_screengroup', 401);

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

            return $this->item($screengroup, new ScreenGroupTransformer());
        }
        else
            return $this->response->error('could_not_create_screengroup', 500);
    }

    public function show($id) {

        if (Gate::denies('view_screengroup'))
            $this->response->error('permission_denied: view_screengroup', 401);

        $screengroup = ScreenGroup::find($id);

        if (!$screengroup)
            $this->response->error('not_found', 404);

        return $this->item($screengroup, new ScreenGroupTransformer());
    }

    public function update(Request $request, $id) {

        if (Gate::denies('view_screengroup'))
            $this->response->error('permission_denied: view_screengroup', 401);

        $screengroup = ScreenGroup::find($id);

        if (!$screengroup)
            $this->response->error('not_found', 404);

        if (Gate::denies('edit_screengroup'))
            $this->response->error('permission_denied: edit_screengroup', 401);

        if ($screengroup->update($request->only(['name', 'desc']))){

            Activity::log([
                'contentId' => $screengroup->id,
                'contentType' => 'Screengroup',
                'action' => 'Update',
                'description' => 'Updated a ScreenGroup',
                'details' => $screengroup->toJson(),
            ]);

            return $this->response->noContent();
        }
        else
            return $this->response->error('could_not_update_screengroup', 500);
    }

    public function destroy($id) {

        if (Gate::denies('view_screengroup'))
            $this->response->error('permission_denied: view_screengroup', 401);

        $screengroup = ScreenGroup::find($id);

        if (!$screengroup)
            $this->response->error('not_found', 404);

        if (Gate::denies('remove_screengroup: remove_screengroup'))
            $this->response->error('permission_denied', 401);

        if ($screengroup->delete()){

            Activity::log([
               'contentId' => $screengroup->id,
                'contentType' => 'Screengroup',
                'action' => 'Delete',
                'description' => 'Deleted a ScreenGroup',
                'details' => $screengroup->toJson(),
            ]);

            return $this->response->noContent();
        }
        else
            return $this->response->error('could_not_delete_screengroup', 500);
    }

}
