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

    protected function findShadowInRange($start, $begin, $end) {
        $first_match = $this->shadow_events()
            ->where('start', '>=',$start)
            ->where('start', '>=',$begin)
            ->where('start', '<=',$end)
            ->first();

        if (is_null($first_match)) {
            return $start;
        } else {
            return Carbon::parse($first_match);
        }
    }

    /**
     * Config on how far into the future the reccuring events should be generated.
     * @var array
     */
    protected $duration = [
        'daily' => 14, // days
        'weekly' => 2, // weeks
        'monthly' => 6, // months
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
        $type = 'generate'.ucfirst($event->recur_type);
        $this->$type($event);
    }

    private function generateNone(Event $event)
    {
        $date = $this->getDate($event);

        ShadowEvent::clearEvent($event->id);

        $addShadowEvent = new AddShadowEvent($date, $event);
        $this->dispatch($addShadowEvent);
    }

    private function getDate(Event $event)
    {
        $timeArray = extractTime($event->start_time);

        $date = Carbon::parse($event->start_date);

        $date->hour = $timeArray[0];
        $date->minute = $timeArray[1];
        $date->second = "00";

        return $date;
    }

    private function getEndDate(Event $event)
    {
        $timeArray = extractTime($event->end_time);

        $date = Carbon::parse($event->end_date);

        $date->hour = $timeArray[0];
        $date->minute = $timeArray[1];
        $date->second = "00";

        return $date;
    }

    /**
     * Generate daily shadow events.
     *
     * @param  Event $event
     */
    private function generateDaily(Event $event)
    {
        $start_date = $this->getDate($event);

        $end_date = $this->getEndDate($event);

        $today = Carbon::now();
        $today->hour = $start_date->hour;
        $today->minute = $start_date->minute;
        $today->second = $start_date->second;

        // TODO: have some loop to get a closer date to today if possible..
 
        $end = Carbon::parse($today)->addDays($this->duration['daily']);
        if ($end_date->lte($end))
            $end = $end_date;

        $frequency = $event->frequency;

        $start = $this->findShadowInRange(
            $start_date,
            $today->subDays($frequency),
            $today->addDays($frequency)
        );



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
        $start_date = $this->getDate($event);
        $weekDays = json_decode(($event->weekly_day_num));
        $frequency = $event->frequency;

        $end = Carbon::parse($start_date)->addWeeks($this->duration['weekly']);


        $start = $this->findShadowInRange(
            $start_date,
            $start_date->subWeeks($frequency),
            $start_date->addWeeks($frequency)
        );

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
                    $day->hour = $start_date->hour;
                    $day->minute = $start_date->minute;
                    $addShadowEvent = new AddShadowEvent(Carbon::parse($day), $event);
                    $this->dispatch($addShadowEvent);
                }
            }
        }
    }

    /**
     * Generate monthly shadow events.
     * TODO: Not working properly with the "last friday in the month"
     *
     * @param  Event $event
     */
    private function generateMonthly(Event $event)
    {
        $start_date = $this->getDate($event);
        $weekDay = $event->getAttribute('recur_day');
        $week_in_month = (int) $event->getAttribute('monthly_day_num');
        $days_ahead = $event->getAttribute('days_before_event');
        $frequency = $event->frequency;
        $end = Carbon::parse($start_date)->addMonths($this->duration['monthly']);


        $start = $this->findShadowInRange(
            $start_date,
            $start_date->subMonths($frequency),
            $start_date->addMonths($frequency)
        );

        for ($initial = Carbon::parse($start);
             $initial->lte($end);
             $initial = $initial->addMonths($frequency)) {
                $date_string = $this->order[$week_in_month] . ' ' .
                    $this->days[$weekDay] . ' ' .
                    $this->months[$initial->month] . ' ' .
                    $initial->year;
            $date = Carbon::parse($date_string);

            if ($date->gte($start) && $date->lte($end)) {
                $date->hour = $start_date->hour;
                $date->minute = $start_date->minute;

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
     * @param  Event $event
     */
    private function generateYearly(Event $event)
    {
        $start_date = $this->getDate($event);
        $frequency = $event->frequency;


        $end = Carbon::parse($start_date)->addYears($this->duration['yearly']);
        if ($event->getAttribute('recurring') == 0) {
            $end = Carbon::parse($start_date);
        }

        $start = $this->findShadowInRange(
            $start_date,
            $start_date->subYears($frequency),
            $start_date->addYears($frequency)
        );

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
