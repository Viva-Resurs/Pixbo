<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class PlayerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $client = Auth::user()->client->with('screengroup.screens.photo')->get();

        if ($client->count() > 0) {
            $client = $client->toArray();
            $screens = $client[0]['screengroup']['screens'];
            $list;

            foreach ($screens as $screen) {
                $list[] = $screen['photo'];
            }
            return view('player.index')->with('list', $list);
        }
        return abort(404, 'You lack permission to view this content.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }
}
