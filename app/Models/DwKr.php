<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DwKr
 * 
 * @property int $kr_id
 * @property int|null $dw_id
 * @property int|null $sehat
 * @property int|null $krg_sehat
 * @property int|null $tempat_sampah
 * @property int|null $spal
 * @property int|null $stiker_pak
 * 
 * @property Dw|null $dw
 *
 * @package App\Models
 */
class DwKr extends Model
{
	protected $table = 'dw_kr';
	protected $primaryKey = 'kr_id';
	public $timestamps = false;

	protected $casts = [
		'dw_id' => 'int',
		'sehat' => 'int',
		'krg_sehat' => 'int',
		'tempat_sampah' => 'int',
		'spal' => 'int',
		'stiker_pak' => 'int'
	];

	protected $fillable = [
		'dw_id',
		'sehat',
		'krg_sehat',
		'tempat_sampah',
		'spal',
		'stiker_pak'
	];

	public function dw()
	{
		return $this->belongsTo(Dw::class);
	}
}
