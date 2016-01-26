<?php namespace App;

/**
 * Forms, a simple WWW form handler as-a-service
 * @copyright (c) 2016 Clark Winkelmann
 * @license MIT
 */

use Illuminate\Database\Eloquent\Model;

/**
 * A submission to a form
 *
 * @property int    $id
 * @property int    $form_id
 * @property string $user_ip      IP used by the user
 * @property string $user_agent   User-Agent string used by the user
 * @property string $user_referer HTTP referer given by the agent or null if none
 * @property Carbon\Carbon $created_at
 * @property Carbon\Carbon $updated_at
 */
class Submission extends Model {

	/**
	 * @return Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function form()
	{
		return $this->belongsTo(Form::class);
	}

	/**
	 * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function fields()
	{
		return $this->belongsToMany(Field::class)
				->withPivot(['value'])
				->withTimestamps();
	}

	/**
	 * @param App\Field $field Field to retrieve
	 * @return App\Field Field with pivot data or null if not found
	 */
	public function field(Field $field)
	{
		return $this->fields()->where('field_id', $field->id)->first();
	}

}
