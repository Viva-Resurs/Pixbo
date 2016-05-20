<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Intervention\Image\Exception\NotFoundException;
use Request as R;
use App\Models\Settings;

class PlayerController extends Controller {

    /**
     * Get the Client from given parameter 'mac',
     * fetch all it's association and return the player view
     *
     * @param Request $request
     * @return array|NotFoundException
     */
    public function index(Request $request) {
        $mac     = $request->input('mac');
        $preview = $request->input('preview');

        // Fetch the correct client.
        $client = Client::where('ip_address', $mac)->first();
        if (is_null($client)) {
            return abort(404, trans('exceptions.client_not_found'));
        }
        return view('player.index')->with([
            'client'     => $client->id,
            'preview'    => $preview,
        ]);
    }

    /**
     * The ajax hook to get fresh data.
     *
     * @param Request $request
     * @param $id
     * @return array
     */
    public function show(Request $request, $id) {
        $client = Client::where('id', $id)->first();
        //$data   = $this->getDataFromClient($client);
        //return $data;
        return $client->getData();
    }

}
