<?php

namespace App\Api\V1\Controllers;

use App\Api\V1\Requests\FileUploadForm;
use App\Api\V1\Transformers\Screen\ScreenTransformer;
use App\Http\Requests\ScreenUpdateForm;
use App\Models\Screen;
use Gate;
use App\Http\Requests;
use Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Activity;

class ScreenController extends BaseController
{
    /**
     * View all the Screens
     * @return mixed
     */
    public function index() {

        if (Gate::denies('view_screens')) {
            $this->response->error('permission_denied', 401);
        }

        return $this->collection(Screen::all(), new ScreenTransformer());
    }

    /**
     * Store the screen
     * 
     * @param FileUploadForm $form
     * @return \Dingo\Api\Http\Response|void
     */
    public function store(FileUploadForm $form) {
        /*
        if (Gate::denies('add_screens')) {
            $this->response->error('permission_denied', 401);
        }
        */

        $screen = $form->persist();


        if(!is_null($screen)) {
            Activity::log([
                'contentId' => $screen->id,
                'contentType' => 'Screen',
                'action' => 'Create',
                'description' => 'Created a Screen',
                'details' => $screen->toJson(),
            ]);
            return $this->response->created();
        } else {
            return $this->response->error('could_not_create_screen', 500);
        }
    }

    /**
     * Show the Screen
     *
     * @param $id
     * @return mixed
     */
    public function show($id) {
        if (Gate::denies('view_screens')) {
            $this->response->error('permission_denied', 401);
        }
        $screen = Screen::find($id);
        if(!$screen) {
            throw new NotFoundHttpException;
        }

        return $screen;
    }

    /**
     * Update the Screen
     *
     * @param ScreenUpdateForm $form
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     */
    public function update(ScreenUpdateForm $form, $id) {
        if (Gate::denies('edit_screens')) {
            $this->response->error('permission_denied', 401);
        }
        $screen = Screen::find($id);

        if(!$screen) {
            throw new NotFoundHttpException;
        }

        $result = $form->persist($screen);

        if(!is_null($result)) {
            Activity::log([
                'contentId' => $screen->id,
                'contentType' => 'Screen',
                'action' => 'Update',
                'description' => 'Updated a Screen',
                'details' => $screen->toJson(),
            ]);
            return $this->response->noContent();
        } else {
            return $this->response->error('could_not_update_screen', 500);
        }
    }

    /**
     * Delete the Screen
     *
     * @param $id
     * @return \Dingo\Api\Http\Response|void
     */
    public function destroy($id) {
        if (Gate::denies('remove_screens')) {
            $this->response->error('permission_denied', 401);
        }
        $screen = Screen::find($id);

        if(!$screen) {
            throw new NotFoundHttpException;
        }

        if($screen->delete()) {
            Activity::log([
                'contentId' => $screen->id,
                'contentType' => 'Screen',
                'action' => 'Delete',
                'description' => 'Deleted a Screen',
                'details' => $screen->toJson(),
            ]);
            return $this->response->noContent();
        } else {
            return $this->response->error('could_not_delete_screen', 500);
        }
    }
}
