<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Anak
 * 
 * @property string $nik
 * @property string $nama_lengkap
 * @property string $jenis_kelamin
 * @property Carbon $tanggal_lahir
 * @property string $nama_lengkap_ortu
 * @property string $jenis_kelamin_ortu
 *
 * @package App\Models
 */
class Anak extends Model
{
	protected $table = 'anak';
	protected $primaryKey = 'nik';
	protected $keyType = 'string';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'tanggal_lahir' => 'datetime'
	];

	protected $fillable = [
		'nik',
		'nama_lengkap',
		'jenis_kelamin',
		'tanggal_lahir',
		'nama_lengkap_ortu',
		'jenis_kelamin_ortu'
	];
}
