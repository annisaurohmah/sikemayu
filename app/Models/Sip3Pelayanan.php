<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sip3Pelayanan
 * 
 * @property int $pelayanan_id
 * @property int|null $balita_id
 * @property string|null $jenis
 * @property Carbon|null $tanggal_diberikan
 * 
 * @property Sip3|null $sip2
 *
 * @package App\Models
 */
class Sip3Pelayanan extends Model
{
	protected $table = 'sip3_pelayanan';
	protected $primaryKey = 'pelayanan_id';
	public $timestamps = false;

	protected $casts = [
		'balita_id' => 'int',
		'tanggal_diberikan' => 'datetime'
	];

	protected $fillable = [
		'balita_id',
		'jenis',
		'tanggal_diberikan'
	];

	public function sip3()
	{
		return $this->belongsTo(Sip3::class, 'balita_id');
	}

}
