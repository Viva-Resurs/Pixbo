<?php

namespace App\Api\V1\Transformers\Activity;

use App\Models\Activity;
use League\Fractal\TransformerAbstract;

use Carbon\Carbon;

class ActivityTransformer extends TransformerAbstract
{

    public function transform(Activity $activity)
    {
        return [
            'id'                => (int) $activity->id,
            'user'              =>
            [
                'id'   => $activity->user->id,
                'name' => $activity->user->name
            ],
            'model_id'          => $activity->content_id,
            'model'             => $activity->content_type,
            'action'            => $activity->action,
            'desc'              => $activity->description,
            'details'           => $activity->details,
            'ip_address'        => $activity->ip_address,
            'datetime'          => $activity->created_at->toDateTimeString()
        ];
    }

}
