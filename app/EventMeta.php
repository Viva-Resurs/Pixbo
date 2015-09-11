<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Validator;

class EventMeta extends Model
{
    /**
     * Variables allowed to be mass assigned.
     * @var [array]
     */
    protected $fillable = [
        'frequency',
        'recur_type',
        'recur_day_num',
        'recur_day',
        'recur_end',
    ];

/**
 * Event Association.
 *
 * @return \Illuminate\Database\Eloquent\Relations\HasMany
 */
    public function events()
    {
        return $this->belongsTo('App\Event')->withTimestamps();
    }

    public function decodeAndUpdate($request)
    {
        //dd($request);

        $validator = null;

        switch ($request['recurrence']) {
        case 'daily':
            $validator = $this->updateDaily($request);
            break;
        case 'weekly':
            $validator = $this->updateWeekly($request);
            break;
        case 'monthly':
            $validator = Validator::make($request, [
                'recur_monthly_week'     => 'required|string',
                'recur_monthly_week_day' => 'required|integer',
            ]);
            break;
        case 'yearly':
            $validator = Validator::make([
                'recur_date' => 'required|date',
            ]);
            break;
        default:
            break;
        }
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors());
        }
    }

/**
 * Update daily updates the meta event for daily recurrence.
 *
 * @param  Request
 * @return Validator
 */
    private function updateDaily($request)
    {
        $validator = Validator::make($request, [
            'daily_end_type'  => 'required',
            'daily_frequency' => 'required|integer',
            'meta_recur_end'  => 'required_if:daily_end_type,at',
        ]);
        $recur_end = null;
        if ($request['daily_end_type'] == 'at') {
            $recur_end = $request['daily_meta_recur_end'];
        }

        $this->update([
            'frequency' => $request['daily_frequency'],
            'recur_end' => $recur_end,
        ]);

        return $validator;
    }

    private function updateWeekly($request)
    {
        //dd($request);
        $validator = Validator::make($request, [
            'weekly_end_type'  => 'required',
            'recur_day'        => 'required|array',
            'weekly_frequency' => 'required|integer',

        ]);

        $recur_end = null;
        if ($request['weekly_end_type'] == 'at') {
            $recur_end = $request['weekly_meta_recur_end'];
        }

        $this->update([
            'frequency' => $request['weekly_frequency'],
            'recur_day' => serialize($request['recur_day']),
            'recur_end' => $recur_end,
        ]);

        return $validator;
    }
}
