<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sip2Imunisasi
 * 
 * @property int $imunisasi_id
 * @property int|null $bayi_id
 * @property string|null $jenis
 * @property Carbon|null $tanggal_diberikan
 * 
 * @property Sip2|null $sip2
 *
 * @package App\Models
 */
class Sip2Imunisasi extends Model
{
	protected $table = 'sip2_imunisasi';
	protected $primaryKey = 'imunisasi_id';
	public $timestamps = false;

	protected $casts = [
		'bayi_id' => 'int',
		'tanggal_diberikan' => 'datetime'
	];

	protected $fillable = [
		'bayi_id',
		'jenis',
		'tanggal_diberikan'
	];

	public function sip2()
	{
		return $this->belongsTo(Sip2::class, 'bayi_id');
	}
}
