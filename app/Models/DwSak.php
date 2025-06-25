<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DwSak
 * 
 * @property int $sak_id
 * @property int|null $dw_id
 * @property int|null $pdam
 * @property int|null $sumur
 * @property int|null $sungai
 * @property int|null $dll
 * 
 * @property Dw|null $dw
 *
 * @package App\Models
 */
class DwSak extends Model
{
	protected $table = 'dw_sak';
	protected $primaryKey = 'sak_id';
	public $timestamps = false;

	protected $casts = [
		'dw_id' => 'int',
		'pdam' => 'int',
		'sumur' => 'int',
		'sungai' => 'int',
		'dll' => 'int'
	];

	protected $fillable = [
		'dw_id',
		'pdam',
		'sumur',
		'sungai',
		'dll'
	];

	public function dw()
	{
		return $this->belongsTo(Dw::class);
	}
}
