<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Rekapgizibulanan
 * 
 * @property int $id
 * @property int|null $bulan
 * @property int|null $tahun
 * 
 * @property Collection|Gizibalitaperkategori[] $gizibalitaperkategoris
 * @property Collection|Giziibuhamil[] $giziibuhamils
 *
 * @package App\Models
 */
class Rekapgizibulanan extends Model
{
	protected $table = 'rekapgizibulanan';
	public $timestamps = false;

	protected $casts = [
		'bulan' => 'int',
		'tahun' => 'int'
	];

	protected $fillable = [
		'bulan',
		'tahun'
	];

	public function gizibalitaperkategoris()
	{
		return $this->hasMany(Gizibalitaperkategori::class, 'rekap_id');
	}

	public function giziibuhamils()
	{
		return $this->hasMany(Giziibuhamil::class, 'rekap_id');
	}
}
