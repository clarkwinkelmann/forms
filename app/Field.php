<?php namespace App;

/**
 * Forms, a simple WWW form handler as-a-service
 * @copyright (c) 2016 Clark Winkelmann
 * @license MIT
 */

use Illuminate\Database\Eloquent\Model;

/**
 * A form field
 *
 * @property int    $id
 * @property int    $form_id
 * @property string $slug  Unique string identifier for this field inside the form
 * @property string $title Internal field title
 * @property string $rules Validations rules for the field in Laravel Validator format
 * @property Carbon\Carbon $created_at
 * @property Carbon\Carbon $updated_at
 */
class Field extends Model {

	/**
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function form()
	{
		return $this->belongsTo(Form::class);
	}

}
