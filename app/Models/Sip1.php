<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sip1
 * 
 * @property int $sip1_id
 * @property int|null $posyandu_id
 * @property Carbon|null $tahun
 * @property string|null $bulan
 * @property int|null $rw_id
 * @property string|null $nama_ibu
 * @property string|null $nama_bapak
 * @property string|null $nama_bayi
 * @property Carbon|null $tgl_lahir
 * @property Carbon|null $tgl_meninggal_ibu
 * @property Carbon|null $tgl_meninggal_bayi
 * @property string|null $keterangan
 * 
 * @property Posyandu|null $posyandu
 *
 * @package App\Models
 */
class Sip1 extends Model
{
	protected $table = 'sip_1';
	protected $primaryKey = 'sip1_id';
	public $timestamps = false;

	protected $casts = [
		'posyandu_id' => 'int',
		'tahun' => 'int',
		'rw_id' => 'int',
		'tgl_lahir' => 'datetime',
		'tgl_meninggal_ibu' => 'datetime',
		'tgl_meninggal_bayi' => 'datetime'
	];

	protected $fillable = [
		'posyandu_id',
		'tahun',
		'bulan',
		'rw_id',
		'nama_ibu',
		'nama_bapak',
		'nama_bayi',
		'tgl_lahir',
		'tgl_meninggal_ibu',
		'tgl_meninggal_bayi',
		'keterangan'
	];

	public function posyandu()
	{
		return $this->belongsTo(Posyandu::class);
	}
}
