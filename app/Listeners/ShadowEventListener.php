<?php

namespace App\Listeners;

use App\Models\Event;
use App\Models\ShadowEvent;

class ShadowEventListener
{

    /**
 * Fires when Event has changed.
 * @param  Event  $event [description]
 * @return [type]        [description]
 */
    public function whenEventChanged(Event $event)
    {
        $event->generateShadowEvents();
    }

/**
 * Fires when an Event is removed.
 * @param  Event  $event
 * @return [type]        [description]
 */
    public function whenEventRemoved(Event $event)
    {
        ShadowEvent::clearEvent($event->id);
    }
}
