<?php

namespace App\Api\V1\Controllers;

use Gate;
use Activity;

use App\Models\ScreenGroup;
use App\Models\Ticker;


class ScreenGroupTickerController extends BaseController
{

    public function destroy(ScreenGroup $screengroup, Ticker $ticker) {

        if (Gate::denies('edit_screengroup'))
            $this->response->error('permission_denied: edit_screengroup', 401);

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
