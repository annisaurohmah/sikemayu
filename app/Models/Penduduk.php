<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Penduduk
 * 
 * @property string $nik
 * @property string $no_kk
 * @property string $nama
 * @property Carbon $tanggal_lahir
 * @property string $jenis_kelamin
 * @property string $shdk
 * @property string $bpjs
 * @property string $faskes
 * @property string $pendidikan
 * @property string $pekerjaan
 * @property string $alamat
 * @property int $rt
 * @property int $rw
 *
 * @package App\Models
 */
class Penduduk extends Model
{
	protected $table = 'penduduk';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'tanggal_lahir' => 'datetime',
		'rt' => 'int',
		'rw' => 'int'
	];

	protected $fillable = [
		'nik',
		'no_kk',
		'nama',
		'tanggal_lahir',
		'jenis_kelamin',
		'shdk',
		'bpjs',
		'faskes',
		'pendidikan',
		'pekerjaan',
		'alamat',
		'rt',
		'rw'
	];
}
