<?php

namespace App\Jobs;

use Illuminate\Contracts\Bus\SelfHandling;
use Carbon\Carbon;
use App\Models\ShadowEvent;

class AddShadowEvent extends Job implements SelfHandling
{

    protected $start;
    protected $event;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($start, $event)
    {
        $this->start = $start;
        $this->event = $event;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (is_null($this->event->eventable))
            return;

        $s = $this->event->eventable;
        $s = $s->with('screengroups')->first();
        $sg = $s->screengroups;

        $shadow = new ShadowEvent;

        $shadow->title = $this->event->eventable_id . ': ' . $this->event->eventable_type;
        $shadow->start = $this->start;

        $timeArray = !is_null($this->event['end_time']) ? extractTime($this->event['end_time']) : extractTime('17:30:00');
        $end = Carbon::parse($this->start);
        $end->hour = $timeArray[0];
        $end->minute = $timeArray[1];
        $shadow->end = $end;

        $this->event->shadow_events()->save($shadow);

    }
}
