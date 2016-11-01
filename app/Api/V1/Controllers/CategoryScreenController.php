<?php

namespace App\Api\V1\Controllers;

use Gate;
use Activity;

use App\Models\Category;
use App\Models\Screen;


class CategoryScreenController extends BaseController
{

    public function destroy(Category $category, Screen $screen) {

        if (Gate::denies('edit_screen'))
            $this->response->error('permission_denied', 401);

        $defaultCategory = Category::findOrFail(1)->first();

        $category->screens()->detach($screen->id);
        $defaultCategory->screens()->attach($screen->id);

        Activity::log([
            'contentId' => $category->id,
            'contentType' => 'CategoryScreen',
            'action' => 'Detach',
            'description' => 'Detached Screen from Category',
            'details' => $category->screens->toJson(),
        ]);

        return $this->response->noContent();
    }
}
