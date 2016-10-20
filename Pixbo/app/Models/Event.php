<?php

namespace App\Models;

use App\Traits\HasShadowEvents as HasShadowEvents;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasShadowEvents;
    /**
     * [$table description]
     * @var string
     */
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
        'recur_day_num',
        'recur_day',
        'days_before_event',
        'eventable_id',
        'eventable_type',
    ];

    protected $touches = ['eventable'];

    public static function boot() {
        parent::boot();

        Event::created(function($event) {
            $event->generateShadowEvents($event);
        });

        Event::deleting(function($event) {
            $event->shadow_events()->delete();
        });
        Event::updated(function ($event) {
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

    public function getFrequencyAttribute($value)
    {
        return !is_null($value) ? $value : '1';
    }

    public function getStartTimeAttribute($value)
    {
        return !is_null($value) ? $value : '00:00';
    }

    public function getEndTimeAttribute($value)
    {
        return !is_null($value) ? $value : '23:59';
    }

    public function getDaysBeforeEventAttribute($value)
    {
        return !is_null($value) ? $value : '0';
    }

    public function getRecurDayAttribute($value)
    {
        return !is_null($value) ? $value : '1';
    }

    public function getRecurDayNumAttribute($value)
    {
        return !is_null($value) ? $value : json_encode("1");
    }
}
