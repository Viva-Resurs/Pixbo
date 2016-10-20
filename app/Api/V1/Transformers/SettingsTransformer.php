<?php

/**
 * Created by PhpStorm.
 * User: xergo
 * Date: 20-Apr-16
 * Time: 7:24 PM
 */

namespace App\Api\V1\Transformers;

use App\Models\Settings;
use League\Fractal\TransformerAbstract;

class SettingsTransformer extends TransformerAbstract
{

    public function transform(Settings $settings)
    {
        return [
            'vegas_delay'         => $settings->vegas_delay,
            'vegas_timer'         => (int) $settings->vegas_timer,
            'ticker_pauseOnItems' => $settings->ticker_pauseOnItems
        ];
    }
}