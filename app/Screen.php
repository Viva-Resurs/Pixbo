<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Screen extends Model {

/**
 * Database table
 * @var string
 */
	protected $table = 'screens';

/**
 * The attributes that are mass assignable.
 * @var [type]
 */
	protected $fillable = [
		'name',
		'event_id',
		'photo_id',
		'user_id',
		'created_at',
		'updated_at',
	];
	/**
	 * User association
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function user() {
		return $this->belongsTo('App\User');
	}

/**
 * [screengroups description]
 * @return [type] [description]
 */
	public function screengroups() {
		return $this->belongsToMany('App\ScreenGroup', 'screen_screen_group')->withTimestamps();
	}

/**
 * Event association
 *
 * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
 */
	public function event() {
		return $this->morphToMany('App\Event', 'eventable');
	}

	public function photo() {
		return $this->hasOne('App\Photo');
	}
}