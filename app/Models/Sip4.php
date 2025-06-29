<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sip4
 * 
 * @property int $wuspus_id
 * @property string|null $nama
 * @property int|null $umur
 * @property string|null $nama_suami
 * @property string|null $tahapan_ks
 * @property string|null $kelompok_dasawisma
 * @property int|null $jumlah_anak_hidup
 * @property string|null $anak_meninggal_umur
 * @property float|null $ukuran_lila_cm
 * @property bool|null $lebih_23_5_cm
 * 
 * @property Collection|Sip4Imunisasitt[] $sip4_imunisasitts
 * @property Collection|Sip4Kontrasepsi[] $sip4_kontrasepsis
 * @property Collection|Sip4Penggantiankontrasepsi[] $sip4_penggantiankontrasepsis
 *
 * @package App\Models
 */
class Sip4 extends Model
{
	protected $table = 'sip_4';
	protected $primaryKey = 'wuspus_id';
	public $timestamps = false;

	protected $casts = [
		'posyandu_id' => 'int',
		'bulan' => 'int',
		'tahun' => 'int',
		'umur' => 'int',
		'jumlah_anak_hidup' => 'int',
		'ukuran_lila_cm' => 'float',
		'lebih_23_5_cm' => 'bool'
	];

	protected $fillable = [
		'posyandu_id',
		'bulan',
		'tahun',
		'nama',
		'umur',
		'nama_suami',
		'tahapan_ks',
		'dasawisma_id',
		'jumlah_anak_hidup',
		'anak_meninggal_umur',
		'ukuran_lila_cm',
		'lebih_23_5_cm'
	];

	public function posyandu()
	{
		return $this->belongsTo(Posyandu::class);
	}

	public function dasawisma()
	{
		return $this->belongsTo(Dasawisma::class, 'dasawisma_id');
	}

	public function imunisasitt()
	{
		return $this->hasMany(Sip4Imunisasitt::class, 'wuspus_id');
	}

	public function kontrasepsi()
	{
		return $this->hasMany(Sip4Kontrasepsi::class, 'wuspus_id');
	}

	public function penggantianKontrasepsi()
	{
		return $this->hasMany(Sip4Penggantiankontrasepsi::class, 'wuspus_id');
	}

	// Accessor for jenis_kontrasepsi
	public function getJenisKontrasepsiAttribute()
	{
		return $this->kontrasepsi->first()->jenis_kontrasepsi ?? null;
	}

	// Accessor for tanggal_penggantian
	public function getTanggalPenggantianAttribute()
	{
		return $this->penggantianKontrasepsi->first()->tanggal_penggantian ?? null;
	}

	// Accessor for jenis_kontrasepsi_pengganti
	public function getJenisKontrasepsiPenggantiAttribute()
	{
		return $this->penggantianKontrasepsi->first()->jenis_baru ?? null;
	}
}
