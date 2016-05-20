<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Intervention\Image\Exception\NotFoundException;
use Request as R;
use App\Models\Settings;

class PlayerController extends Controller {

    /**
     * Return the player view with given parameters 'mac' & 'preview'
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request) {
        $mac     = $request->input('mac');
        $preview = $request->input('preview');

        return view('player.index')->with([
            'client'     => $mac,
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
