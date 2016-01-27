<?php

namespace App\Traits;

use App\Models\Event;
use DB;

trait HasEvents
{
    /**
     * Event association
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function event()
    {
        return $this->morphMany('\App\Event', 'eventable');
    }

/**
 * [getEvent description]
 *
 * @return App\Event
 */
    public function getEvent()
    {
        return Event::where([
            'eventable_type' => get_class($this),
            'eventable_id' => $this->getAttribute('id'),
        ])->get()->first();
    }

/**
 * [createAndReturnEvent description]
 *
 * @return App\Event [description]
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
