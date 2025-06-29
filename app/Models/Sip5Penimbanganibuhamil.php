<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Sip5Penimbanganibuhamil
 * 
 * @property int $id
 * @property int|null $ibu_hamil_id
 * @property int|null $bulan
 * @property int|null $tahun
 * @property float|null $berat_badan
 * @property int|null $umur_kehamilan
 * 
 * @property Sip5|null $sip5
 *
 * @package App\Models
 */
class Sip5Penimbanganibuhamil extends Model
{
	protected $table = 'sip5_penimbanganibuhamil';
	public $timestamps = false;

	protected $casts = [
		'ibu_hamil_id' => 'int',
		'bulan' => 'int',
		'tahun' => 'int',
		'tb_hasil_penimbangan' => 'float',
		'bb_hasil_penimbangan' => 'float',
		'umur_kehamilan' => 'int'
	];

	protected $fillable = [
		'ibu_hamil_id',
		'bulan',
		'tahun',
		'tb_hasil_penimbangan',
		'bb_hasil_penimbangan',
		'umur_kehamilan'
	];

	public function sip5()
	{
		return $this->belongsTo(Sip5::class, 'ibu_hamil_id');
	}
}
