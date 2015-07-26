<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests\ClientRequest;
use App\Http\Controllers\Controller;
use App\Client;
use App\ScreenGroup;

//App\Client::create(['name' => 'test1', 'ip:address' => '0.0.0.0', 'mac_address' => '00:00:00:00:00:00', 'user_id' => 1, 'screengroup_id' => 0, 'is_active' =>0]);


class ClientsController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$clients =  Client::all();

		if(Request::wantsJson()) {
			return $clients;
		} else {
			return view('clients.index', compact('clients'));
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		$client = new Client;
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
		$client = Client::create($request->all());

		if(Request::wantsJson()) {
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
		if(Request::wantsJson()) {
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
		$client->update($request->all());

		if(Request::wantsJson()) {
			return $client;
		} else {
			return redirect('clients');
		}

	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy(Client $client) {
		$deleted = $client->delete();

		if(Request::wantsJson()) {
			return (string) $deleted;
		} else {
			return redirect('clients');
		}

	}
}
