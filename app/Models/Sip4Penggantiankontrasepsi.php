<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sip4Penggantiankontrasepsi
 * 
 * @property int $id
 * @property int|null $wuspus_id
 * @property Carbon|null $tanggal_penggantian
 * @property string|null $jenis_baru
 * 
 * @property Sip4|null $sip4
 *
 * @package App\Models
 */
class Sip4Penggantiankontrasepsi extends Model
{
	protected $table = 'sip4_penggantiankontrasepsi';
	public $timestamps = false;

	protected $casts = [
		'wuspus_id' => 'int',
		'tanggal_penggantian' => 'datetime'
	];

	protected $fillable = [
		'wuspus_id',
		'tanggal_penggantian',
		'jenis_baru'
	];

	public function sip4()
	{
		return $this->belongsTo(Sip4::class, 'wuspus_id');
	}
}
