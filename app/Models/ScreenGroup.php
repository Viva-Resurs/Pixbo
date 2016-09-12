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
            foreach( $screengroup->clients as $client) {
                $client->update(['screen_group_id' => 1]);
                $client->save();
            }

            foreach ( $screengroup->screens as $screen ){
                $screengroup->screens()->detach($screen->id);
            }

            foreach ( $screengroup->tickers as $ticker ){
                $screengroup->tickers()->detach($ticker->id);
            }

        });
    }

    /**
     * Screen association
     *
     * @return [type] [description]
     */

    public function screens() {
        return $this->belongsToMany(Screen::class, 'screengroup_screen')->withTimestamps();
    }


    public function tickers() {
        return $this->belongsToMany(Ticker::class, 'screengroup_ticker')->withTimestamps();
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

        $array = [];

        foreach($this->screens as $screen) {

            if($screen->photo){

                $shadow_event = $screen->getActiveEvents();
                
                if(!$shadow_event->isEmpty())
                    $array[] = $screen->photo->path;
                
            }

        }

        return $array;
    }

    /**
     * Returns an array of all active tickers.
     *
     * @return array
     */
    public function getActiveTickers() {

        $array = [];

        foreach($this->tickers as $ticker) {
            
            $shadow_event = $ticker->getActiveEvents();
            
            if(!$shadow_event->isEmpty())
                $array[] = $ticker->text;

        }
        
        return $array;
    }
}
