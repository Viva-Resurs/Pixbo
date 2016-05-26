<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ShadowEvent extends Model
{

    protected $fillable = [
        'title',
        'start',
        'end',
    ];

    public static function boot() {
        parent::boot();
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function screengroups()
    {
        return $this->belongsToMany(ScreenGroup::class, 'screen_group_shadow_event', 'shadow_event_id', 'screen_group_id');
    }

    public function scopeNow($query)
    {
        return $query
            ->where('start', '<', Carbon::now())
            ->where('end', '>', Carbon::now());
    }

    /**
     * Generates a shadow event from the given date with the info from given Event.
     *
     * @param  Carbon $start
     * @param  Event  $event
     */
    public static function generateFromEvent($start, Event $event)
    {

    }

    /**
     * Removes all shadow events from a given Event id.
     *
     * @param  integer $id event_id
     */
    public static function clearEvent($id)
    {
        $delete_rows = ShadowEvent::where('event_id', $id)->delete();

        return $delete_rows;
    }

    /**
     * Removes all old shadow event with a given event id.
     *
     * @param  integer $id
     * @return bool|null
     */
    public static function clearOldEvents($id)
    {
        $now = Carbon::now();
        $delete_rows = ShadowEvent::where(function ($q) use ($now, $id) {
            $q->where('event_id', $id);
            $q->where('end', '<', $now);
        })->delete();
        return $delete_rows;
    }

    public static function clearAllOldEvents()
    {
        $now = Carbon::now();
        $delete_rows = ShadowEvent::where(function ($q) use ($now) {
            $q->where('end', '<', $now);
        })->delete();
        return $delete_rows;
    }

    public static function generateAllEvents()
    {
        $events = Event::all();
        foreach ($events as $event) {
            $event->generateShadowEvents($event);
        }
    }

    public static function clearAllShadowEvents()
    {
        ShadowEvent::whereNotNull('id')->delete();
    }

    public function getTitle()
    {
        return $this->getAttribute('title');
    }

    public function isAllDay()
    {
        return ($this->getAttribute('isAllDay') ? true : false);
    }

    public function getStart()
    {
        return Carbon::parse($this->getAttribute('start'));
    }

    public function getEnd()
    {
        return Carbon::parse($this->getAttribute('end'));
    }
}
