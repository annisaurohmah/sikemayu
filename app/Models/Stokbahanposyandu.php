<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Stokbahanposyandu
 * 
 * @property int $id
 * @property int|null $bulan
 * @property int|null $tahun
 * @property string|null $nama_bahan
 * @property string|null $satuan
 * @property int|null $sisa_bulan_lalu
 * @property int|null $diterima_bulan_ini
 * @property int|null $jumlah
 * @property int|null $pemakaian
 * @property int|null $sisa_bulan_ini
 *
 * @package App\Models
 */
class Stokbahanposyandu extends Model
{
	protected $table = 'stokbahanposyandu';
	public $timestamps = false;

	protected $casts = [
		'bulan' => 'int',
		'tahun' => 'int',
		'sisa_bulan_lalu' => 'int',
		'diterima_bulan_ini' => 'int',
		'jumlah' => 'int',
		'pemakaian' => 'int',
		'sisa_bulan_ini' => 'int'
	];

	protected $fillable = [
		'bulan',
		'tahun',
		'nama_bahan',
		'satuan',
		'sisa_bulan_lalu',
		'diterima_bulan_ini',
		'jumlah',
		'pemakaian',
		'sisa_bulan_ini'
	];
}
