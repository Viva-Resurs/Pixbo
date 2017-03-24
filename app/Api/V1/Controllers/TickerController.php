<?php

namespace App\Api\V1\Controllers;

use Gate;
use Activity;

use App\Models\Ticker;

use App\Api\V1\Requests\TickerCreationForm;
use App\Api\V1\Requests\TickerUpdateForm;

use App\Api\V1\Transformers\Ticker\TickerTransformer;


class TickerController extends BaseController
{

    public function index() {

        if (Gate::denies('view_ticker'))
            $this->response->error('permission_denied: view_ticker', 401);

        return $this->collection(Ticker::all(), new TickerTransformer());
    }

    public function store(TickerCreationForm $form) {

        if (Gate::denies('add_ticker'))
            $this->response->error('permission_denied: add_ticker', 401);

        $ticker = $form->persist();

        if(!is_null($ticker)) {

            Activity::log([
                'contentId' => $ticker->id,
                'contentType' => 'Ticker',
                'action' => 'Create',
                'description' => 'Created a Ticker',
                'details' => $ticker->toJson(),
            ]);

            return $this->item($ticker, new TickerTransformer());
        }
        else
            return $this->response->error('could_not_create_ticker', 500);
    }

    public function show($id) {

        if (Gate::denies('view_ticker'))
            $this->response->error('permission_denied: view_ticker', 401);

        $ticker = Ticker::find($id);

        if (!$ticker)
            $this->response->error('not_found', 404);

        return $this->item($ticker, new TickerTransformer());
    }

    public function update(TickerUpdateForm $form, $id) {

        if (Gate::denies('edit_ticker'))
            $this->response->error('permission_denied: edit_ticker', 401);

        $ticker = Ticker::find($id);

        if (!$ticker)
            $this->response->error('not_found', 404);

        $result = $form->persist($ticker);

        if (!is_null($result)){

            foreach($ticker->screengroups() as $sg) {
                $sg->touch();
            }

            Activity::log([
                'contentId' => $ticker->id,
                'contentType' => 'Ticker',
                'action' => 'Update',
                'description' => 'Updated a Ticker',
                'details' => $ticker->toJson(),
            ]);

            return $this->response->noContent();
        }
        else
            return $this->response->error('could_not_update_ticker', 500);
    }

    public function destroy($id) {

        if (Gate::denies('remove_ticker'))
            $this->response->error('permission_denied: remove_ticker', 401);

        $ticker = Ticker::find($id);

        if (!$ticker)
            $this->response->error('not_found', 404);

        if ($ticker->delete()){

            $event = $ticker->event->first();
            if(!is_null($event))
                $event->delete();

            $ticker->screengroups()->detach();

            foreach($ticker->screengroups() as $sg) {
                $sg->touch();
            }

            Activity::log([
                'contentId' => $ticker->id,
                'contentType' => 'Ticker',
                'action' => 'Delete',
                'description' => 'Deleted a Ticker',
                'details' => $ticker->toJson(),
            ]);

            return $this->response->noContent();
        }
        else
            return $this->response->error('could_not_delete_ticker', 500);
    }

}
