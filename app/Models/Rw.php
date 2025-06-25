<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Rw
 * 
 * @property int $rw_id
 * @property string|null $no_rw
 *
 * @package App\Models
 */
class Rw extends Model
{
	protected $table = 'rw';
	protected $primaryKey = 'rw_id';
	public $timestamps = false;

	protected $fillable = [
		'no_rw'
	];
}
