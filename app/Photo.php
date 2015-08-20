<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model {
	/**
	 * Table name of model.
	 *
	 * @var string
	 */
	protected $table = 'photos';

	/**
	 * [$fillable variables allowed for massallocation]
	 *
	 * @var [String]
	 */
	protected $fillable = [
		'name',
		'path',
		'thumb_path',
		'archived',
		'sha1',
	];

/**
 * Get the screens associated with the given image.
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
 */
	public function screens() {
		$this->belongsToMany('App\Screen')->withTimestamps();
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
