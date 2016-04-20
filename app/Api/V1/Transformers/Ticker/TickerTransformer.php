<?php

/**
 * Created by PhpStorm.
 * User: xergo
 * Date: 20-Apr-16
 * Time: 7:24 PM
 */

namespace App\Api\V1\Transformers\Ticker;

use App\Models\Ticker;
use League\Fractal\TransformerAbstract;

class TickerTransformer extends TransformerAbstract
{
    public function transform(Ticker $ticker)
    {
        return [
            'id' 	            => (int) $ticker->id,
            'text'              => $ticker->text,
            'event'	            => $ticker->event,
            'screengroups'      => $ticker->screengroups,
        ];
    }
}