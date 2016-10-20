<?php

namespace App\Api\V1\Controllers;

use Gate;
use Activity;

use App\Models\ScreenGroup;
use App\Models\Screen;


class ScreenGroupScreenController extends BaseController
{

    public function store(ScreenGroup $screengroup, Screen $screen) {
        
        if (Gate::denies('edit_screengroups'))
            $this->response->error('permission_denied', 401);

        $screengroup->screens()->attach($screen->id);

        Activity::log([
            'contentId' => $screengroup->id,
            'contentType' => 'ScreenGroupScreen',
            'action' => 'Attach',
            'description' => 'Attached Screen to ScreenGroup',
            'details' => $screengroup->screens->toJson(),
        ]);

        return $this->response->noContent();
    }

    public function destroy(ScreenGroup $screengroup, Screen $screen) {
        
        if (Gate::denies('edit_screengroups'))
            $this->response->error('permission_denied', 401);

        $screengroup->screens()->detach($screen->id);

        Activity::log([
            'contentId' => $screengroup->id,
            'contentType' => 'ScreenGroupScreen',
            'action' => 'Detach',
            'description' => 'Detached Screen from ScreenGroup',
            'details' => $screengroup->screens->toJson(),
        ]);

        return $this->response->noContent();
    }

}
