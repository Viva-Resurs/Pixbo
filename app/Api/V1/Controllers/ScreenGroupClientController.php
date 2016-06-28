<?php

namespace App\Api\V1\Controllers;


use App\Models\ScreenGroup;
use App\Models\Client;
use Gate;
use App\Http\Requests;
use Activity;

class ScreenGroupClientController extends BaseController
{

    public function destroy(ScreenGroup $screengroup, Client $client) {
        if (Gate::denies('edit_screengroups')) {
            $this->response->error('permission_denied', 401);
        }

        $client->update(['screen_group_id' => 1]);
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
