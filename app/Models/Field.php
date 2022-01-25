<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * A form field
 *
 * @property int $id
 * @property int $form_id
 * @property string $slug  Unique string identifier for this field inside the form
 * @property string $title Internal field title
 * @property string $rules Validations rules for the field in Laravel Validator format
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Field extends Model
{
    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }
}
