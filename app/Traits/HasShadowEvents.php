<?php
namespace App\Traits;

use App\Models\ShadowEvent;

trait HasShadowEvents
{
    public function shadow_events()
    {
        return $this->hasMany(ShadowEvent::class, 'event_id');
    }
}
