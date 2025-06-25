<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Giziibuhamil
 * 
 * @property int $id
 * @property int|null $rekap_id
 * @property int|null $tablet_30
 * @property int|null $tablet_90
 * @property int|null $risiko_kek
 * @property int|null $risiko_kek_pmtp
 * @property int|null $anemia
 * 
 * @property Rekapgizibulanan|null $rekapgizibulanan
 *
 * @package App\Models
 */
class Giziibuhamil extends Model
{
	protected $table = 'giziibuhamil';
	public $timestamps = false;

	protected $casts = [
		'rekap_id' => 'int',
		'tablet_30' => 'int',
		'tablet_90' => 'int',
		'risiko_kek' => 'int',
		'risiko_kek_pmtp' => 'int',
		'anemia' => 'int'
	];

	protected $fillable = [
		'rekap_id',
		'tablet_30',
		'tablet_90',
		'risiko_kek',
		'risiko_kek_pmtp',
		'anemia'
	];

	public function rekapgizibulanan()
	{
		return $this->belongsTo(Rekapgizibulanan::class, 'rekap_id');
	}
}
