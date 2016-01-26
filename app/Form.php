<?php namespace App;

/**
 * Forms, a simple WWW form handler as-a-service
 * @copyright (c) 2016 Clark Winkelmann
 * @license MIT
 */

use Illuminate\Database\Eloquent\Model;

/**
 * A form, just like a <form/> in HTML
 *
 * @property int     $id
 * @property string  $slug                     Unique string identifier for this form
 * @property string  $title                    Internal form title
 * @property boolean $accept_submissions       If the form should accept new submissions
 * @property string  $send_email_to            A coma-separated list of emails that should get a notification or null if none
 * @property string  $confirmation_message     The confirmation message to send to the user or null to disable confirmations
 * @property string  $confirmation_email_field The slug of the field to use as the user email address or null for defaults
 * @property string  $redirect_to_url          An url where to redirect the user after a successful submission
 * @property string  $owner_email              Email address to use in the "from" field of the emails. Nullable
 * @property string  $owner_name               Name to use in the "from" field of the emails. If null, the email will be used
 * @property Carbon\Carbon $created_at
 * @property Carbon\Carbon $updated_at
 */
class Form extends Model {

	/**
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function fields()
	{
		return $this->hasMany(Field::class);
	}

	/**
	 * @return Illuminate\Database\Eloquent\Relations\HasMany
	 */
	public function submissions()
	{
		return $this->hasMany(Submission::class);
	}

}
