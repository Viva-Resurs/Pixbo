<?php
namespace App\Api\V1\Transformers\Client;
use App\Models\Client;
use League\Fractal\TransformerAbstract;
class ClientListTransformer extends TransformerAbstract
{
    public function transform(Client $client)
    {
        return [
            'value' 	=> (int) $client->id,
            'text'      => ucfirst($client->name),
        ];
    }
}