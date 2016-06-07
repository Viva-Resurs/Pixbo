<?php
namespace App\Api\V1\Transformers\Client;
use App\Api\V1\Transformers\ScreenGroup\ScreenGroupListTransformer;
use App\Models\Client;
use League\Fractal\TransformerAbstract;
class ClientTransformer extends TransformerAbstract
{
    protected $availableIncludes = [];
    protected $defaultIncludes = ['screengroup'];

    public function transform(Client $client)
    {
        return [
            'id' 	            => (int) $client->id,
            'name'              => ucfirst($client->name),
            'address'	        => $client->address
        ];
    }

    public function includeScreengroup(Client $client) {
        $screengroup = $client->screengroup;
        return $this->item($screengroup, new ScreenGroupListTransformer());
    }
}