<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DwWmk
 * 
 * @property int $wmk_id
 * @property int|null $dw_id
 * @property int|null $up2k
 * @property int|null $tanah_pkrgn
 * @property int|null $industri_rt
 * @property int|null $kesling
 * 
 * @property Dw|null $dw
 *
 * @package App\Models
 */
class DwWmk extends Model
{
	protected $table = 'dw_wmk';
	protected $primaryKey = 'wmk_id';
	public $timestamps = false;

	protected $casts = [
		'dw_id' => 'int',
		'up2k' => 'int',
		'tanah_pkrgn' => 'int',
		'industri_rt' => 'int',
		'kesling' => 'int'
	];

	protected $fillable = [
		'dw_id',
		'up2k',
		'tanah_pkrgn',
		'industri_rt',
		'kesling'
	];

	public function dw()
	{
		return $this->belongsTo(Dw::class);
	}
}
