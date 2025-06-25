<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sip2KeteranganBalita;

/**
 * Class Sip2
 * 
 * @property int $bayi_id
 * @property int|null $posyandu_id
 * @property string|null $nama_bayi
 * @property Carbon|null $tgl_lahir
 * @property int|null $bbl_kg
 * @property string|null $nama_ayah
 * @property string|null $nama_ibu
 * @property int|null $dasawisma_id
 * 
 * @property Posyandu|null $posyandu
 * @property Dasawisma|null $dasawisma
 * @property Collection|Sip2Imunisasi[] $sip2_imunisasis
 * @property Collection|Sip2Keteranganbalita[] $sip2_keteranganbalita
 * @property Collection|Sip2Pelayanan[] $sip2_pelayanans
 * @property Collection|Sip2Pemberianasi[] $sip2_pemberianasis
 * @property Collection|Sip2Penimbangan[] $sip2_penimbangans
 * @property Collection|Sip2PemberianASI[] $asi
 * @property Collection|Sip2Pelayanan[] $pelayanan
 * @property Collection|Sip2Imunisasi[] $imunisasi
 * @property Sip2KeteranganBalita|null $keteranganBalita
 * 
 *
 * @package App\Models
 */
class Sip2 extends Model
{
	protected $table = 'sip_2';
	protected $primaryKey = 'bayi_id';
	public $timestamps = false;

	protected $casts = [
		'posyandu_id' => 'int',
		'tgl_lahir' => 'datetime',
		'bbl_kg' => 'int',
		'dasawisma_id' => 'int'
	];

	protected $fillable = [
		'posyandu_id',
		'nama_bayi',
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

	public function sip2_imunisasis()
	{
		return $this->hasMany(Sip2Imunisasi::class, 'bayi_id');
	}

	public function sip2_keteranganbalita()
	{
		return $this->hasMany(Sip2Keteranganbalita::class, 'bayi_id');
	}

	public function sip2_pelayanans()
	{
		return $this->hasMany(Sip2Pelayanan::class, 'bayi_id');
	}

	public function sip2_pemberianasis()
	{
		return $this->hasMany(Sip2Pemberianasi::class, 'bayi_id');
	}

	public function sip2_penimbangans()
	{
		return $this->hasMany(Sip2Penimbangan::class, 'bayi_id');
	}

	public function penimbangan()
	{
		return $this->hasMany(Sip2Penimbangan::class, 'bayi_id');
	}
	public function asi()
	{
		return $this->hasMany(Sip2PemberianASI::class, 'bayi_id');
	}
	public function pelayanan()
	{
		return $this->hasMany(Sip2Pelayanan::class, 'bayi_id');
	}
	public function imunisasi()
	{
		return $this->hasMany(Sip2Imunisasi::class, 'bayi_id');
	}
	public function keteranganBalita()
	{
		return $this->hasOne(Sip2KeteranganBalita::class, 'bayi_id');
	}
}
