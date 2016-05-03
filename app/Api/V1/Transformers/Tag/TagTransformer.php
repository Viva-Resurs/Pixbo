<?php
namespace App\Api\V1\Transformers\Tag;
use App\Models\Tag;
use League\Fractal\TransformerAbstract;
class TagTransformer extends TransformerAbstract
{
    public function transform(Tag $tag)
    {
        return [
            'id' 	=> (int) $tag->id,
            'name'  => $tag->name
        ];
    }
}