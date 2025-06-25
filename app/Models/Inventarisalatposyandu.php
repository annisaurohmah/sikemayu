<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Inventarisalatposyandu
 * 
 * @property int $id
 * @property int|null $bulan
 * @property int|null $tahun
 * @property string|null $nama_alat
 * @property int|null $jumlah
 * @property int|null $kondisi_baik
 * @property int|null $kondisi_rusak
 * @property int|null $kebutuhan
 *
 * @package App\Models
 */
class Inventarisalatposyandu extends Model
{
	protected $table = 'inventarisalatposyandu';
	public $timestamps = false;

	protected $casts = [
		'bulan' => 'int',
		'tahun' => 'int',
		'jumlah' => 'int',
		'kondisi_baik' => 'int',
		'kondisi_rusak' => 'int',
		'kebutuhan' => 'int'
	];

	protected $fillable = [
		'bulan',
		'tahun',
		'nama_alat',
		'jumlah',
		'kondisi_baik',
		'kondisi_rusak',
		'kebutuhan'
	];
}
