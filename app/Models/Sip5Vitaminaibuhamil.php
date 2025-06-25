<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sip5Vitaminaibuhamil
 * 
 * @property int $id
 * @property int|null $ibu_hamil_id
 * @property Carbon|null $tanggal_pemberian
 * 
 * @property Sip5|null $sip5
 *
 * @package App\Models
 */
class Sip5Vitaminaibuhamil extends Model
{
	protected $table = 'sip5_vitaminaibuhamil';
	public $timestamps = false;

	protected $casts = [
		'ibu_hamil_id' => 'int',
		'tanggal_pemberian' => 'datetime'
	];

	protected $fillable = [
		'ibu_hamil_id',
		'tanggal_pemberian'
	];

	public function sip5()
	{
		return $this->belongsTo(Sip5::class, 'ibu_hamil_id');
	}
}
