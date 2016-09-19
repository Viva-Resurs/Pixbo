<?php

namespace App\Api\V1\Controllers;

use Gate;
use Activity;

use App\Http\Request;

use App\Models\Category;

use App\Api\V1\Transformers\Category\CategoryTransformer;
use App\Api\V1\Transformers\Category\CategoryListTransformer;


class CategoryController extends BaseController
{

    public function index() {

        if (Gate::denies('view_category'))
            $this->response->error('permission_denied', 401);

        return $this->collection(Category::all(), new CategoryListTransformer());
    }

    public function store(Request $request) {

        if (Gate::denies('add_category'))
            $this->response->error('permission_denied', 401);
        
        $category = new Category;
        $category->fill($request->only(['name']));

        if($this->user->categories()->save($category)) {

            Activity::log([
                'contentId' => $category->id,
                'contentType' => 'Category',
                'action' => 'Create',
                'description' => 'Created a Category',
                'details' => $category->toJson(),
            ]);

            return $this->response->created();
        }
        else
            return $this->response->error('could_not_create_category', 500);
    }

    public function show($id) {
        
        if (Gate::denies('view_category'))
            $this->response->error('permission_denied', 401);
        
        $category = Category::find($id);

        if (!$category)
            $this->response->error('not_found', 404);

        return $this->item($category, new CategoryTransformer());
    }

    public function update(Request $request, $id) {
        
        if (Gate::denies('view_category'))
            $this->response->error('permission_denied', 401);

        $category = Category::find($id);

        if (!$category)
            $this->response->error('not_found', 404);

        if (Gate::denies('edit_category') && !$category->isOwner($this->user) )
            $this->response->error('permission_denied', 401);

        if($category->update($request->only(['name']))) {
            
            Activity::log([
                'contentId' => $category->id,
                'contentType' => 'Category',
                'action' => 'Update',
                'description' => 'Updated a Category',
                'details' => $category->toJson(),
            ]);

            return $this->response->noContent();
        }
        else
            return $this->response->error('could_not_update_category', 500);
    }

    public function destroy($id) {

        if (Gate::denies('view_category'))
            $this->response->error('permission_denied', 401);

        $category = Category::find($id);

        if (!$category)
            $this->response->error('not_found', 404);

        if (Gate::denies('remove_category') && !$category->isOwner($this->user) )
            $this->response->error('permission_denied', 401);

        if($category->delete()) {
            
            Activity::log([
                'contentId' => $category->id,
                'contentType' => 'Category',
                'action' => 'Delete',
                'description' => 'Deleted a Category',
                'details' => $category->toJson(),
            ]);

            return $this->response->noContent();
        }
        else
            return $this->response->error('could_not_delete_category', 500);
    }
}
