<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasEvents;


class Ticker extends Model
{

    use HasEvents;

    protected $table = 'tickers';
    
    protected $touches = ['screengroups'];

    protected $fillable = [
        'text',
        'id',
    ];

    /**
     * Boot method used to update associations depending on actions.
     *
     */
    public static function boot() {
        parent::boot();

        Ticker::deleting(function ($ticker) {
            $event = $ticker->event->first();
            if(!is_null($event))
                $event->delete();

            $ticker->screengroups()->detach();

            // TODO: Shadowevents Photos

        });

        Ticker::updating(function($ticker) {
            foreach($ticker->screengroups() as $sg) {
                $sg->touch();
            }
        });
    }

    /**
     * ScreenGroup association
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function screengroups()
    {
        return $this->belongsToMany(ScreenGroup::class, 'screengroup_ticker')->withTimestamps();
    }

}
