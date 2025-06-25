<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Gizibalitaperkategori
 * 
 * @property int $id
 * @property int|null $rekap_id
 * @property int|null $nomor_variabel
 * @property string|null $nama_variabel
 * @property string|null $usia_kelompok
 * @property string|null $jenis_kelamin
 * @property int|null $jumlah
 * 
 * @property Rekapgizibulanan|null $rekapgizibulanan
 *
 * @package App\Models
 */
class Gizibalitaperkategori extends Model
{
	protected $table = 'gizibalitaperkategori';
	public $timestamps = false;

	protected $casts = [
		'rekap_id' => 'int',
		'nomor_variabel' => 'int',
		'jumlah' => 'int'
	];

	protected $fillable = [
		'rekap_id',
		'nomor_variabel',
		'nama_variabel',
		'usia_kelompok',
		'jenis_kelamin',
		'jumlah'
	];

	public function rekapgizibulanan()
	{
		return $this->belongsTo(Rekapgizibulanan::class, 'rekap_id');
	}
}
