<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * A submission to a form
 *
 * @property int $id
 * @property int $form_id
 * @property string $user_ip      IP used by the user
 * @property string $user_agent   User-Agent string used by the user
 * @property string $user_referer HTTP referer given by the agent or null if none
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property boolean $is_spam
 *
 * @property-read Form $form
 * @property-read Field[]|Collection $fields
 */
class Submission extends Model
{
    public function form(): BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function fields(): BelongsToMany
    {
        return $this->belongsToMany(Field::class)
            ->withPivot(['value'])
            ->withTimestamps();
    }

    /**
     * @param Field $field Field to retrieve
     * @return Field Field with pivot data or null if not found
     */
    public function field(Field $field): ?Field
    {
        return $this->fields()->where('field_id', $field->id)->first();
    }
}
