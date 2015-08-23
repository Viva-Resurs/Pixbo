<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScreenGroup extends Model {
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
		'rss_feed',
		'event_id',
		'user_id',
		'created_at',
		'updated_at',
	];

/**
 * Screen association
 * @return [type] [description]
 */
	public function screens() {
		return $this->hasMany('App\Screen');
	}

/**
 * Client association
 * @return [type] [description]
 */
	public function client() {
		return $this->hasMany('\App\Client');
	}

/**
 * User association
 * @return [type] [description]
 */
	public function user() {
		return $this->belongsTo('\App\User');
	}

/**
 * Event association
 * @return [type] [description]
 */
	public function event() {
		return $this->morphMany('\App\Event', 'eventable');
	}
}

//$screengroup = App\ScreenGroup::create(['name' => 'SG1', 'desc' => 'test1', 'rss_feed' => 'bla', 'event_id' => 0, 'created_by' => 0]);