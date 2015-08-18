<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {
	/**
	 * Table name of model.
	 *
	 * @var string
	 */
	protected $table = 'images';

	/**
	 * [$fillable variables allowed for massallocation]
	 *
	 * @var [String]
	 */
	protected $fillable = [
		'path',
		'archived',
	];
	protected $appends = array('name');

/**
 * Get the screens associated with the given image.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
 */
	public function screens() {
		$this->belongsToMany('App\Screen')->withTimestamps();
	}

/**
 * Return the attribute accessor name.
 *
 * @return String
 */
	public function getNameAttribute() {
		return basename($this->attributes['path']);
	}

/**
 * Remove the image and it's associated file.
 *
 * @return bool|null
 * @throws \Exception
 */
	public function delete() {
		$path = 'public' . $this->attributes['path'];

		if (\File::exists($path)) {
			\File::delete($path);
		}

		parent::delete();
	}
}
