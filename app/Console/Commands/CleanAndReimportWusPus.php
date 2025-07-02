<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Sip4;
use App\Models\Posyandu;

class CleanAndReimportWusPus extends Command
{
    protected $signature = 'clean:wus-pus-data {posyandu_id?}';
    protected $description = 'Bersihkan data WUS/PUS yang salah import dan re-import dengan filter RW yang benar';

    public function handle()
    {
        $this->info('🧹 Memulai pembersihan data WUS/PUS...');

        $posyanduId = $this->argument('posyandu_id');

        if (!$posyanduId) {
            // Tampilkan daftar posyandu
            $posyandus = Posyandu::orderBy('posyandu_id')->get();
            
            $this->info('📋 Daftar Posyandu:');
            foreach ($posyandus as $posyandu) {
                $this->line("  ID: {$posyandu->posyandu_id} - {$posyandu->nama_posyandu}");
            }
            
            $posyanduId = $this->ask('Masukkan ID Posyandu yang akan dibersihkan');
        }

        $posyandu = Posyandu::find($posyanduId);
        if (!$posyandu) {
            $this->error('❌ Posyandu tidak ditemukan!');
            return Command::FAILURE;
        }

        $this->info("📍 Posyandu: {$posyandu->nama_posyandu}");

        // Hitung jumlah data yang akan dihapus
        $totalData = Sip4::where('posyandu_id', $posyanduId)->count();
        
        if ($totalData == 0) {
            $this->info('✅ Tidak ada data WUS/PUS untuk posyandu ini.');
            return Command::SUCCESS;
        }

        $this->warn("⚠️  Akan menghapus {$totalData} data WUS/PUS untuk posyandu ini.");
        
        if (!$this->confirm('Lanjutkan pembersihan data?')) {
            $this->info('Pembersihan dibatalkan.');
            return Command::SUCCESS;
        }

        // Hapus semua data SIP4 beserta data terkait untuk posyandu ini
        $this->info('🗑️  Menghapus data terkait...');
        
        // Ambil semua SIP4 untuk posyandu ini
        $sip4Records = Sip4::where('posyandu_id', $posyanduId)->get();
        
        $deletedCount = 0;
        foreach ($sip4Records as $sip4) {
            // Model event akan menangani cascade delete
            $sip4->delete();
            $deletedCount++;
        }
        
        $this->info("🗑️  {$deletedCount} data berhasil dihapus.");

        // Tanya apakah ingin re-import
        if ($this->confirm('Re-import data dengan filter RW yang benar?')) {
            $this->info('🔄 Memulai re-import...');
            $this->call('import:wus-pus-data', ['--posyandu_id' => $posyanduId, '--force' => true]);
        }

        $this->info('✅ Pembersihan selesai!');
        return Command::SUCCESS;
    }
}
