<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class DwJak
 * 
 * @property int $jak_id
 * @property int|null $dw_id
 * @property int|null $total_P
 * @property int|null $total_L
 * @property int|null $balita_L
 * @property int|null $balita_P
 * @property int|null $PUS
 * @property int|null $WUS
 * @property int|null $ibu_hamil
 * @property int|null $ibu_menyusui
 * @property int|null $lansia
 * @property int|null $tiga_buta_L
 * @property int|null $tiga_buta_P
 * 
 * @property Dw|null $dw
 *
 * @package App\Models
 */
class DwJak extends Model
{
	protected $table = 'dw_jak';
	protected $primaryKey = 'jak_id';
	public $timestamps = false;

	protected $casts = [
		'dw_id' => 'int',
		'total_P' => 'int',
		'total_L' => 'int',
		'balita_L' => 'int',
		'balita_P' => 'int',
		'PUS' => 'int',
		'WUS' => 'int',
		'ibu_hamil' => 'int',
		'ibu_menyusui' => 'int',
		'lansia' => 'int',
		'tiga_buta_L' => 'int',
		'tiga_buta_P' => 'int'
	];

	protected $fillable = [
		'dw_id',
		'total_P',
		'total_L',
		'balita_L',
		'balita_P',
		'PUS',
		'WUS',
		'ibu_hamil',
		'ibu_menyusui',
		'lansia',
		'tiga_buta_L',
		'tiga_buta_P'
	];

	public function dw()
	{
		return $this->belongsTo(Dw::class);
	}
}
