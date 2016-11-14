<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Settings;
use Illuminate\Http\Request;

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
            'Client_ADDR' => $mac,
            'preview'     => $preview,
        ]);
    }

    /**
     * Ajax hook for the player
     *
     * @param Request $request
     * @param $address
     */
    public function show(Request $request, $address) {
        $client = Client::where('address', $address)->firstOrFail();

        return [
            'photo_list' => $client->getPhotos(),
            'tickers'    => $client->getTickers(),
            'updated_at' => $client->getLastUpdated(),
            'settings'   => Settings::getSettings()
        ];
    }

}
