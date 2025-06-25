<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Dw
 * 
 * @property int $dw_id
 * @property string|null $bulan
 * @property Carbon|null $tahun
 * @property int|null $rw_id
 * @property int|null $jumlah_RT
 * @property int|null $jumlah_DW
 * @property int|null $jumlah_KRT
 * @property int|null $jumlah_KK
 * @property int|null $jumlah_jamban
 * @property string|null $keterangan
 * 
 * @property Collection|DwJak[] $dw_jaks
 * @property Collection|DwKr[] $dw_krs
 * @property Collection|DwMp[] $dw_mps
 * @property Collection|DwSak[] $dw_saks
 * @property Collection|DwWmk[] $dw_wmks
 *
 * @package App\Models
 */
class Dw extends Model
{
	protected $table = 'dw';
	protected $primaryKey = 'dw_id';
	public $timestamps = false;

	protected $casts = [
		'tahun' => 'datetime',
		'rw_id' => 'int',
		'jumlah_RT' => 'int',
		'jumlah_DW' => 'int',
		'jumlah_KRT' => 'int',
		'jumlah_KK' => 'int',
		'jumlah_jamban' => 'int'
	];

	protected $fillable = [
		'bulan',
		'tahun',
		'rw_id',
		'jumlah_RT',
		'jumlah_DW',
		'jumlah_KRT',
		'jumlah_KK',
		'jumlah_jamban',
		'keterangan'
	];

	public function dw_jaks()
	{
		return $this->hasMany(DwJak::class);
	}

	public function dw_krs()
	{
		return $this->hasMany(DwKr::class);
	}

	public function dw_mps()
	{
		return $this->hasMany(DwMp::class);
	}

	public function dw_saks()
	{
		return $this->hasMany(DwSak::class);
	}

	public function dw_wmks()
	{
		return $this->hasMany(DwWmk::class);
	}
}
