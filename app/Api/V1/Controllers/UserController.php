<?php

namespace App\Api\V1\Controllers;

use Gate;
use Activity;

use Illuminate\Http\Request;

use App\Models\User;

use App\Api\V1\Transformers\User\UserTransformer;


class UserController extends BaseController
{

    public function index() {

        if (Gate::denies('view_user'))
            $this->response->error('permission_denied: view_user', 401);

        $users = User::with('roles')->where('id', '<>', $this->user->id)->get();

        return $this->collection($users, new UserTransformer());
    }

    public function show($id) {

        if (Gate::denies('view_user'))
            $this->response->error('permission_denied: view_user', 401);

        $user = User::find($id);

        if (!$user)
            $this->response->error('not_found', 404);

        return $this->item($user, new UserTransformer());
    }

    public function store(Request $request) {

        if (Gate::denies('add_user'))
            $this->response->error('permission_denied: add_user', 401);

        $user = new User;
        $user->fill($request->only(['name', 'email', 'password']));

        if($user->save()) {
            $user->roles()->sync($this->getRolesFromRequest($request));

            Activity::log([
                'contentId' => $user->id,
                'contentType' => 'User',
                'action' => 'Create',
                'description' => 'Created the user '.$user->name,
                'details' => $user->toJson(),
            ]);

            return $this->response->created();
        }
        else
            return $this->response->error('could_not_create_user', 500);
    }

    public function me() {

        if ($this->user)
            return $this->item($this->user, new UserTransformer() );

        return '';
    }

    public function update(Request $request, $id) {

        if (Gate::denies('edit_user'))
            $this->response->error('permission_denied', 401);

        $user = User::find($id);

        if (!$user)
            $this->response->error('not_found', 404);

        if($user->update($request->only(['name', 'email', 'password']))) {
            $user->roles()->sync($this->getRolesFromRequest($request));

            Activity::log([
                'contentId' => $user->id,
                'contentType' => 'User',
                'action' => 'Update',
                'description' => 'Updated the user '.$user->name,
                'details' => $user->toJson(),
            ]);

            return $this->response->noContent();
        }
        else
            return $this->response->error('could_not_update_user', 500);
    }

    public function updateMe(Request $request) {

        $user = $this->user;

        if (!$user)
            $this->response->error('not_found', 404);

        $newData = [];

        if ($request->password!='')
            $newData['password'] = $request->password;

        if ($request->email!='')
            $newData['email'] = $request->email;

        if ($user->update($newData)){

            Activity::log([
                'contentId' => $user->id,
                'contentType' => 'User',
                'action' => 'Update',
                'description' => 'Updated profile '.$user->name,
                'details' => $user->toJson(),
            ]);

            return $this->response->noContent();
        }
        else
            return $this->response->error('could_not_update_profile', 500);
    }

    public function destroy($id) {

        if (Gate::denies('remove_user'))
            $this->response->error('permission_denied', 401);

        $user = User::find($id);

        if (!$user)
            $this->response->error('not_found', 404);

        if($user->delete()) {
            Activity::log([
                'contentId' => $user->id,
                'contentType' => 'User',
                'action' => 'Delete',
                'description' => 'Deleted the user '.$user->name,
                'details' => $user->toJson(),
            ]);
            return $this->response->noContent();
        }
        else
            return $this->response->error('could_not_delete_user', 500);
    }

    protected function getRolesFromRequest(Request $request) {
        return collect($request
            ->only('roles'))->collapse()
            ->flatMap(function($role) {
                return collect($role)->pluck('id');
            })->toArray();
    }

}
