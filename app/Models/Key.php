<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * Class Key
 *
 * @property int $id
 * @property string $name
 * @property string $input
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Key extends Model
{
    use HasFactory;
	protected $table = 'keys';

	protected $fillable = [
		'name',
		'input'
	];

    /**
     * Get the Translations linked to this key.
     *
     * @return HasManyThrough
     */
	public function translations(): HasManyThrough
    {
        return $this->hasManyThrough(
            Translation::class,
            KeysPivot::class,
            'key_id',
            'id',
        );
    }

    /**
     * Get the Translations linked to this key.
     *
     * @return HasMany
     */
    public function pivot(): HasMany
    {
        return $this->hasMany(
            KeysPivot::class,
            'key_id',
            'id',
        );
    }

}
