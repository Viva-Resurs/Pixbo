<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasShadowEvents;

use Carbon\Carbon;


class Event extends Model
{

    use HasShadowEvents;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = "event";

    /**
     * The attributes that are mass assignable.
     *
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

    /**
     * Boot method used to update associations depending on actions.
     *
     */
    public static function boot() {
        parent::boot();

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
