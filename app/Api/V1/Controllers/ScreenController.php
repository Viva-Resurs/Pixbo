<?php

namespace App\Api\V1\Controllers;

use Gate;
use Activity;

use App\Models\Screen;

use App\Api\V1\Requests\FileUploadForm;
use App\Api\V1\Requests\ScreenUpdateForm;

use App\Api\V1\Transformers\Screen\ScreenTransformer;


class ScreenController extends BaseController
{

    public function index() {

        if (Gate::denies('view_screen'))
            $this->response->error('permission_denied', 401);

        return $this->collection(Screen::all(), new ScreenTransformer());
    }

    public function store(FileUploadForm $form) {

        if (Gate::denies('add_screen'))
            $this->response->error('permission_denied', 401);

        $screen = $form->persist();

        if(!is_null($screen)) {

            Activity::log([
                'contentId' => $screen->id,
                'contentType' => 'Screen',
                'action' => 'Create',
                'description' => 'Created a Screen',
                'details' => $screen->toJson(),
            ]);

            return $screen->id;
        }
        else
            return $this->response->error('could_not_create_screen', 500);
    }

    public function replacePhoto(FileUploadForm $form, $id) {

        if (Gate::denies('edit_screen'))
            $this->response->error('permission_denied', 401);

        $screen = Screen::find($id);

        if (!$screen)
            $this->response->error('not_found', 404);

        $result = $form->replacePhoto($screen);

        if ($result){

            Activity::log([
                'contentId' => $screen->id,
                'contentType' => 'Screen',
                'action' => 'Update',
                'description' => 'Replaced a Screen',
                'details' => $screen->toJson(),
            ]);

            return $screen->id;
        }
        else
            return $this->response->error('could_not_replace_screen', 500);
    }

    public function show($id) {

        if (Gate::denies('view_screen'))
            $this->response->error('permission_denied', 401);

        $screen = Screen::with('screengroups','categories')->find($id);

        if (!$screen)
            $this->response->error('not_found', 404);

        return $this->item($screen, new ScreenTransformer(), ['key' => 'screen']);
    }

    public function update(ScreenUpdateForm $form, $id) {

        if (Gate::denies('view_screen'))
            $this->response->error('permission_denied', 401);

        $screen = Screen::find($id);

        if (!$screen)
            $this->response->error('not_found', 404);

        if (Gate::denies('edit_screen'))
            $this->response->error('permission_denied', 401);

        $result = $form->persist($screen);

        if($result) {

            Activity::log([
                'contentId' => $screen->id,
                'contentType' => 'Screen',
                'action' => 'Update',
                'description' => 'Updated a Screen',
                'details' => $screen->toJson(),
            ]);

            return $this->response->noContent();
        }
        else
            return $this->response->error('could_not_update_screen', 500);
    }

    public function destroy($id) {

        if (Gate::denies('view_screen'))
            $this->response->error('permission_denied', 401);

        $screen = Screen::find($id);

        if (!$screen)
            $this->response->error('not_found', 404);

        if (Gate::denies('remove_screen'))
            $this->response->error('permission_denied', 401);

        if($screen->delete()) {

            Activity::log([
                'contentId' => $screen->id,
                'contentType' => 'Screen',
                'action' => 'Delete',
                'description' => 'Deleted a Screen',
                'details' => $screen->toJson(),
            ]);

            return $this->response->noContent();
        }
        else
            return $this->response->error('could_not_delete_screen', 500);
    }

}
