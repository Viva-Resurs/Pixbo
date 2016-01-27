<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\Role;
use App\Models\ScreenGroup;
use App\User;
use DB;
use Gate;
use Hash;
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
        if (Gate::denies('view_clients')) {
            abort(403);
        }

        $clients = Client::all();

        if (Request::wantsJson()) {
            return $clients;
        } else {
            return view('clients.index')->with('clients', $clients);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        if (Gate::denies('add_clients')) {
            abort(403);
        }
        $client = new Client;
        $screenGroups = ScreenGroup::lists('name', 'id')->all();
        //array_push($screenGroups, trans('messages.default'));
        //dd($screenGroups);

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
        if (Gate::denies('add_clients')) {
            abort(403);
        }
        if ($this->createClientUser($request)) {
            flash()->success('Client created successfully.');
        }

        if (Request::wantsJson()) {
            return $client;
        } else {
            return redirect('admin\clients');
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
        if (Gate::denies('edit_clients')) {
            abort(403);
        }
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
        if (Gate::denies('edit_clients')) {
            abort(403);
        }
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
        if (Gate::denies('edit_clients')) {
            abort(403);
        }
        if ($client->update($request->all())) {
            flash()->success('Client updated successfully.');
        }

        if (Request::wantsJson()) {
            return $client;
        } else {
            return redirect('admin/clients');
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
        if (Gate::denies('remove_clients')) {
            abort(403);
        }
        $deleted = $client->delete();

        if ($deleted) {
            flash()->success('Client removed successfully.');
        }

        if (Request::wantsJson()) {
            return (string) $deleted;
        } else {
            return redirect('clients');
        }
    }

    private function createClientUser(ClientRequest $request)
    {
        $results = DB::transaction(function () use ($request) {
            $client = new Client($request->all());
            $user = new User;
            $user->fill([
                'name' => $client->name,
                'email' => $client->name . '@viva.se',
                'password' => Hash::make($client->name),
            ])->save();
            $role = Role::where('name', 'client')->first();
            $user->assignRole($role);
            $user->client()->save($client);
        });

        return $results;
    }
}
