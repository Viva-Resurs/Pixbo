<?php
namespace App\Api\V1\Transformers\ScreenGroup;
use App\Models\ScreenGroup;
use League\Fractal\TransformerAbstract;
class ScreenGroupListTransformer extends TransformerAbstract
{
    public function transform(ScreenGroup $screengroup)
    {
        return [
            'value' 	=> (int) $screengroup->id,
            'text'      => $screengroup->name,
        ];
    }
}