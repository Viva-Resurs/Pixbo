<?php

namespace App\Api\V1\Controllers;

use Gate;
use Activity;

use Illuminate\Http\Request;

use App\Models\ScreenGroup;

use Input;

use App\Api\V1\Transformers\ScreenGroup\ScreenGroupListTransformer;
use App\Api\V1\Transformers\ScreenGroup\ScreenGroupTransformer;


class ScreenGroupController extends BaseController
{

    public function index() {

        if (Gate::denies('view_screengroups'))
            $this->response->error('permission_denied', 401);

        $screengroups = ScreenGroup::where('id', '<>', 1)->get();

        if(Input::get('list'))
            return $this->collection($screengroups, new ScreenGroupListTransformer());

        return $this->collection($screengroups, new ScreenGroupListTransformer());
    }

    public function store(Request $request) {
        
        if (Gate::denies('add_screengroups'))
            $this->response->error('permission_denied', 401);

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

        if (Gate::denies('view_screengroups'))
            $this->response->error('permission_denied', 401);
        
        $screengroup = ScreenGroup::find($id);

        if (!$screengroup)
            $this->response->error('not_found', 404);

        return $this->item($screengroup, new ScreenGroupTransformer());
    }

    public function update(Request $request, $id) {
        
        if (Gate::denies('edit_screengroups'))
            $this->response->error('permission_denied', 401);
        
        $screengroup = ScreenGroup::find($id);

        if (!$screengroup)
            $this->response->error('not_found', 404);

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

        if (Gate::denies('remove_screengroups'))
            $this->response->error('permission_denied', 401);
        
        $screengroup = ScreenGroup::find($id);

        if (!$screengroup)
            $this->response->error('not_found', 404);

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
