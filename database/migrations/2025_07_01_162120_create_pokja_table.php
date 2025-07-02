<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pokja', function (Blueprint $table) {
            $table->id('pokja_id');
            $table->string('nama_pokja', 50); // pokja1-agama, pokja1-keterampilan, etc
            $table->string('judul_pokja', 255); // Display name
            $table->date('tanggal');
            $table->string('nama_kegiatan', 255);
            $table->text('deskripsi');
            $table->string('file_gambar', 255)->nullable();
            $table->string('created_by', 100)->nullable();
            $table->string('updated_by', 100)->nullable();
            $table->timestamps();
            
            // Index untuk pencarian berdasarkan nama_pokja
            $table->index('nama_pokja');
            $table->index('tanggal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pokja');
    }
};
