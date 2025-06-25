<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sip4Kontrasepsi
 * 
 * @property int $id
 * @property int|null $wuspus_id
 * @property string|null $jenis_kontrasepsi
 * @property Carbon|null $tanggal_mulai
 * 
 * @property Sip4|null $sip4
 *
 * @package App\Models
 */
class Sip4Kontrasepsi extends Model
{
	protected $table = 'sip4_kontrasepsi';
	public $timestamps = false;

	protected $casts = [
		'wuspus_id' => 'int',
		'tanggal_mulai' => 'datetime'
	];

	protected $fillable = [
		'wuspus_id',
		'jenis_kontrasepsi',
		'tanggal_mulai'
	];

	public function sip4()
	{
		return $this->belongsTo(Sip4::class, 'wuspus_id');
	}
}
