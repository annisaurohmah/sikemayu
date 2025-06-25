<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sip5Tablettambahdarah
 * 
 * @property int $id
 * @property int|null $ibu_hamil_id
 * @property string|null $jenis
 * @property Carbon|null $tanggal_diberikan
 * 
 * @property Sip5|null $sip5
 *
 * @package App\Models
 */
class Sip5Tablettambahdarah extends Model
{
	protected $table = 'sip5_tablettambahdarah';
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
