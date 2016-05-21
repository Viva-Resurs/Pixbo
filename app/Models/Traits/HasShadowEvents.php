<?php
namespace App\Traits;

use App\Jobs\AddShadowEvent;
use App\Models\Event;
use App\Models\ShadowEvent;
use Carbon\Carbon;
use Illuminate\Foundation\Bus\DispatchesJobs;

trait HasShadowEvents
{
    use DispatchesJobs;
    public function shadow_events()
    {
        return $this->hasMany(ShadowEvent::class, 'event_id');
    }

    public function getActiveShadowEvents() {
        return $this->shadow_events()->now()->get();
    }

    /**
     * Config on how far into the future the reccuring events should be generated.
     * @var array
     */
    protected $duration = [
        'daily' => 14, // days
        'weekly' => 2, // weeks
        'monthly' => 2, // months
        'yearly' => 2, // years
    ];

    /**
     * Week days
     * @var array
     */
    protected $days = [
        0 => 'sunday',
        1 => 'monday',
        2 => 'tuesday',
        3 => 'wednesday',
        4 => 'thursday',
        5 => 'friday',
        6 => 'saturday',
    ];

    /**
     * Ordering
     * @var array
     */
    protected $order = [
        1 => 'first',
        2 => 'second',
        3 => 'third',
        4 => 'fourth',
        5 => 'last',
    ];

    /**
     * Months
     * @var array
     */
    protected $months = [
        1 => 'january',
        2 => 'february',
        3 => 'march',
        4 => 'april',
        5 => 'may',
        6 => 'june',
        7 => 'july',
        8 => 'august',
        9 => 'september',
        10 => 'october',
        11 => 'november',
        12 => 'december',
    ];

    /**
     * Generate shadow events for a given EventMeta.
     *
     * @param  Event $event
     * @return
     */
    public function generateShadowEvents(Event $event)
    {
        switch ($event->recur_type) {

            case 'daily':
                $this->generateDaily($event);
                break;
            case 'weekly':
                $this->generateWeekly($event);
                break;
            case 'monthly':
                $this->generateMonthly($event);
                break;
            case 'yearly':
                $this->generateYearly($event);
                break;
            case '':
                $this->generateOnce($event);
        }
    }

    private function generateOnce(Event $event)
    {
        $date = $this->getDate($event);

        ShadowEvent::clearEvent($event->id);

        $addShadowEvent = new AddShadowEvent($date, $event);
        $this->dispatch($addShadowEvent);
    }

    private function getDate(Event $event)
    {
        $timeArray = !is_null($event->start_time) ?
            extractTime($event->getAttribute('start_time')) :
            extractTime('00:00:00');

        $date = Carbon::parse($event->start_date);

        $date->hour = $timeArray[0];
        $date->minute = $timeArray[1];

        return $date;
    }

    /**
     * Generate daily shadow events.
     *
     * @param  Event $event
     * @return
     */
    private function generateDaily(Event $event)
    {
        $id = $event->id;
        $start_date = $this->getDate($event);

        $end = Carbon::parse($start_date)->addDays($this->duration['daily']);

        $frequency = $event->frequency;

        $start = ShadowEvent::where(function ($q) use ($id, $frequency, $start_date) {
            $q->where('event_id', $id);
            $q->where('start', '>=', $start_date);
            $q->where('start', '>=', Carbon::now()->subDays($frequency));
            $q->where('start', '<=', Carbon::now()->addDays($frequency));
        })->first();

        if (is_null($start)) {
            $start = Carbon::parse($start_date);
        } else {
            $start = Carbon::parse($start['start']);
        }

        ShadowEvent::clearEvent($id);

        $shadow_list = [];

        for ($initial = Carbon::parse($start);
             $initial->lte($end);
             $initial = $initial->addDays($frequency)) {

            $addShadowEvent = new AddShadowEvent(Carbon::parse($initial), $event);
            $this->dispatch($addShadowEvent);
        }
    }

    /**
     * Generate weekly shadow events.
     * @param  Event $event
     * @return
     */
    private function generateWeekly(Event $event)
    {
        $start_date = $event->getAttribute('start_date');
        $weekDays = json_decode(($event->recur_day_num));

        $id = $event->getAttribute('id');

        $frequency = !is_null($event->frequency) ? $event->frequency : 1;
        $timeArray = !is_null($event->getAttribute('start_time')) ? extractTime($event->getAttribute('start_time')) : extractTime('00:00');

        $started = Carbon::parse($start_date);

        $end = Carbon::parse($start_date)->addWeeks($this->duration['weekly']);

        $start = ShadowEvent::where(function ($q) use ($id, $frequency, $started) {
            $q->where('event_id', $id);
            $q->where('start', '>=', $started);
            $q->where('start', '>=', $started->subWeeks($frequency));
            $q->where('start', '<=', $started->addWeeks($frequency));
        })->first();

        if (is_null($start)) {
            $start = Carbon::parse($start_date);
        } else {
            $start = Carbon::parse($start['start']);
        }

        $start->hour = $timeArray[0];
        $start->minute = $timeArray[1];

        for ($initial = Carbon::parse($start);
             $initial->lte($end);
             $initial = $initial->addWeeks($frequency)) {
            for ($i = 1; $i < 8; $i++) {
                $day = Carbon::parse($initial)
                    ->subDays($initial->dayOfWeek)
                    ->addDays($i);

                if (in_array($day->dayOfWeek, $weekDays)
                    && $day->lte($end)
                    && $day->gte($start)) {
                    $day->hour = $timeArray[0];
                    $day->minute = $timeArray[1];
                    $addShadowEvent = new AddShadowEvent(Carbon::parse($day), $event);
                    $this->dispatch($addShadowEvent);
                }
            }
        }
    }

    /**
     * Generate monthly shadow events.
     *
     * @param  EventMeta $meta
     * @return
     */
    private function generateMonthly(Event $event)
    {
        $id = $event->getAttribute('id');
        $start_date = $event->getAttribute('start_date');
        $weekDay = $event->getAttribute('recur_day');
        $week_in_month = (int) json_decode($event->getAttribute('recur_day_num'));

        $days_ahead = $event->getAttribute('days_before_event');

        $frequency = !is_null($event->frequency) ? $event->frequency : 1;
        $timeArray = !is_null($event->getAttribute('start_time')) ? extractTime($event->getAttribute('start_time')) : extractTime('00:00');

        $started = Carbon::parse($start_date);

        $end = Carbon::parse($start_date)->addMonths($this->duration['monthly']);

        $start = ShadowEvent::where(function ($q) use ($id, $frequency, $started) {
            $q->where('event_id', $id);
            $q->where('start', '>=', $started);
            $q->where('start', '>=', $started->subMonths($frequency));
            $q->where('start', '<=', $started->addMonths($frequency));
        })->first();

        if (is_null($start)) {
            $start = Carbon::parse($start_date);
        } else {
            $start = Carbon::parse($start['start']);
        }

        $start->hour = $timeArray[0];
        $start->minute = $timeArray[1];

        ShadowEvent::clearEvent($id);

        for ($initial = Carbon::parse($start);
             $initial->lte($end);
             $initial = $initial->addMonths($frequency)) {
            $date_string = $this->order[$week_in_month] . ' ' .
                $this->days[$weekDay] . ' ' .
                $this->months[$initial->month] . ' ' .
                $initial->year;
            $date = Carbon::parse($date_string);
            if ($week_in_month == 1 && $date->day >= 7) {
                $date->subDays(7);
            }

            if ($date->gte($start) && $date->lte($end)) {
                if (!is_null($days_ahead) && $days_ahead > 0) {
                    for ($i = $days_ahead; $i >= 0; $i--) {
                        $ahead_date = Carbon::parse($date)->subDays($i);

                        $addShadowEvent = new AddShadowEvent($ahead_date, $event);
                        $this->dispatch($addShadowEvent);

                    }
                } else {
                    $addShadowEvent = new AddShadowEvent(Carbon::parse($date), $event);
                    $this->dispatch($addShadowEvent);
                }
            }
        }
    }

    /**
     * Generate yearly shadow events.
     *
     * @param  EventMeta $meta
     * @return
     */
    private function generateYearly(Event $event)
    {
        $id = $event->getAttribute('id');
        $start_date = $event->getAttribute('start_date');

        $frequency = !is_null($event->frequency) ? $event->frequency : 1;
        $timeArray = !is_null($event->getAttribute('start_time')) ? extractTime($event->getAttribute('start_time')) : extractTime('00:00');

        $started = Carbon::parse($start_date);

        $end = Carbon::parse($start_date)->addYears($this->duration['yearly']);
        if ($event->getAttribute('recurring') == 0) {
            $end = Carbon::parse($start_date);
        }

        $start = ShadowEvent::where(function ($q) use ($id, $frequency, $started) {
            $q->where('event_id', $id);
            $q->where('start', '>=', $started);
            $q->where('start', '>=', $started->subYears($frequency));
            $q->where('start', '<=', $started->addYears($frequency));
        })->first();

        if (is_null($start)) {
            $start = Carbon::parse($start_date);
        } else {
            $start = Carbon::parse($start['start']);
        }

        $start->hour = $timeArray[0];
        $start->minute = $timeArray[1];

        ShadowEvent::clearEvent($id);

        for ($initial = Carbon::parse($start);
             $initial->lte($end);
             $initial = $initial->addYears($frequency)) {
            if ($initial->gte($start) && $initial->lte($end)) {
                $addShadowEvent = new AddShadowEvent(Carbon::parse($initial), $event);
                $this->dispatch($addShadowEvent);
            }
        }
    }
}
