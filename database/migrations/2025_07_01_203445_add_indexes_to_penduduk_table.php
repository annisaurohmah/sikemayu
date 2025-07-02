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
        Schema::table('penduduk', function (Blueprint $table) {
            // Add indexes for commonly searched and filtered columns
            $table->index(['nik'], 'idx_penduduk_nik');
            $table->index(['nama'], 'idx_penduduk_nama');
            $table->index(['no_kk'], 'idx_penduduk_no_kk');
            $table->index(['rw'], 'idx_penduduk_rw');
            $table->index(['rt'], 'idx_penduduk_rt');
            $table->index(['alamat'], 'idx_penduduk_alamat');
            
            // Composite index for common filtering combinations
            $table->index(['rw', 'rt'], 'idx_penduduk_rw_rt');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('penduduk', function (Blueprint $table) {
            $table->dropIndex('idx_penduduk_nik');
            $table->dropIndex('idx_penduduk_nama');
            $table->dropIndex('idx_penduduk_no_kk');
            $table->dropIndex('idx_penduduk_rw');
            $table->dropIndex('idx_penduduk_rt');
            $table->dropIndex('idx_penduduk_alamat');
            $table->dropIndex('idx_penduduk_rw_rt');
        });
    }
};
