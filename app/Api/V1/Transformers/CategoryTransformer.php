<?php

/**
 * Created by PhpStorm.
 * User: xergo
 * Date: 20-Apr-16
 * Time: 7:24 PM
 */

namespace App\Api\V1\Transformers;

use App\Api\V1\Transformers\Screen\ScreenTransformer;
use App\Models\Category;
use League\Fractal\TransformerAbstract;

class CategoryTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];
    protected $defaultIncludes = ['screens'];

    public function transform(Category $category)
    {
        return [
            'id' 	            => (int) $category->id,
            'name'              => $category->name,
        ];
    }

    public function includeScreens(Category $category) {
        $screens = $category->screens;
        return $this->collection($screens, new ScreenTransformer());
    }
}