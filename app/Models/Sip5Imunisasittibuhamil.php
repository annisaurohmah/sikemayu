<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sip5Imunisasittibuhamil
 * 
 * @property int $id
 * @property int|null $ibu_hamil_id
 * @property string|null $tt_ke
 * @property Carbon|null $tanggal_pemberian
 * 
 * @property Sip5|null $sip5
 *
 * @package App\Models
 */
class Sip5Imunisasittibuhamil extends Model
{
	protected $table = 'sip5_imunisasittibuhamil';
	public $timestamps = false;

	protected $casts = [
		'ibu_hamil_id' => 'int',
		'tanggal_diberikan' => 'datetime'
	];

	protected $fillable = [
		'ibu_hamil_id',
		'jenis',
		'tanggal_diberikan'
	];

	public function sip5()
	{
		return $this->belongsTo(Sip5::class, 'ibu_hamil_id');
	}
}
