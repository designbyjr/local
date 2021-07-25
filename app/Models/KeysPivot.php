<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class KeysPivot
 * 
 * @property int $id
 * @property int $key_id
 * @property int $translation_id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class KeysPivot extends Model
{
	protected $table = 'keys_pivot';

	protected $casts = [
		'key_id' => 'int',
		'translation_id' => 'int'
	];

	protected $fillable = [
		'key_id',
		'translation_id'
	];
}
