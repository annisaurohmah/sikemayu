<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sip4Imunisasitt
 * 
 * @property int $id
 * @property int|null $wuspus_id
 * @property string|null $tt_ke
 * @property Carbon|null $tanggal_pemberian
 * 
 * @property Sip4|null $sip4
 *
 * @package App\Models
 */
class Sip4Imunisasitt extends Model
{
	protected $table = 'sip4_imunisasitt';
	public $timestamps = false;

	protected $casts = [
		'wuspus_id' => 'int',
		'tanggal_pemberian' => 'datetime'
	];

	protected $fillable = [
		'wuspus_id',
		'tt_ke',
		'tanggal_pemberian'
	];

	public function sip4()
	{
		return $this->belongsTo(Sip4::class, 'wuspus_id');
	}
}
