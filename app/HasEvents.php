<?php

namespace App;

use App\Event;

trait HasEvents
{
    public function getEvent()
    {
        return Event::where([
            'eventable_type' => get_class($this),
            'eventable_id'   => $this->getAttribute('id'),
        ])->get()->first();
    }

    public function createAndReturnEvent()
    {
        $event = new Event;
        $event->fill([
            'eventable_id'   => $this->getAttribute('id'),
            'eventable_type' => get_class($this),
            'date'           => date('Y-m-d'),
            'start_time'     => '07:00',
            'end_time'       => '18:00',
            'recurring'      => false,
        ]);
        $this->event()->save($event);
        return $event;
    }
}
