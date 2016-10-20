<?php

namespace App\Traits;

use App\Models\Event;
use DB;

trait HasEvents
{

    /**
     * Event association
     *
     * @return mixed
     */
    public function event()
    {
        return $this->morphMany(Event::class, 'eventable');
    }

    /**
     * Get event
     *
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event()->first();
    }

    public function getActiveEvents() {
        return $this->getEvent()->getActiveShadowEvents();
    }

    /**
     * Create and return the event.
     *
     * @return Event
     */
    public function createAndReturnEvent()
    {
        $event = new Event;

        DB::transaction(function () use ($event) {
            $event->fill([
                'eventable_id' => $this->getAttribute('id'),
                'eventable_type' => get_class($this),
                'date' => date('Y-m-d'),
                'start_time' => '00:00',
                'end_time' => '23:99',
                'recurring' => false,
            ]);
            $this->event()->save($event);
        });

        return $event;
    }
}
