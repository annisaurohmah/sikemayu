<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pokja extends Model
{
    use HasFactory;
    
    protected $table = 'pokja';
    protected $primaryKey = 'pokja_id';
    
    protected $fillable = [
        'nama_pokja',
        'judul_pokja', 
        'tanggal',
        'nama_kegiatan',
        'deskripsi',
        'file_gambar',
        'created_by',
        'updated_by'
    ];
    
    protected $casts = [
        'tanggal' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
    // Define pokja categories and their tabs
    public static function getPokjaStructure()
    {
        return [
            'pokja1' => [
                'name' => 'Pokja I',
                'tabs' => [
                    'pokja1-agama' => 'Bidang Keagamaan dan Keterampilan',
                    'pokja1-gotong' => 'Bidang Gotong Royong'
                ]
            ],
            'pokja2' => [
                'name' => 'Pokja II', 
                'tabs' => [
                    'pokja2-pendidikan' => 'Bidang Pendidikan dan Keterampilan',
                    'pokja2-koperasi' => 'Bidang Pengembangan Kehidupan Berkoperasi'
                ]
            ],
            'pokja3' => [
                'name' => 'Pokja III',
                'tabs' => [
                    'pokja3-pangan' => 'Bidang Pangan',
                    'pokja3-sandang' => 'Bidang Sandang',
                    'pokja3-perumahan' => 'Bidang Perumahan dan Tatalaksana Rumah Tangga'
                ]
            ],
            'pokja4' => [
                'name' => 'Pokja IV',
                'tabs' => [
                    'pokja4-kesehatan' => 'Bidang Kesehatan',
                    'pokja4-lingkungan' => 'Bidang Kelestarian Lingkungan Hidup',
                    'pokja4-rencana' => 'Perencanaan Sehat'
                ]
            ]
        ];
    }
    
    // Get data by pokja name
    public static function getByPokjaName($namaPokja)
    {
        return self::where('nama_pokja', $namaPokja)
                   ->orderBy('tanggal', 'desc')
                   ->get();
    }
}
