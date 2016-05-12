<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
//use App\Models\Screen;
//use DB;
//use Event as E;

/**
 * App\Models\ScreenGroup
 *
 * @property integer $id
 * @property string $name
 * @property string $desc
 * @property integer $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Client[] $clients
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ScreenGroup whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ScreenGroup whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ScreenGroup whereDesc($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ScreenGroup whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ScreenGroup whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\ScreenGroup whereUpdatedAt($value)
 * @mixin \Eloquent
 */
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
     * Remove a screen from the screengroup
     * @param  Screen $screen [description]
     * @return [type]         [description]
     */
    /*
    public function remove_screen(Screen $screen) {
        // Detach the screen from the screen group
        $this->screens()->detach($screen);
        // clear and generate new shadow events for the screen.
        E::fire('GenerateFromEvent', $screen->event->first());
    }
    public function remove_ticker(Ticker $ticker) {
        // Detach the screen from the screen group
        $this->tickers()->detach($ticker);
        // clear and generate new shadow events for the screen.
        E::fire('GenerateFromEvent', $ticker->event->first());
    }
    */
    /**
     * Client association
     * @return [type] [description]
     */
    public function clients() {
        return $this->hasMany(Client::class);
    }
    /*
    public function assignOrCreateAndAssign($photo) {
        $screen = $photo->screen;
        if (!is_null($screen)) {
            if (!$screen->screengroups->contains($this->getAttribute('id'))) {
                $this->screens()->save($screen);
                return true;
            }
        } else {
            $result = DB::transaction(function () use ($photo) {
                $screen = new Screen;
                $screen->fill([
                    'name' => $photo->name,
                ]);
                $screen->save();
                $screen->photo()->save($photo);
                $this->screens()->attach($screen);
            });
            return $result;
        }
    }
    */
}
