<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sip3Keteranganbalitum
 * 
 * @property int $ket_id
 * @property int|null $balita_id
 * @property Carbon|null $tanggal_meninggal
 * @property string|null $catatan
 * 
 * @property Sip3|null $sip3
 *
 * @package App\Models
 */
class Sip3Keteranganbalita extends Model
{
	protected $table = 'sip3_keteranganbalita';
	protected $primaryKey = 'ket_id';
	public $timestamps = false;

	protected $casts = [
		'balita_id' => 'int',
		'tanggal_meninggal' => 'datetime'
	];

	protected $fillable = [
		'balita_id',
		'tanggal_meninggal',
		'catatan'
	];

	public function sip3()
	{
		return $this->belongsTo(Sip3::class, 'balita_id');
	}
}
