<?php

namespace App;

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
        'mac_address',
        'rss_feed',
        'event_id',
        'created_by',
    ];

/**
 * Screen association
 * @return [type] [description]
 */
    public function screens()
    {
        //return $this->hasMany('App\Screen');
    }

/**
 * Client association
 * @return [type] [description]
 */
    public function client()
    {
        return $this->belongsTo('App\Client');
    }
}