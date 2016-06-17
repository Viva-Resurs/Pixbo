<?php

namespace App\Models;

use App\Traits\HasShadowEvents;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Event extends Model
{
    use HasShadowEvents;
    protected $table = "events";

    /**
     * [$fillable description]
     * @var array
     */
    protected $fillable = [
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'frequency',
        'recur_type',
        'weekly_day_num',
        'monthly_day_num',
        'recur_day',
        'days_before_event'
    ];

    protected $touches = ['eventable'];

    public static function boot() {
        parent::boot();

        /*
        Event::created(function($event) {
            $event->generateShadowEvents($event);
        });
*/
        Event::deleting(function($event) {
            $event->shadow_events()->delete();
        });
        Event::updating(function ($event) {
            $event->shadow_events()->delete();
            $event->generateShadowEvents($event);
        });
    }

    /**
     * Morph relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function eventable()
    {
        return $this->morphTo();
    }


}
