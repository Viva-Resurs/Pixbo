<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model {

	/**
	 * Table name of model.
	 * @var string
	 */
	protected $table = 'clients';

	/**
	 * [$fillable variables allowed for massallocation]
	 * @var [String]
	 */
	protected $fillable = [
		'name',
		'ip_address',
		'mac_address',
		'is_active',
		'user_id',
		'screengroup_id',
	];

}