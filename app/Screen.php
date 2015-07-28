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
		'image_id',
		'event_id',
		'user_id',
		'created_at',
		'updated_at',
	];
	/**
	 * User association
	 * @return Illuminate\Database\Eloquent\Model
	 */
	public function user() {
		return $this->belongsTo('App\User');
	}
}