<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Sip3Penimbangan
 * 
 * @property int $timbang_id
 * @property int|null $balita_id
 * @property int|null $bulan
 * @property int|null $tahun
 * @property float|null $bb_hasil_penimbangan
 * @property float|null $tb_hasil_penimbangan
 * 
 * @property Sip3|null $sip3
 *
 * @package App\Models
 */
class Sip3Penimbangan extends Model
{
	protected $table = 'sip3_penimbangan';
	protected $primaryKey = 'timbang_id';
	public $timestamps = false;

	protected $casts = [
		'balita_id' => 'int',
		'bulan' => 'int',
		'tahun' => 'int',
		'bb_hasil_penimbangan' => 'float',
		'tb_hasil_penimbangan' => 'float'
	];

	protected $fillable = [
		'balita_id',
		'bulan',
		'tahun',
		'bb_hasil_penimbangan',
		'tb_hasil_penimbangan'
	];

	public function sip3()
	{
		return $this->belongsTo(Sip3::class, 'balita_id');
	}
}
