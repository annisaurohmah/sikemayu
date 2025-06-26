<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\Dasawisma;
use App\Models\Posyandu;
use App\Models\Sip3Imunisasi;

use App\Models\Sip3Penimbangan;
use App\Models\Sip3Pelayanan;
use App\Models\Sip3KeteranganBalita;

/**
 * Class Sip3
 * 
 * @property int $balita_id
 * @property int|null $posyandu_id
 * @property string|null $nama_balita
 * @property Carbon|null $tgl_lahir
 * @property int|null $bbl_kg
 * @property string|null $nama_ayah
 * @property string|null $nama_ibu
 * @property int|null $dasawisma_id
 * 
 * @property Posyandu|null $posyandu
 * @property Dasawisma|null $dasawisma
 * @property Collection|Sip3Imunisasi[] $sip3_imunisasis
 * @property Collection|Sip3Keteranganbalitum[] $sip3_keteranganbalita
 * @property Collection|Sip3Penimbangan[] $sip3_penimbangans
 * @property Collection|Sip3Pelayanan[] $sip3_pelayanans
 * @property Collection|Sip3Imunisasi[] $sip3_imunisasi
 *
 * @package App\Models
 */
class Sip3 extends Model
{
	protected $table = 'sip_3';
	protected $primaryKey = 'balita_id';
	public $timestamps = false;

	protected $casts = [
		'posyandu_id' => 'int',
		'tgl_lahir' => 'datetime',
		'bbl_kg' => 'int',
		'dasawisma_id' => 'int'
	];

	protected $fillable = [
		'posyandu_id',
		'nama_balita',
		'tgl_lahir',
		'bbl_kg',
		'nama_ayah',
		'nama_ibu',
		'dasawisma_id'
	];

	public function posyandu()
	{
		return $this->belongsTo(Posyandu::class);
	}

	public function dasawisma()
	{
		return $this->belongsTo(Dasawisma::class, 'dasawisma_id');
	}

	public function sip3_imunisasis()
	{
		return $this->hasMany(Sip3Imunisasi::class, 'balita_id');
	}

	public function sip3_keteranganbalita()
	{
		return $this->hasMany(Sip3Keteranganbalita::class, 'balita_id');
	}

	public function sip3_penimbangans()
	{
		return $this->hasMany(Sip3Penimbangan::class, 'balita_id');
	}
	public function penimbangan() {
    return $this->hasMany(Sip3Penimbangan::class, 'bayi_id');
}

public function pelayanan() {
    return $this->hasMany(Sip3Pelayanan::class, 'bayi_id');
}
public function imunisasi() {
    return $this->hasMany(Sip3Imunisasi::class, 'bayi_id');
}
public function keteranganBalita() {
    return $this->hasOne(Sip3KeteranganBalita::class, 'bayi_id');
}

}
