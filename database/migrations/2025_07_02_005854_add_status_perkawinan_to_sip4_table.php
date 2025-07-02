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
        Schema::table('sip_4', function (Blueprint $table) {
            $table->enum('status_perkawinan', ['belum_menikah', 'menikah', 'janda'])->nullable()->after('nama_suami');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sip_4', function (Blueprint $table) {
            $table->dropColumn('status_perkawinan');
        });
    }
};
