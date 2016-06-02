<?php

namespace App\Api\V1\Controllers;

use Activity;
use Gate;
use Illuminate\Http\Request;
use App\Models\User;
use App\Api\V1\Transformers\User\UserTransformer;

class UserController extends BaseController
{
    public function index() {

        if (Gate::denies('view_users')) {
            $this->response->error('permission_denied', 401);
        }
        $users = User::with('roles')->where('id', '<>', $this->getAuthenticatedUser()->id)->get();
        return $this->collection($users, new UserTransformer());
        
    }

    public function show($id) {
        if (Gate::denies('view_users')) {
            $this->response->error('permission_denied', 401);
        }
        $user = User::findOrFail($id);

        return $this->item($user, new UserTransformer());
    }


    public function store(Request $request) {
        if (Gate::denies('add_users')) {
            $this->response->error('permission_denied', 401);
        }

        $user = new User;
        $user->fill($request->only(['name', 'email', 'password']));

        if($user->save()) {
            $user->roles()->sync($this->getSlimRolesFromRequest($request));
            
            Activity::log([
                'contentId' => $user->id,
                'contentType' => 'User',
                'action' => 'Create',
                'description' => 'Created the user '.$user->name,
                'details' => $user->toJson(),
            ]);
            return $this->response->created();
        }
        else {
            return $this->response->error('could_not_create_user', 500);
        }
    }


    public function me() {
        return $this->item($this->getAuthenticatedUser(), new UserTransformer() );
    }


    public function update(Request $request, $id) {
        if (Gate::denies('edit_users')) {
            $this->response->error('permission_denied', 401);
        }
        $user = User::findOrFail($id);

        if($user->update($request->only(['name', 'email', 'password']))) {
            $user->roles()->sync($this->getFullRolesFromRequest($request));

            Activity::log([
                'contentId' => $user->id,
                'contentType' => 'User',
                'action' => 'Update',
                'description' => 'Updated the user '.$user->name,
                'details' => $user->toJson(),
            ]);
            return $this->response->noContent();
        } else {
            return $this->response->error('could_not_update_user', 500);
        }
    }

    public function destroy($id) {
        if (Gate::denies('remove_users')) {
            $this->response->error('permission_denied', 401);
        }
        $user = User::findOrFail($id);

        if($user->delete()) {
            Activity::log([
                'contentId' => $user->id,
                'contentType' => 'User',
                'action' => 'Delete',
                'description' => 'Deleted the user '.$user->name,
                'details' => $user->toJson(),
            ]);
            return $this->response->noContent();
        } else {
            return $this->response->error('could_not_delete_user', 500);
        }
    }

    protected function getFullRolesFromRequest(Request $request) {
        return collect($request
            ->only('roles'))->collapse()
            ->flatMap(function($role) {
                return collect($role)->pluck('id');
            })->toArray();
    }

    protected function getSlimRolesFromRequest(Request $request) {

        // TODO: Clean this up
        $arr = [];
        foreach ($request->only('roles') as $t)
            $arr[] = $t['data'];

        return $arr;
    }
}
