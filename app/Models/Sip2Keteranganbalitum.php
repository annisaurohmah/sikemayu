<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sip2Keteranganbalitum
 * 
 * @property int $ket_id
 * @property int|null $bayi_id
 * @property Carbon|null $tanggal_meninggal
 * @property string|null $catatan
 * 
 * @property Sip2|null $sip2
 *
 * @package App\Models
 */
class Sip2Keteranganbalitum extends Model
{
	protected $table = 'sip2_keteranganbalita';
	protected $primaryKey = 'ket_id';
	public $timestamps = false;

	protected $casts = [
		'bayi_id' => 'int',
		'tanggal_meninggal' => 'datetime'
	];

	protected $fillable = [
		'bayi_id',
		'tanggal_meninggal',
		'catatan'
	];

	public function sip2()
	{
		return $this->belongsTo(Sip2::class, 'bayi_id');
	}
}
