<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Carbon\Carbon;

/**
 * Class DokumentasiKegiatan
 * 
 * @property int $id
 * @property int $posyandu_id
 * @property Carbon $tanggal
 * @property string|null $nama_kegiatan
 * @property string $file_path
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 * @property \App\Models\Posyandu $posyandu
 */
class DokumentasiKegiatan extends Model
{
    use HasFactory;

    protected $table = 'dokumentasi_kegiatan';

    protected $fillable = [
        'posyandu_id',
        'tanggal',
        'nama_kegiatan',
        'file_path'
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    // Relasi ke Posyandu
    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'posyandu_id');
    }
}
