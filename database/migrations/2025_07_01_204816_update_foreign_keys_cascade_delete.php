<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update foreign key constraints to CASCADE DELETE for SIP2 related tables
        
        // Drop existing foreign key constraints
        Schema::table('sip2_imunisasi', function (Blueprint $table) {
            $table->dropForeign(['bayi_id']);
        });
        
        Schema::table('sip2_penimbangan', function (Blueprint $table) {
            $table->dropForeign(['bayi_id']);
        });
        
        // Check if other SIP2 related tables exist and update them
        if (Schema::hasTable('sip2_pelayanan')) {
            Schema::table('sip2_pelayanan', function (Blueprint $table) {
                $table->dropForeign(['bayi_id']);
            });
        }
        
        if (Schema::hasTable('sip2_pemberianasi')) {
            Schema::table('sip2_pemberianasi', function (Blueprint $table) {
                $table->dropForeign(['bayi_id']);
            });
        }
        
        if (Schema::hasTable('sip2_keteranganbalita')) {
            Schema::table('sip2_keteranganbalita', function (Blueprint $table) {
                $table->dropForeign(['bayi_id']);
            });
        }
        
        // Add new foreign key constraints with CASCADE DELETE
        Schema::table('sip2_imunisasi', function (Blueprint $table) {
            $table->foreign('bayi_id')->references('bayi_id')->on('sip_2')->onDelete('cascade');
        });
        
        Schema::table('sip2_penimbangan', function (Blueprint $table) {
            $table->foreign('bayi_id')->references('bayi_id')->on('sip_2')->onDelete('cascade');
        });
        
        if (Schema::hasTable('sip2_pelayanan')) {
            Schema::table('sip2_pelayanan', function (Blueprint $table) {
                $table->foreign('bayi_id')->references('bayi_id')->on('sip_2')->onDelete('cascade');
            });
        }
        
        if (Schema::hasTable('sip2_pemberianasi')) {
            Schema::table('sip2_pemberianasi', function (Blueprint $table) {
                $table->foreign('bayi_id')->references('bayi_id')->on('sip_2')->onDelete('cascade');
            });
        }
        
        if (Schema::hasTable('sip2_keteranganbalita')) {
            Schema::table('sip2_keteranganbalita', function (Blueprint $table) {
                $table->foreign('bayi_id')->references('bayi_id')->on('sip_2')->onDelete('cascade');
            });
        }
        
        // Do the same for SIP3 related tables
        if (Schema::hasTable('sip3_imunisasi')) {
            Schema::table('sip3_imunisasi', function (Blueprint $table) {
                $table->dropForeign(['balita_id']);
                $table->foreign('balita_id')->references('balita_id')->on('sip_3')->onDelete('cascade');
            });
        }
        
        if (Schema::hasTable('sip3_penimbangan')) {
            Schema::table('sip3_penimbangan', function (Blueprint $table) {
                $table->dropForeign(['balita_id']);
                $table->foreign('balita_id')->references('balita_id')->on('sip_3')->onDelete('cascade');
            });
        }
        
        if (Schema::hasTable('sip3_keteranganbalita')) {
            Schema::table('sip3_keteranganbalita', function (Blueprint $table) {
                $table->dropForeign(['balita_id']);
                $table->foreign('balita_id')->references('balita_id')->on('sip_3')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Restore original foreign key constraints without CASCADE
        
        Schema::table('sip2_imunisasi', function (Blueprint $table) {
            $table->dropForeign(['bayi_id']);
            $table->foreign('bayi_id')->references('bayi_id')->on('sip_2');
        });
        
        Schema::table('sip2_penimbangan', function (Blueprint $table) {
            $table->dropForeign(['bayi_id']);
            $table->foreign('bayi_id')->references('bayi_id')->on('sip_2');
        });
        
        // Revert other tables as needed...
    }
};
