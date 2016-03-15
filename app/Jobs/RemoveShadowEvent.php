<?php

namespace App\Jobs;

use App\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;

class RemoveShadowEvent extends Job implements SelfHandling
{
    protected $shadow_event;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($shadow_event)
    {
        /*
        $this->shadow_event = $shadow_event;
        */
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        /*
        foreach($this->shadow_event->screengroups() as $sg) {
            $sg->shadow_events()->detach($this->shadow_event);
        }
        */
    }
}
