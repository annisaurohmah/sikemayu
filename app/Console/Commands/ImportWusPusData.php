<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Penduduk;
use App\Models\Sip4;
use App\Models\Sip4Kontrasepsi;
use App\Models\Posyandu;
use App\Models\Dasawisma;
use Carbon\Carbon;

class ImportWusPusData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:wus-pus-data {--posyandu_id=} {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data WUS/PUS dari tabel penduduk (wanita usia 15-49 tahun)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Memulai import data WUS/PUS dari tabel penduduk...');

        $posyanduId = $this->option('posyandu_id');
        $force = $this->option('force');

        // Jika tidak ada posyandu_id, tampilkan daftar posyandu
        if (!$posyanduId) {
            $this->showPosyanduList();
            $posyanduId = $this->ask('Masukkan ID Posyandu');
            
            if (!$posyanduId) {
                $this->error('ID Posyandu wajib diisi!');
                return Command::FAILURE;
            }
        }

        // Validasi posyandu
        $posyandu = Posyandu::find($posyanduId);
        if (!$posyandu) {
            $this->error("Posyandu dengan ID {$posyanduId} tidak ditemukan!");
            return Command::FAILURE;
        }

        $this->info("📍 Posyandu: {$posyandu->nama_posyandu}");

        // Jika tidak force, konfirmasi dulu
        if (!$force) {
            if (!$this->confirm('Lanjutkan import data WUS/PUS?')) {
                $this->info('Import dibatalkan.');
                return Command::SUCCESS;
            }
        }

        // Ambil data penduduk wanita usia 15-49 tahun berdasarkan RW posyandu
        $this->info('🔍 Mencari data penduduk wanita usia 15-49 tahun...');
        
        // Extract RW dari nama posyandu (contoh: "Anggrek 01" -> "01")
        $namaPosyandu = $posyandu->nama_posyandu;
        $rwNumber = null;
        
        if (preg_match('/(\d+)$/', $namaPosyandu, $matches)) {
            $rwNumber = str_pad($matches[1], 2, '0', STR_PAD_LEFT); // Pad dengan 0 di depan (01, 02, dst)
        }
        
        if (!$rwNumber) {
            $this->error("❌ Tidak dapat menentukan RW dari nama posyandu: {$namaPosyandu}");
            return Command::FAILURE;
        }
        
        $this->info("🎯 Memfilter penduduk untuk RW: {$rwNumber}");
        
        $pendudukWanita = Penduduk::where('jenis_kelamin', 'P')
            ->whereRaw('TIMESTAMPDIFF(YEAR, tanggal_lahir, CURDATE()) BETWEEN 15 AND 49')
            ->where('rw', $rwNumber) // Filter berdasarkan RW yang sesuai
            ->get();

        if ($pendudukWanita->isEmpty()) {
            $this->warn("Tidak ada data penduduk wanita usia 15-49 tahun yang ditemukan untuk RW {$rwNumber}.");
            return Command::SUCCESS;
        }

        $this->info("📊 Ditemukan {$pendudukWanita->count()} wanita usia 15-49 tahun di RW {$rwNumber}");

        // Opsi tahapan KS dan jenis kontrasepsi
        $tahapanKsOptions = ['KS I', 'KS II', 'KS III', 'KS IV'];
        $jenisKontrasepsiOptions = ['Pil KB', 'Suntik KB', 'IUD', 'Implant', 'Kondom', 'MOW', 'MOP', 'Tidak menggunakan'];

        $importedCount = 0;
        $skippedCount = 0;

        foreach ($pendudukWanita as $penduduk) {
            // Cek apakah sudah ada di SIP4
            if (Sip4::where('nama', $penduduk->nama)->where('posyandu_id', $posyanduId)->exists()) {
                $skippedCount++;
                continue;
            }

            // Hitung umur
            $umur = Carbon::parse($penduduk->tanggal_lahir)->age;

            // Cari nama suami (kepala keluarga dari KK yang sama)
            $kepalaKeluarga = Penduduk::where('no_kk', $penduduk->no_kk)
                ->where('shdk', 'KEPALA KELUARGA')
                ->where('jenis_kelamin', 'L')
                ->first();

            $namaSuami = $kepalaKeluarga ? $kepalaKeluarga->nama : null;

            // Random data
            $tahapanKs = $tahapanKsOptions[array_rand($tahapanKsOptions)];
            $jenisKontrasepsi = $jenisKontrasepsiOptions[array_rand($jenisKontrasepsiOptions)];
            $jumlahAnakHidup = rand(0, 5);
            $ukuranLila = round(rand(200, 350) / 10, 1); // 20.0 - 35.0 cm
            $lebih235Cm = $ukuranLila >= 23.5;

            // Cari dasawisma berdasarkan RT penduduk atau random jika tidak ditemukan
            $dasawisma = Dasawisma::where('nama_dasawisma', 'LIKE', '%' . $penduduk->rt . '%')
                ->orWhere('nama_dasawisma', 'LIKE', '%RT ' . ltrim($penduduk->rt, '0') . '%')
                ->first();
                
            // Jika tidak ditemukan berdasarkan RT, ambil random dari semua dasawisma
            if (!$dasawisma) {
                $dasawismaList = Dasawisma::all();
                $dasawisma = $dasawismaList->isNotEmpty() ? $dasawismaList->random() : null;
            }

            // Buat data SIP4
            $sip4 = Sip4::create([
                'posyandu_id' => $posyanduId,
                'bulan' => date('n'), // Bulan saat ini
                'tahun' => date('Y'), // Tahun saat ini
                'nama' => $penduduk->nama,
                'umur' => $umur,
                'nama_suami' => $namaSuami,
                'tahapan_ks' => $tahapanKs,
                'dasawisma_id' => $dasawisma ? $dasawisma->dasawisma_id : null,
                'jumlah_anak_hidup' => $jumlahAnakHidup,
                'anak_meninggal_umur' => rand(0, 2) == 0 ? rand(1, 12) . ' bulan' : null, // Random, kadang null
                'ukuran_lila_cm' => $ukuranLila,
                'lebih_23_5_cm' => $lebih235Cm
            ]);

            // Tambahkan data kontrasepsi
            if ($jenisKontrasepsi !== 'Tidak menggunakan') {
                Sip4Kontrasepsi::create([
                    'wuspus_id' => $sip4->wuspus_id,
                    'jenis_kontrasepsi' => $jenisKontrasepsi,
                    'tanggal_mulai' => Carbon::now()->subDays(rand(30, 365))->format('Y-m-d') // Random tanggal dalam 1 tahun terakhir
                ]);
            }

            $importedCount++;
        }

        $this->info("✅ Import selesai!");
        $this->info("📝 {$importedCount} data berhasil diimport");
        $this->info("⏭️  {$skippedCount} data dilewati (sudah ada)");

        return Command::SUCCESS;
    }

    private function showPosyanduList()
    {
        $this->info('📋 Daftar Posyandu:');
        $posyandus = Posyandu::select('posyandu_id', 'nama_posyandu')->get();
        
        foreach ($posyandus as $posyandu) {
            $this->line("  ID: {$posyandu->posyandu_id} - {$posyandu->nama_posyandu}");
        }
        $this->line('');
    }
}
