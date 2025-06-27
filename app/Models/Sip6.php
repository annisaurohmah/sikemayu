<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Sip6
 * 
 * @property int $id
 * @property int|null $bulan
 * @property int|null $tahun
 * @property int|null $bayi_0_12_bulan
 * @property int|null $balita_1_5_tahun
 * @property int|null $jumlah_wus
 * @property int|null $jumlah_pus
 * @property int|null $jumlah_hamil
 * @property int|null $jumlah_menyusui
 * @property int|null $bayi_lahir
 * @property int|null $bayi_meninggal
 * @property int|null $ibu_hamil_meninggal
 * @property int|null $ibu_melahirkan_meninggal
 * @property int|null $nifas
 * @property int|null $kader_posyandu
 * @property int|null $plkb
 * @property int|null $medis_paramedis
 * @property string|null $keterangan
 *
 * @package App\Models
 */
class Sip6 extends Model
{
	protected $table = 'sip_6';
	public $timestamps = false;

	protected $casts = [
		'bulan' => 'int',
		'tahun' => 'int',
		'bayi_0_12_bulan' => 'int',
		'balita_1_5_tahun' => 'int',
		'jumlah_wus' => 'int',
		'jumlah_pus' => 'int',
		'jumlah_hamil' => 'int',
		'jumlah_menyusui' => 'int',
		'bayi_lahir' => 'int',
		'bayi_meninggal' => 'int',
		'ibu_hamil_meninggal' => 'int',
		'ibu_melahirkan_meninggal' => 'int',
		'nifas' => 'int',
		'kader_posyandu' => 'int',
		'plkb' => 'int',
		'medis_paramedis' => 'int'
	];

	protected $fillable = [
		'bulan',
		'tahun',
		'bayi_0_12_bulan',
		'balita_1_5_tahun',
		'jumlah_wus',
		'jumlah_pus',
		'jumlah_hamil',
		'jumlah_menyusui',
		'bayi_lahir',
		'bayi_meninggal',
		'ibu_hamil_meninggal',
		'ibu_melahirkan_meninggal',
		'nifas',
		'kader_posyandu',
		'plkb',
		'medis_paramedis',
		'keterangan'
	];
}
