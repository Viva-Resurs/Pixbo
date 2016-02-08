<?php

namespace App\Models;

use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class ShadowEvent extends Model implements \MaddHatter\LaravelFullcalendar\Event
{

    protected $fillable = [
        'title',
        'isAllDay',
        'start',
        'end',
    ];

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
        $shadow = new static;
        //$base_model = get_class($event->eventable()->getRelated());
        //$model      = $base_model::find(['id' => $event->eventable_id])->first();

        $shadow->title = $event->id; //$model['name'];
        $shadow->start = $start;

        $timeArray = !is_null($event['end_time']) ? extractTime($event['end_time']) : extractTime('23:59:59');
        $end = Carbon::parse($start);
        $end->hour = $timeArray[0];
        $end->minute = $timeArray[1];
        $shadow->end = $end;
        $shadow->isAllDay = 1;

        $s = $event->eventable->load('screengroups');
        $sg = $s->screengroups;
        //dd($sg);

        $event->shadow_events()->save($shadow);
        $shadow->screengroups()->sync($sg);
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
        $delete_rows = ShadowEvent::where(function ($q) use ($id, $now) {
            $q->where('event_id', $id);
            $q->where('end', '<', $now);
        })->delete();
        return $delete_rows;
    }

    public function getTitle()
    {
        return $this->getAttribute('title');
    }

    public function isAllDay()
    {
        return ($this->getAttributes('isAllDay') ? true : false);
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
