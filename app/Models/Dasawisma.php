<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Dasawisma
 * 
 * @property int $dasawisma_id
 * @property string|null $nama_dasawisma
 * 
 * @property Collection|Sip2[] $sip2s
 * @property Collection|Sip3[] $sip3s
 *
 * @package App\Models
 */
class Dasawisma extends Model
{
	protected $table = 'dasawisma';
	protected $primaryKey = 'dasawisma_id';
	public $incrementing = false;
	public $timestamps = false;

	protected $casts = [
		'dasawisma_id' => 'int'
	];

	protected $fillable = [
		'nama_dasawisma'
	];

	public function sip2s()
	{
		return $this->hasMany(Sip2::class);
	}

	public function sip3s()
	{
		return $this->hasMany(Sip3::class);
	}
}
