<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

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
		return $this->belongsTo(Dasawisma::class);
	}

	public function sip3_imunisasis()
	{
		return $this->hasMany(Sip3Imunisasi::class, 'balita_id');
	}

	public function sip3_keteranganbalita()
	{
		return $this->hasMany(Sip3Keteranganbalitum::class, 'balita_id');
	}

	public function sip3_penimbangans()
	{
		return $this->hasMany(Sip3Penimbangan::class, 'balita_id');
	}
}
