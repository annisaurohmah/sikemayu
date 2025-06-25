<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rw
 * 
 * @property int $rw_id
 * @property string|null $no_rw
 * 
 * @property Collection|Sip1[] $sip1s
 *
 * @package App\Models
 */
class Rw extends Model
{
	protected $table = 'rw';
	protected $primaryKey = 'rw_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'rw_id' => 'int'
	];

	protected $fillable = [
		'no_rw'
	];

	public function sip1s()
	{
		return $this->hasMany(Sip1::class);
	}
}
