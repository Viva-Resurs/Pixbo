<?php
namespace App\Api\V1\Transformers\Client;
use App\Models\Client;
use League\Fractal\TransformerAbstract;
class ClientTransformer extends TransformerAbstract
{
    public function transform(Client $client)
    {
        return [
            'id' 	            => (int) $client->id,
            'name'              => $client->name,
            'ip_address'	    => $client->ip_address,
            'screen_group_id'   => (int)$client->screen_group_id
        ];
    }
}