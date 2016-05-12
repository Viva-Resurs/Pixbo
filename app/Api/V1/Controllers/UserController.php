<?php

namespace App\Api\V1\Controllers;

use Activity;
use Gate;
use Illuminate\Http\Request;
use App\Models\User;
use App\Api\V1\Transformers\UserTransformer;
use Input;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserController extends BaseController
{
    public function index() {

        if (Gate::denies('view_clients')) {
            $this->response->error('permission_denied', 401);
        }
        
        return $this->collection(User::all(), new UserTransformer());
        
    }

    public function store(Request $request) {
        if (Gate::denies('add_clients')) {
            $this->response->error('permission_denied', 401);
        }
        $client = new Client;
        $client->fill($request->only(['name', 'ip_address', 'screen_group_id']));

        if($this->user->clients()->save($client)) {
            Activity::log([
                'contentId' => $client->id,
                'contentType' => 'Client',
                'action' => 'Create',
                'description' => 'Created a Client',
                'details' => 'Client: '.$client->toJson(),
            ]);
            return $this->response->created();
        }
        else {
            return $this->response->error('could_not_create_client', 500);
        }
    }
    public function me() {
        return $this->item($this->getAuthenticatedUser(), new UserTransformer() );
    }

    public function show($id) {
        if (Gate::denies('view_clients')) {
            $this->response->error('permission_denied', 401);
        }
        $client = Client::find($id);
        if(!$client) {
            throw new NotFoundHttpException;
        }

        return $client;
    }

    public function update(Request $request, $id) {
        if (Gate::denies('edit_clients')) {
            $this->response->error('permission_denied', 401);
        }
        $client = Client::find($id);

        if(!$client) {
            throw new NotFoundHttpException;
        }

        if($client->update($request->only(['name', 'ip_address', 'screen_group_id']))) {
            Activity::log([
                'contentId' => $client->id,
                'contentType' => 'Client',
                'action' => 'Update',
                'description' => 'Updated a Client',
                'details' => 'Client: '.$client->toJson(),
            ]);
            return $this->response->noContent();
        } else {
            return $this->response->error('could_not_update_client', 500);
        }
    }

    public function destroy($id) {
        if (Gate::denies('remove_clients')) {
            $this->response->error('permission_denied', 401);
        }
        $client = Client::find($id);

        if(!$client) {
            throw new NotFoundHttpException;
        }

        if($client->delete()) {
            Activity::log([
                'contentId' => $client->id,
                'contentType' => 'Client',
                'action' => 'Delete',
                'description' => 'Deleted a Client',
                'details' => 'Client: '.$client->toJson(),
            ]);
            return $this->response->noContent();
        } else {
            return $this->response->error('could_not_delete_client', 500);
        }
    }
}
