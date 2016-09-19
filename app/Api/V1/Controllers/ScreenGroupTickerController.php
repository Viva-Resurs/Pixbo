<?php

namespace App\Api\V1\Controllers;

use Gate;
use Activity;

use App\Http\Requests;

use App\Models\ScreenGroup;
use App\Models\Ticker;


class ScreenGroupTickerController extends BaseController
{

    public function store(ScreenGroup $screengroup, Ticker $ticker) {
        
        if (Gate::denies('edit_screengroups'))
            $this->response->error('permission_denied', 401);

        $screengroup->tickers()->attach($ticker->id);

        Activity::log([
            'contentId' => $screengroup->id,
            'contentType' => 'ScreenGroupTicker',
            'action' => 'Attach',
            'description' => 'Attached Ticker to ScreenGroup',
            'details' => $screengroup->tickers->toJson(),
        ]);

        return $this->response->noContent();
    }

    public function destroy(ScreenGroup $screengroup, Ticker $ticker) {
        
        if (Gate::denies('edit_screengroups'))
            $this->response->error('permission_denied', 401);

        $screengroup->tickers()->detach($ticker->id);

        Activity::log([
            'contentId' => $screengroup->id,
            'contentType' => 'ScreenGroupTicker',
            'action' => 'Detach',
            'description' => 'Detached Ticker from ScreenGroup',
            'details' => $screengroup->tickers->toJson(),
        ]);

        return $this->response->noContent();
    }

}
