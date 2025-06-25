<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Sip2Penimbangan
 * 
 * @property int $timbang_id
 * @property int|null $bayi_id
 * @property int|null $bulan
 * @property int|null $tahun
 * @property float|null $bb_hasil_penimbangan
 * @property float $tb_hasil_penimbangan
 * 
 * @property Sip2|null $sip2
 *
 * @package App\Models
 */
class Sip2Penimbangan extends Model
{
	protected $table = 'sip2_penimbangan';
	protected $primaryKey = 'timbang_id';
	public $timestamps = false;

	protected $casts = [
		'bayi_id' => 'int',
		'bulan' => 'int',
		'tahun' => 'int',
		'bb_hasil_penimbangan' => 'float',
		'tb_hasil_penimbangan' => 'float'
	];

	protected $fillable = [
		'bayi_id',
		'bulan',
		'tahun',
		'bb_hasil_penimbangan',
		'tb_hasil_penimbangan'
	];

	public function sip2()
	{
		return $this->belongsTo(Sip2::class, 'bayi_id');
	}
}
