<?php
namespace App\Api\V1\Transformers\ScreenGroup;
use App\Models\ScreenGroup;
use League\Fractal\TransformerAbstract;
class ScreenGroupTransformer extends TransformerAbstract
{
    public function transform(ScreenGroup $screengroup)
    {
        return [
            'id' 	=> (int) $screengroup->id,
            'name'  => $screengroup->name,
            'desc'	=> $screengroup->desc
        ];
    }
}