<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DwMp
 * 
 * @property int $mp_id
 * @property int|null $dw_id
 * @property int|null $beras
 * @property int|null $non_beras
 * 
 * @property Dw|null $dw
 *
 * @package App\Models
 */
class DwMp extends Model
{
	protected $table = 'dw_mp';
	protected $primaryKey = 'mp_id';
	public $timestamps = false;

	protected $casts = [
		'dw_id' => 'int',
		'beras' => 'int',
		'non_beras' => 'int'
	];

	protected $fillable = [
		'dw_id',
		'beras',
		'non_beras'
	];

	public function dw()
	{
		return $this->belongsTo(Dw::class);
	}
}
