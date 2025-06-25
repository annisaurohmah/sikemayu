<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sip5
 * 
 * @property int $ibu_hamil_id
 * @property string|null $nama_ibu
 * @property int|null $umur
 * @property string|null $alamat_kelompok
 * @property Carbon|null $tanggal_pendaftaran
 * @property int|null $umur_kehamilan
 * @property int|null $hamil_ke
 * @property float|null $ukuran_lila
 * @property bool|null $pmt_pemulihan
 * @property string|null $catatan
 * 
 * @property Collection|Sip5Imunisasittibuhamil[] $sip5_imunisasittibuhamils
 * @property Collection|Sip5Penimbanganibuhamil[] $sip5_penimbanganibuhamils
 * @property Collection|Sip5Tablettambahdarah[] $sip5_tablettambahdarahs
 * @property Collection|Sip5Vitaminaibuhamil[] $sip5_vitaminaibuhamils
 *
 * @package App\Models
 */
class Sip5 extends Model
{
	protected $table = 'sip_5';
	protected $primaryKey = 'ibu_hamil_id';
	public $timestamps = false;

	protected $casts = [
		'umur' => 'int',
		'tanggal_pendaftaran' => 'datetime',
		'umur_kehamilan' => 'int',
		'hamil_ke' => 'int',
		'ukuran_lila' => 'float',
		'pmt_pemulihan' => 'bool'
	];

	protected $fillable = [
		'nama_ibu',
		'umur',
		'alamat_kelompok',
		'tanggal_pendaftaran',
		'umur_kehamilan',
		'hamil_ke',
		'ukuran_lila',
		'pmt_pemulihan',
		'catatan'
	];

	public function sip5_imunisasittibuhamils()
	{
		return $this->hasMany(Sip5Imunisasittibuhamil::class, 'ibu_hamil_id');
	}

	public function sip5_penimbanganibuhamils()
	{
		return $this->hasMany(Sip5Penimbanganibuhamil::class, 'ibu_hamil_id');
	}

	public function sip5_tablettambahdarahs()
	{
		return $this->hasMany(Sip5Tablettambahdarah::class, 'ibu_hamil_id');
	}

	public function sip5_vitaminaibuhamils()
	{
		return $this->hasMany(Sip5Vitaminaibuhamil::class, 'ibu_hamil_id');
	}
}
