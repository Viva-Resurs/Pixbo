<?php

/**
 * Created by PhpStorm.
 * User: xergo
 * Date: 20-Apr-16
 * Time: 7:24 PM
 */

namespace App\Api\V1\Transformers\Category;

use App\Api\V1\Transformers\Screen\ScreenTransformer;
use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryListTransformer extends TransformerAbstract
{

    public function transform(Category $category)
    {
        return [
            'id' 	            => (int) $category->id,
            'name'              => $category->name,
            'numberOfScreens'   => $category->screens()->count(),
            'user_id'           => (int) $category->user_id,
        ];
    }
}