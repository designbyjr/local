<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Language
 * 
 * @property int $id
 * @property string $name
 * @property string $iso_code
 * @property bool $rtl
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class Language extends Model
{
	protected $table = 'language';

	protected $casts = [
		'rtl' => 'bool'
	];

	protected $fillable = [
		'name',
		'iso_code',
		'rtl'
	];
}
