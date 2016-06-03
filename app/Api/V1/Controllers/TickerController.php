<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\TickerCreationForm;
use App\Api\V1\Requests\TickerUpdateForm;
use App\Models\Ticker;
use App\Api\V1\Transformers\Ticker\TickerTransformer;
use Gate;
use App\Http\Requests;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Activity;

class TickerController extends BaseController
{
    /**
     * View all the Tickers
     *
     * @return mixed
     */
    public function index() {

        if (Gate::denies('view_tickers')) {
            $this->response->error('permission_denied', 401);
        }

        return $this->collection(Ticker::all(), new TickerTransformer());
    }

    /**
     * Store the Ticker
     *
     * @param TickerCreationForm $form
     * @return \Dingo\Api\Http\Response|void
     */
    public function store(TickerCreationForm $form) {
        if (Gate::denies('add_tickers')) {
            $this->response->error('permission_denied', 401);
        }

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
        } else {
            return $this->response->error('could_not_create_ticker', 500);
        }
    }

    /**
     * Show the Ticker
     *
     * @param $id
     * @return mixed
     */
    public function show($id) {
        if (Gate::denies('view_tickers')) {
            $this->response->error('permission_denied', 401);
        }
        $ticker = Ticker::findOrFail($id);

        return $this->item($ticker, new TickerTransformer());
    }

    /**
     * Update the Ticker
     *
     * @param TickerUpdateForm $form
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     */
    public function update(TickerUpdateForm $form, $id) {
        if (Gate::denies('edit_tickers')) {
            $this->response->error('permission_denied', 401);
        }
        $ticker = Ticker::findOrFail($id);

        $result = $form->persist($ticker);

        if(!is_null($result)) {
            Activity::log([
                'contentId' => $ticker->id,
                'contentType' => 'Ticker',
                'action' => 'Update',
                'description' => 'Updated a Ticker',
                'details' => $ticker->toJson(),
            ]);
            return $this->response->noContent();
        } else {
            return $this->response->error('could_not_update_ticker', 500);
        }
    }

    /**
     * Delete the Ticker
     *
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     */
    public function destroy($id) {
        if (Gate::denies('remove_tickers')) {
            $this->response->error('permission_denied', 401);
        }
        $ticker = Ticker::find($id);

        if(!$ticker) {
            throw new NotFoundHttpException;
        }

        if($ticker->delete()) {
            Activity::log([
                'contentId' => $ticker->id,
                'contentType' => 'Ticker',
                'action' => 'Delete',
                'description' => 'Deleted a Ticker',
                'details' => $ticker->toJson(),
            ]);
            return $this->response->noContent();
        } else {
            return $this->response->error('could_not_delete_ticker', 500);
        }
    }
}
