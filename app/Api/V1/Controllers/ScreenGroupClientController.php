<?php

namespace App\Api\V1\Controllers;

use Gate;
use Activity;

use App\Models\ScreenGroup;
use App\Models\Client;


class ScreenGroupClientController extends BaseController
{

    /*public function store(ScreenGroup $screengroup, Client $client) {

        if (Gate::denies('edit_screengroup'))
            $this->response->error('permission_denied: edit_screengroup', 401);

        $screengroup->clients()->attach($client->id);
        $screengroup->touch();

        Activity::log([
            'contentId' => $screengroup->id,
            'contentType' => 'ScreenGroupClient',
            'action' => 'Attach',
            'description' => 'Attached Client to ScreenGroup',
            'details' => $screengroup->clients->toJson(),
        ]);

        return $this->response->noContent();
    }*/

    public function destroy(ScreenGroup $screengroup, Client $client) {

        if (Gate::denies('edit_screengroup'))
            $this->response->error('permission_denied: edit_screengroup', 401);

        $client->update(['screen_group_id' => 0]);
        $client->save();

        Activity::log([
            'contentId' => $screengroup->id,
            'contentType' => 'ScreenGroupClient',
            'action' => 'Detach',
            'description' => 'Detached Client from ScreenGroup',
            'details' => $screengroup->clients->toJson(),
        ]);

        return $this->response->noContent();
    }

}
