<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScreenGroup extends Model
{
    /**
     * Database table
     * @var string
     */
    protected $table = 'screengroups';
    /**
     * The attributes that are mass assignable.
     * @var [type]
     */
    protected $fillable = [
        'name',
        'desc',
    ];

    /**
     * Boot method used to update associations depending on actions.
     *
     */
    public static function boot() {
        parent::boot();

        ScreenGroup::deleting(function ($screengroup) {
            $clients = $screengroup->clients;
            
            foreach( $clients as $client) {
                $client->update(['screen_group_id' => 1]);
                $client->save();
            }
            //$screengroup->clients()->sync([]);
            //dd($screengroup);
            //$screengroup->clients()->detach();

        });
    }


    //protected $touches = ['screens'];
    /**
     * Screen association
     *
     * @return [type] [description]
     */

    public function screens() {
        return $this->belongsToMany(Screen::class, 'screen_screen_group')->withTimestamps();
    }


    public function tickers() {
        return $this->belongsToMany(Ticker::class, 'screen_group_ticker')->withTimestamps();
    }

    /**
     * Client association
     * @return [type] [description]
     */
    public function clients() {
        return $this->hasMany(Client::class);
    }

    /**
     * Returns an array of all active photos.
     *
     * @return array
     */
    public function getActivePhotos() {
        return $this->screens->load(['event', 'event.shadow_events'])
            ->flatMap(function ($screen) {
                $event = $screen->getActiveEvents();
                if(!$event->isEmpty()) {
                    return $screen->photo->pluck('path');
                }
            });
    }

    /**
     * Returns an array of all active tickers.
     *
     * @return array
     */
    public function getActiveTickers() {
        return $this->tickers->load(['event', 'event.shadow_events'])
            ->flatMap(function ($ticker) {
                $event = $ticker->getActiveEvents();
                if(!$event->isEmpty()) {
                    return $ticker->pluck('text');
                }
            });
    }
}
