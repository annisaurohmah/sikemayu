<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Sip3
 * 
 * @property int $balita_id
 * @property int|null $posyandu_id
 * @property string|null $nama_bayi
 * @property Carbon|null $tgl_lahir
 * @property int|null $bbl_kg
 * @property string|null $nama_ayah
 * @property string|null $nama_ibu
 * @property int|null $dasawisma_id
 * 
 * @property Posyandu|null $posyandu
 * @property Dasawisma|null $dasawisma
 *
 * @package App\Models
 */
class Sip3 extends Model
{
	protected $table = 'sip_3';
	protected $primaryKey = 'balita_id';
	public $timestamps = false;

	protected $casts = [
		'posyandu_id' => 'int',
		'tgl_lahir' => 'datetime',
		'bbl_kg' => 'int',
		'dasawisma_id' => 'int'
	];

	protected $fillable = [
		'posyandu_id',
		'nama_bayi',
		'tgl_lahir',
		'bbl_kg',
		'nama_ayah',
		'nama_ibu',
		'dasawisma_id'
	];

	public function posyandu()
	{
		return $this->belongsTo(Posyandu::class);
	}

	public function dasawisma()
	{
		return $this->belongsTo(Dasawisma::class);
	}
}
