<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rekapkegiatanposyandubulanan
 * 
 * @property int $id
 * @property int|null $bulan
 * @property int|null $tahun
 * @property int|null $jml_ibu_hamil
 * @property int|null $ibu_melahirkan
 * @property int|null $ibu_mendapat_fe
 * @property int|null $ibu_menyusui
 * @property int|null $ibu_nifas_dapat_vit_a
 * @property int|null $kb_kondom
 * @property int|null $kb_pil
 * @property int|null $kb_suntik
 * @property int|null $balita_sasaran
 * @property int|null $balita_punya_buku
 * @property int|null $balita_ditimbang
 * @property int|null $balita_naik
 * @property int|null $balita_bgm
 * @property int|null $bayi_balita_vit_a
 * @property int|null $bayi_balita_pmt_penyuluhan
 * @property int|null $imunisasi_hb0
 * @property int|null $imunisasi_bcg
 * @property int|null $imunisasi_polio_i
 * @property int|null $imunisasi_polio_ii
 * @property int|null $imunisasi_polio_iii
 * @property int|null $imunisasi_polio_iv
 * @property int|null $imunisasi_dpt_hb_i
 * @property int|null $imunisasi_dpt_hb_ii
 * @property int|null $imunisasi_dpt_hb_iii
 * @property int|null $imunisasi_campak
 * @property int|null $tt_i
 * @property int|null $tt_ii
 * @property int|null $tt_iii
 * @property int|null $tt_iv
 * @property int|null $tt_v
 * @property int|null $balita_diare
 * @property int|null $balita_diare_dapat_oralit
 * @property string|null $keterangan
 *
 * @package App\Models
 */
class Rekapkegiatanposyandubulanan extends Model
{
	protected $table = 'rekapkegiatanposyandubulanan';
	public $timestamps = false;

	protected $casts = [
		'bulan' => 'int',
		'tahun' => 'int',
		'jml_ibu_hamil' => 'int',
		'ibu_melahirkan' => 'int',
		'ibu_mendapat_fe' => 'int',
		'ibu_menyusui' => 'int',
		'ibu_nifas_dapat_vit_a' => 'int',
		'kb_kondom' => 'int',
		'kb_pil' => 'int',
		'kb_suntik' => 'int',
		'balita_sasaran' => 'int',
		'balita_punya_buku' => 'int',
		'balita_ditimbang' => 'int',
		'balita_naik' => 'int',
		'balita_bgm' => 'int',
		'bayi_balita_vit_a' => 'int',
		'bayi_balita_pmt_penyuluhan' => 'int',
		'imunisasi_hb0' => 'int',
		'imunisasi_bcg' => 'int',
		'imunisasi_polio_i' => 'int',
		'imunisasi_polio_ii' => 'int',
		'imunisasi_polio_iii' => 'int',
		'imunisasi_polio_iv' => 'int',
		'imunisasi_dpt_hb_i' => 'int',
		'imunisasi_dpt_hb_ii' => 'int',
		'imunisasi_dpt_hb_iii' => 'int',
		'imunisasi_campak' => 'int',
		'tt_i' => 'int',
		'tt_ii' => 'int',
		'tt_iii' => 'int',
		'tt_iv' => 'int',
		'tt_v' => 'int',
		'balita_diare' => 'int',
		'balita_diare_dapat_oralit' => 'int'
	];

	protected $fillable = [
		'bulan',
		'tahun',
		'jml_ibu_hamil',
		'ibu_melahirkan',
		'ibu_mendapat_fe',
		'ibu_menyusui',
		'ibu_nifas_dapat_vit_a',
		'kb_kondom',
		'kb_pil',
		'kb_suntik',
		'balita_sasaran',
		'balita_punya_buku',
		'balita_ditimbang',
		'balita_naik',
		'balita_bgm',
		'bayi_balita_vit_a',
		'bayi_balita_pmt_penyuluhan',
		'imunisasi_hb0',
		'imunisasi_bcg',
		'imunisasi_polio_i',
		'imunisasi_polio_ii',
		'imunisasi_polio_iii',
		'imunisasi_polio_iv',
		'imunisasi_dpt_hb_i',
		'imunisasi_dpt_hb_ii',
		'imunisasi_dpt_hb_iii',
		'imunisasi_campak',
		'tt_i',
		'tt_ii',
		'tt_iii',
		'tt_iv',
		'tt_v',
		'balita_diare',
		'balita_diare_dapat_oralit',
		'keterangan'
	];
}
