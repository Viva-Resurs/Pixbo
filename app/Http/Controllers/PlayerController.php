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

        // Fetch the correct client.
        $client = Client::where('ip_address', $mac)->first();
        
        return view('player.index')->with([
            'client'     => $client->id,
            'client_link'=> $mac,
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
