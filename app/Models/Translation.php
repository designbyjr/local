<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

/**
 * Class Translation
 *
 * @property int $id
 * @property int $language_id
 * @property string $input
 * @property string $output
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Translation extends Model
{
	protected $table = 'translation';

	protected $with = ['key'];

	protected $casts = [
		'language_id' => 'int'
	];

	protected $fillable = [
		'language_id',
		'input',
		'output'
	];

    /**
     * Get the Translations linked to this key.
     *
     * @return HasOneThrough
     */
	public function key()
    {
        return $this->hasOneThrough(
            Key::class,
            KeysPivot::class,
                'translation_id',
            'id',
            'id',
            'key_id'

        );
    }

    public function language()
    {
        return $this->hasOne(
            language::class,
            'id',
            'language_id'
        );
    }
}
