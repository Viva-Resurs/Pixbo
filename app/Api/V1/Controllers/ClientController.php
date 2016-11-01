<?php

namespace App\Api\V1\Controllers;

use Gate;
use Activity;

use Illuminate\Http\Request;

use App\Models\Client;

use Input;

use App\Api\V1\Requests\ClientCreationForm;

use App\Api\V1\Transformers\Client\ClientTransformer;


class ClientController extends BaseController
{

    public function index() {

        if (Gate::denies('view_client'))
            $this->response->error('permission_denied', 401);

        return $this->collection(Client::all(), new ClientTransformer());
    }

    public function store(ClientCreationForm $form) {

        if (Gate::denies('add_client'))
            $this->response->error('permission_denied', 401);

        $client = $form->persist();

        if($client) {

            Activity::log([
                'contentId' => $client->id,
                'contentType' => 'Client',
                'action' => 'Create',
                'description' => 'Created a Client',
                'details' => 'Client: '.$client->toJson(),
            ]);

            return $this->response->created();
        }
        else
            return $this->response->error('could_not_create_client', 500);
    }

    public function show($id) {

        if (Gate::denies('view_client'))
            $this->response->error('permission_denied', 401);

        $client = Client::find($id);

        if (!$client)
            $this->response->error('not_found', 404);

        return $this->item($client, new ClientTransformer());
    }

    public function update(Request $request, $id) {

        if (Gate::denies('edit_client'))
            $this->response->error('permission_denied', 401);

        $client = Client::find($id);

        if (!$client)
            $this->response->error('not_found', 404);

        if ($client->update($request->only(['name', 'address', 'screen_group_id']))){

            Activity::log([
                'contentId' => $client->id,
                'contentType' => 'Client',
                'action' => 'Update',
                'description' => 'Updated a Client',
                'details' => 'Client: '.$client->toJson(),
            ]);

            return $this->response->noContent();
        }
        else
            return $this->response->error('could_not_update_client', 500);
    }

    public function destroy($id) {

        if (Gate::denies('remove_client'))
            $this->response->error('permission_denied', 401);

        $client = Client::find($id);

        if (!$client)
            $this->response->error('not_found', 404);

        if($client->delete()) {

            Activity::log([
                'contentId' => $client->id,
                'contentType' => 'Client',
                'action' => 'Delete',
                'description' => 'Deleted a Client',
                'details' => 'Client: '.$client->toJson(),
            ]);

            return $this->response->noContent();
        }
        else
            return $this->response->error('could_not_delete_client', 500);
    }

}
