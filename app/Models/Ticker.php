<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Traits\HasEvents;


class Ticker extends Model
{

    use HasEvents;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ticker';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'text',
        'id',
    ];

    protected $touches = ['screengroup'];

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
