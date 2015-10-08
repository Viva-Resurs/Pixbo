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
        $client = Auth::user()->client->with('screengroup.screens')->get();
        dd($client->screengroup);
        //$screengroup = $client->screengroup;

        //$screens = \App\Screen::where(['client_id' => $client->id]);
        //dd($screengroup);
        $screens = $screengroup->screens()->get();

        dd($screens);
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
