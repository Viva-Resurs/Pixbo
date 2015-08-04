<?php
namespace App\Http\Controllers;

use App\Client;
use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\ScreenGroup;
use Auth;
use Request;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $clients = Client::all();

        if (Request::wantsJson()) {
            return $clients;
        } else {
            $data = Client::paginate(10);
            return view('clients.index')->with('data', $data);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $client       = new Client;
        $screenGroups = ScreenGroup::lists('name', 'id')->all();

        return view('clients.create', compact('client', 'screenGroups'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(ClientRequest $request)
    {
        flash()->success('Client created successfully.');
        $client = new Client($request->all());
        Auth::user()->clients()->save($client);

        if (Request::wantsJson()) {
            return $client;
        } else {
            return redirect('clients');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  Client $client
     * @return Response
     */
    public function show(Client $client)
    {
        if (Request::wantsJson()) {
            return $client;
        } else {
            return view('clients.show', compact('client'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Client $client
     * @return Response
     */
    public function edit(Client $client)
    {
        $screenGroups = ScreenGroup::lists('name', 'id')->all();

        return view('clients.edit', compact('client', 'screenGroups'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(ClientRequest $request, Client $client)
    {
        flash()->success('Client updated successfully.');
        $client->update($request->all());

        if (Request::wantsJson()) {
            return $client;
        } else {
            return redirect('clients');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Client  $client
     * @return Response
     */
    public function destroy(Client $client)
    {
        flash()->success('Client removed successfully.');
        $deleted = $client->delete();

        if (Request::wantsJson()) {
            return (string) $deleted;
        } else {
            return redirect('clients');
        }
    }
}
