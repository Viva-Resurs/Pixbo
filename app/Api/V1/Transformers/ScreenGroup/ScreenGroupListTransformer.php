<?php
namespace App\Api\V1\Transformers\ScreenGroup;

use App\Models\ScreenGroup;
use League\Fractal\TransformerAbstract;

class ScreenGroupListTransformer extends TransformerAbstract
{
    public function transform(ScreenGroup $screengroup)
    {
        $client = $screengroup->clients->first();

        if (!is_null($client))
            $client = $client->address;

        else
            $client = '';

        return [
            'id'      => (int) $screengroup->id,
            'name'    => $screengroup->name,
            'desc'    => $screengroup->desc,
            'preview' => $client
        ];
    }
}
