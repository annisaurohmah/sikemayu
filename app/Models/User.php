<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\User as Authenticable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * Class User
 * 
 * @property int $user_id
 * @property string|null $name
 * @property string $email
 * @property string $password
 * @property string $role
 * @property string|null $no_rw
 * @property string|null $nama_posyandu
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @package App\Models
 */
class User extends Authenticable
{
	use HasFactory;
	use Notifiable;

	protected $table = 'users';
	protected $primaryKey = 'user_id';

	protected $hidden = [
		'password',
		'remember_token'
	];

	protected $fillable = [
		'username',
		'password',
		'role',
		'no_rw',
		'nama_posyandu',
		'remember_token'
	];
}
