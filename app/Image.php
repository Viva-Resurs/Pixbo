<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {
	/**
	 * Table name of model.
	 * @var string
	 */
	protected $table = 'images';

	/**
	 * [$fillable variables allowed for massallocation]
	 * @var [String]
	 */
	protected $fillable = [
		'path',
		'archived',
	];
}
