<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;


class Client extends Model
{
    /**
     * Table name of model.
     * @var string
     */
    protected $table = 'clients';
    /**
     * [$fillable variables allowed for massallocation]
     * @var [String]
     */
    protected $fillable = [
        'name',
        'ip_address',
        'screen_group_id',
        'activity',
    ];
    protected $appends = ['group'];
    /**
     * ScreenGroup association
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function screengroup()
    {
        return $this->belongsTo(ScreenGroup::class, 'screen_group_id');
    }
    /**
     * User association
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getActivityAttribute($value)
    {
        if (!is_null($value)) {
            $time = Carbon::now()->timestamp($value);
            return $time->diffForHumans();
        } else {
            return trans('messages.unknown');
        }
    }

    public function getGroupAttribute()
    {
        return $this->screengroup->name;
    }

    public function updateActivity()
    {
        $this->activity = time();
    }

    public function getData() {
        // Get photos
        $photos = $this->screengroup->screens->load(['event', 'event.shadow_events'])
            ->flatMap(function ($screen) {
                $event = $screen->getActiveEvents();
                if(!$event->isEmpty()) {
                    return $screen->photo->pluck('path');
                }
            });

        // Get Tickers
        $tickers = $this->screengroup->tickers->load(['event', 'event.shadow_events'])
            ->flatMap(function ($ticker) {
                $event = $ticker->getActiveEvents();
                if(!$event->isEmpty()) {
                    return $ticker->pluck('text');
                }
            });

        return [
            'photo_list' => $photos,
            'tickers'    => $tickers,
            'updated_at' => $this->screengroup->updated_at->toDateTimeString(),
            'settings'   => Settings::getSettings(),
            'reboot'     => false
        ];
    }
}
