<?php

namespace App\Api\V1\Controllers;

use Activity;
use Gate;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Api\V1\Transformers\Tag\TagTransformer;
use Input;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TagController extends BaseController
{
    public function index() {

        if (Gate::denies('view_tags')) {
            $this->response->error('permission_denied', 401);
        }

        return $this->collection(Tag::all(), new TagTransformer());
    }

    public function store(Request $request) {
        if (Gate::denies('add_tags')) {
            $this->response->error('permission_denied', 401);
        }
        $tag = new Tag;
        $tag->fill($request->only(['name']));

        if($this->user->tags()->save($tag)) {
            Activity::log([
                'contentId' => $tag->id,
                'contentType' => 'Tag',
                'action' => 'Create',
                'description' => 'Created a Tag',
                'details' => $tag->toJson(),
            ]);
            return $this->response->created();
        }
        else {
            return $this->response->error('could_not_create_tag', 500);
        }
    }

    public function show($id) {
        if (Gate::denies('view_tags')) {
            $this->response->error('permission_denied', 401);
        }
        $tag = Tag::find($id);
        if(!$tag) {
            throw new NotFoundHttpException;
        }

        return $tag;
    }

    public function update(Request $request, $id) {
        if (Gate::denies('edit_tags')) {
            $this->response->error('permission_denied', 401);
        }
        $tag = Tag::find($id);

        if(!$tag) {
            throw new NotFoundHttpException;
        }

        if($tag->update($request->only(['name']))) {
            Activity::log([
                'contentId' => $tag->id,
                'contentType' => 'Tag',
                'action' => 'Update',
                'description' => 'Updated a Tag',
                'details' => $tag->toJson(),
            ]);
            return $this->response->noContent();
        } else {
            return $this->response->error('could_not_update_tag', 500);
        }
    }

    public function destroy($id) {
        if (Gate::denies('remove_tags')) {
            $this->response->error('permission_denied', 401);
        }
        $tag = Tag::find($id);

        if(!$tag) {
            throw new NotFoundHttpException;
        }

        if($tag->delete()) {
            Activity::log([
                'contentId' => $tag->id,
                'contentType' => 'Tag',
                'action' => 'Delete',
                'description' => 'Deleted a Tag',
                'details' => $tag->toJson(),
            ]);
            return $this->response->noContent();
        } else {
            return $this->response->error('could_not_delete_tag', 500);
        }
    }
}
