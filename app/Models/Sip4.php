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
		'umur' => 'int',
		'jumlah_anak_hidup' => 'int',
		'ukuran_lila_cm' => 'float',
		'lebih_23_5_cm' => 'bool'
	];

	protected $fillable = [
		'nama',
		'umur',
		'nama_suami',
		'tahapan_ks',
		'kelompok_dasawisma',
		'jumlah_anak_hidup',
		'anak_meninggal_umur',
		'ukuran_lila_cm',
		'lebih_23_5_cm'
	];

	public function sip4_imunisasitts()
	{
		return $this->hasMany(Sip4Imunisasitt::class, 'wuspus_id');
	}

	public function sip4_kontrasepsis()
	{
		return $this->hasMany(Sip4Kontrasepsi::class, 'wuspus_id');
	}

	public function sip4_penggantiankontrasepsis()
	{
		return $this->hasMany(Sip4Penggantiankontrasepsi::class, 'wuspus_id');
	}
}
