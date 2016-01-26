<?php namespace App;

/**
 * Forms, a simple WWW form handler as-a-service
 * @copyright (c) 2016 Clark Winkelmann
 * @license MIT
 */

use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * A user
 *
 * @property int    $id
 * @property string $email    User email address
 * @property string $password User password
 * @property Carbon\Carbon $created_at
 * @property Carbon\Carbon $updated_at
 */
class User extends Authenticatable {

	protected $hidden = [
		'password',
	];

}
