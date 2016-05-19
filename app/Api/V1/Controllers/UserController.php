<?php

namespace App\Api\V1\Controllers;

use Activity;
use Gate;
use Illuminate\Http\Request;
use App\Models\User;
use App\Api\V1\Transformers\User\UserTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class UserController extends BaseController
{
    public function index() {

        if (Gate::denies('view_clients')) {
            return new UnauthorizedHttpException('permission_denied');
            //$this->response->error('permission_denied', 401);
        }
        return $this->collection(User::with('roles')->get(), new UserTransformer());
        
    }

    public function show($id) {
        if (Gate::denies('view_users')) {
            $this->response->error('permission_denied', 401);
        }
        $user = User::find($id);
        if(!$user) {
            throw new NotFoundHttpException;
        }

        return $this->item($user, new UserTransformer());
    }

    // TODO: Need to fix the storing of roles
    public function store(Request $request) {
        if (Gate::denies('add_users')) {
            return new UnauthorizedHttpException('permission_denied');
        }

        $user = new User;
        $user->fill($request->only(['name', 'email', 'password']));

        // So ugly, TODO make pretty
        $roles = $request->only('roles');
        $role_id = [];
        foreach( $roles as $role)
            $role_id[] = $role["data"];


        if($user->save()) {
            $user->roles()->sync($role_id);
            
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

    // TODO: Need to fix the update of roles
    public function update(Request $request, $id) {
        if (Gate::denies('edit_users')) {
            $this->response->error('permission_denied', 401);
        }
        $user = User::find($id);

        if(!$user) {
            throw new NotFoundHttpException;
        }

        if($user->update($request->only(['name', 'email', 'password', 'roles']))) {
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
        $user = User::find($id);

        if(!$user) {
            throw new NotFoundHttpException;
        }

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
}
