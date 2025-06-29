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
		'berat_badan' => 'float',
		'umur_kehamilan' => 'int'
	];

	protected $fillable = [
		'ibu_hamil_id',
		'bulan',
		'tahun',
		'berat_badan',
		'umur_kehamilan'
	];

	public function sip5()
	{
		return $this->belongsTo(Sip5::class, 'ibu_hamil_id', 'ibu_hamil_id');
	}

	// Method untuk menghapus data dengan aman
	public static function deleteByIbuHamilId($ibu_hamil_id)
	{
		return static::where('ibu_hamil_id', $ibu_hamil_id)->delete();
	}

	// Method untuk mengecek apakah ada data terkait
	public static function hasDataForIbuHamil($ibu_hamil_id)
	{
		return static::where('ibu_hamil_id', $ibu_hamil_id)->exists();
	}

	// Accessor untuk kompatibilitas dengan view yang menggunakan tb_hasil_penimbangan
	public function getTbHasilPenimbanganAttribute()
	{
		// Untuk ibu hamil, kita bisa menggunakan tinggi badan standar atau field terpisah
		// Sementara return null karena tidak ada field TB untuk ibu hamil
		return null;
	}

	// Accessor untuk kompatibilitas dengan view yang menggunakan bb_hasil_penimbangan  
	public function getBbHasilPenimbanganAttribute()
	{
		return $this->berat_badan;
	}

	// Mutator untuk bb_hasil_penimbangan
	public function setBbHasilPenimbanganAttribute($value)
	{
		$this->attributes['berat_badan'] = $value;
	}
}
