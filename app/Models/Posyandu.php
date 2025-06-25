<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Posyandu
 * 
 * @property int $posyandu_id
 * @property string|null $nama_posyandu
 * 
 * @property Collection|Sip1[] $sip1s
 * @property Collection|Sip2[] $sip2s
 * @property Collection|Sip3[] $sip3s
 *
 * @package App\Models
 */
class Posyandu extends Model
{
	protected $table = 'posyandu';
	protected $primaryKey = 'posyandu_id';
	public $timestamps = false;

	protected $fillable = [
		'nama_posyandu'
	];

	public function sip1s()
	{
		return $this->hasMany(Sip1::class);
	}

	public function sip2s()
	{
		return $this->hasMany(Sip2::class);
	}

	public function sip3s()
	{
		return $this->hasMany(Sip3::class);
	}
}
