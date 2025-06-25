<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Lphbp
 * 
 * @property int $lphbp_id
 * @property string|null $nama_posyandu
 * @property string|null $nama_kader
 * @property Carbon|null $tgl_pelaksanaan
 * @property int|null $kdr_bertugas
 * @property int|null $ssrn_bayi_balita
 * @property int|null $bayi_balita_hadir
 * @property int|null $ssrn_ibu_hamil
 * @property int|null $ibu_hamil_hadir
 * @property int|null $ibu_hamil_kek
 * @property int|null $ibu_bersalin
 * @property int|null $calon_pengantin
 * @property string|null $dokum
 *
 * @package App\Models
 */
class Lphbp extends Model
{
	protected $table = 'lphbp';
	protected $primaryKey = 'lphbp_id';
	public $timestamps = false;

	protected $casts = [
		'tgl_pelaksanaan' => 'datetime',
		'kdr_bertugas' => 'int',
		'ssrn_bayi_balita' => 'int',
		'bayi_balita_hadir' => 'int',
		'ssrn_ibu_hamil' => 'int',
		'ibu_hamil_hadir' => 'int',
		'ibu_hamil_kek' => 'int',
		'ibu_bersalin' => 'int',
		'calon_pengantin' => 'int'
	];

	protected $fillable = [
		'nama_posyandu',
		'nama_kader',
		'tgl_pelaksanaan',
		'kdr_bertugas',
		'ssrn_bayi_balita',
		'bayi_balita_hadir',
		'ssrn_ibu_hamil',
		'ibu_hamil_hadir',
		'ibu_hamil_kek',
		'ibu_bersalin',
		'calon_pengantin',
		'dokum'
	];
}
