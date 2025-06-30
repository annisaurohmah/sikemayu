<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use App\Models\Dasawisma;
use App\Models\Posyandu;
use App\Models\Rekapkegiatanposyandubulanan;
use App\Models\Sip1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sip2;
use App\Models\Sip2Penimbangan;
use App\Models\Sip2Imunisasi;
use App\Models\Sip3;
use App\Models\Sip4;
use App\Models\Sip5;
use App\Models\Sip2KeteranganBalita;
use App\Models\Sip5Penimbanganibuhamil;
use App\Models\Sip5Tablettambahdarah;
use App\Models\Sip5Vitaminaibuhamil;
use App\Models\Sip6;
use App\Models\DokumentasiKegiatan;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Traits\HasYearFilter;
use App\Traits\HasDataAccess;

class SIPController extends Controller
{
    use HasYearFilter, HasDataAccess;
    public function index($posyandu_id, Request $request)
    {
        // Check data access
        $access = $this->getDataAccess();
        $posyandu = Posyandu::find($posyandu_id);
        
        // Validate access
        if (!$access['can_access_all'] && $access['can_access_posyandu_only']) {
            if ($posyandu->nama_posyandu !== $access['posyandu']) {
                abort(403, 'Anda tidak memiliki akses ke posyandu ini');
            }
        }
        
        // Ambil tahun dari parameter URL atau gunakan tahun sekarang sebagai default
        $tahun = $this->getSelectedYear($request);
        
        //sip format 1
        $format1 = Sip1::where('posyandu_id', $posyandu_id)
            ->where('tahun', $tahun)
            ->get();
        $posyandu = Posyandu::find($posyandu_id);

        // Get data for dropdowns
        $dasawismaList = Dasawisma::all();

        // Filter bayi (0-12 bulan) dan balita (1-5 tahun) berdasarkan umur dari tanggal lahir
        $today = now();
        
        // Ambil nama bayi yang sudah terdaftar di SIP Format 2 untuk posyandu ini (filter berdasarkan tahun lahir)
        $registeredBayi = Sip2::where('posyandu_id', $posyandu_id)
            ->whereYear('tgl_lahir', $tahun)
            ->pluck('nama_bayi')->toArray();
        
        // Ambil nama balita yang sudah terdaftar di SIP Format 3 untuk posyandu ini (filter berdasarkan tahun lahir)
        $registeredBalita = Sip3::where('posyandu_id', $posyandu_id)
            ->whereYear('tgl_lahir', $tahun)
            ->pluck('nama_balita')->toArray();
        
        // Filter bayi yang belum terdaftar di SIP Format 2
        $bayiList_master = Anak::whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, ?) <= 12', [$today])
            ->whereNotIn('nama_lengkap', $registeredBayi)
            ->get();
            
        // Filter balita yang belum terdaftar di SIP Format 3
        $balitaList_master = Anak::whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, ?) > 12 AND TIMESTAMPDIFF(YEAR, tanggal_lahir, ?) <= 5', [$today, $today])
            ->whereNotIn('nama_lengkap', $registeredBalita)
            ->get();

        //sip format 2 (filter berdasarkan tahun lahir)
        $bayiList = Sip2::with([
            'penimbangan',
            'asi',
            'pelayanan',
            'imunisasi',
            'keteranganBalita',
            'dasawisma',
        ])->where('posyandu_id', $posyandu_id)
          ->whereYear('tgl_lahir', $tahun)
          ->get();

        //sip format 3 (filter berdasarkan tahun lahir)
        $balitaList = Sip3::with([
            'penimbangan',
            'pelayanan',
            'imunisasi',
            'keteranganBalita',
            'dasawisma',
        ])->where('posyandu_id', $posyandu_id)
          ->whereYear('tgl_lahir', $tahun)
          ->get();

        //sip format 4 (filter berdasarkan tahun)
        $wuspusList = Sip4::with([
            'imunisasitt',
            'kontrasepsi',
            'penggantianKontrasepsi',
            'dasawisma',
        ])->where('posyandu_id', $posyandu_id)
          ->where('tahun', $tahun)
          ->get();

        //sip format 5 (filter berdasarkan tahun)
        $ibuHamilList = Sip5::with([
            'imunisasittIbuHamil',
            'penimbanganIbuHamil',
            'tabletTambahDarah',
            'vitaminIbuHamil',
            'dasawisma',
        ])->where('posyandu_id', $posyandu_id)
          ->whereYear('tanggal_pendaftaran', $tahun)
          ->get();

        //sip format 6
        // $tahun = now()->year; // Hapus ini karena sudah diambil dari parameter

        for ($bulan = 1; $bulan <= 12; $bulan++) {
            // Tanggal acuan untuk bulan dan tahun yang dipilih
            $tanggalAcuan = Carbon::create($tahun, $bulan, 1);
            
            // Hitung bayi 0-12 bulan pada bulan tertentu di tahun yang dipilih
            // Hanya menghitung bayi yang terdaftar dan aktif pada periode tersebut
            $bayi012 = Sip2::whereRaw("TIMESTAMPDIFF(MONTH, tgl_lahir, ?) <= 12", [$tanggalAcuan])
                ->whereRaw("TIMESTAMPDIFF(MONTH, tgl_lahir, ?) >= 0", [$tanggalAcuan])
                ->where('posyandu_id', $posyandu_id)
                ->whereYear('tgl_lahir', '>=', $tahun - 1) // Filter: hanya bayi lahir maksimal 1 tahun sebelum tahun dipilih
                ->whereYear('tgl_lahir', '<=', $tahun) // Filter: hanya bayi lahir sampai tahun dipilih
                ->count();

            // Hitung balita 1-5 tahun pada bulan tertentu di tahun yang dipilih
            // Hanya menghitung balita yang terdaftar dan aktif pada periode tersebut
            $balita15 = Sip3::whereRaw("TIMESTAMPDIFF(MONTH, tgl_lahir, ?) > 12 AND TIMESTAMPDIFF(YEAR, tgl_lahir, ?) <= 5", [
                $tanggalAcuan,
                $tanggalAcuan
            ])->where('posyandu_id', $posyandu_id)
              ->whereYear('tgl_lahir', '>=', $tahun - 5) // Filter: hanya balita lahir maksimal 5 tahun sebelum tahun dipilih
              ->whereYear('tgl_lahir', '<=', $tahun) // Filter: hanya balita lahir sampai tahun dipilih
              ->count();

            $jumlahBayiLahir = Sip1::whereMonth('tgl_lahir', $bulan)
                ->whereYear('tgl_lahir', $tahun)
                ->where('posyandu_id', $posyandu_id)
                ->count();
            $jumlahBayiMeninggal = Sip1::whereMonth('tgl_meninggal_bayi', $bulan)
                ->whereYear('tgl_meninggal_bayi', $tahun)
                ->where('posyandu_id', $posyandu_id)
                ->count();

            $jumlahIbuHamil = Sip5::whereMonth('tanggal_pendaftaran', $bulan)
                ->whereYear('tanggal_pendaftaran', $tahun)
                ->where('posyandu_id', $posyandu_id)
                ->count();

            Sip6::updateOrCreate(
                ['bulan' => $bulan, 'tahun' => $tahun, 'posyandu_id' => $posyandu_id],
                [
                    'posyandu_id' => $posyandu_id,
                    'jumlah_lahir' => $jumlahBayiLahir,
                    'jumlah_meninggal' => $jumlahBayiMeninggal,
                    'bayi_0_12_bulan' => $bayi012,
                    'balita_1_5_tahun' => $balita15,
                ]
            );
        }

        // Retrieve the latest SIP6 record for the current year and posyandu
        $sip6 = Sip6::where('tahun', $tahun)
            ->where('posyandu_id', $posyandu_id)
            ->get();

        //sip format 7
        for ($bulan = 1; $bulan <= 12; $bulan++) {

            $jumlahIbuHamil = Sip5::whereYear('tanggal_pendaftaran', $tahun)->whereMonth('tanggal_pendaftaran', $bulan)
                ->where('posyandu_id', $posyandu_id)
                ->count();

            $jumlahIbuMemeriksa = Sip5Penimbanganibuhamil::where('bulan', $bulan)->join('sip_5', 'sip5_penimbanganibuhamil.ibu_hamil_id', '=', 'sip_5.ibu_hamil_id')
                ->where('tahun', $tahun)
                ->distinct('sip5_penimbanganibuhamil.ibu_hamil_id') // kalau ada kolom ibu_id
                ->where('sip_5.posyandu_id', $posyandu_id)
                ->count('ibu_hamil_id');

            $jumlahIbuMendapatFE = Sip5Tablettambahdarah::whereMonth('tanggal_diberikan', $bulan)->join('sip_5', 'sip5_tablettambahdarah.ibu_hamil_id', '=', 'sip_5.ibu_hamil_id')
                ->whereYear('tanggal_diberikan', $tahun)
                ->distinct('sip5_tablettambahdarah.ibu_hamil_id') // kalau ada kolom ibu_id
                ->where('sip_5.posyandu_id', $posyandu_id)
                ->count('ibu_hamil_id');

            $jumlahIbuMendapatVitA = Sip5Vitaminaibuhamil::whereMonth('tanggal_pemberian', $bulan)->join('sip_5', 'sip5_vitaminaibuhamil.ibu_hamil_id', '=', 'sip_5.ibu_hamil_id')
                ->whereYear('tanggal_pemberian', $tahun)
                ->distinct('sip5_vitaminaibuhamil.ibu_hamil_id') // kalau ada kolom ibu_id
                ->where('sip_5.posyandu_id', $posyandu_id)
                ->count('ibu_hamil_id');

            $jumlahPesertaKondom = DB::table('sip_4')
                ->join('sip4_kontrasepsi', 'sip_4.wuspus_id', '=', 'sip4_kontrasepsi.wuspus_id')
                ->where('sip_4.bulan', $bulan)
                ->where('sip_4.tahun', $tahun)
                ->where('sip4_kontrasepsi.jenis_kontrasepsi', 'Kondom')
                ->where('sip_4.posyandu_id', $posyandu_id)
                ->count();

            $jumlahPesertaPil = DB::table('sip_4')
                ->join('sip4_kontrasepsi', 'sip_4.wuspus_id', '=', 'sip4_kontrasepsi.wuspus_id')
                ->where('sip_4.bulan', $bulan)
                ->where('sip_4.tahun', $tahun)
                ->where('sip4_kontrasepsi.jenis_kontrasepsi', 'Pil')
                ->where('sip_4.posyandu_id', $posyandu_id)
                ->count();
            $jumlahPesertaSuntik = DB::table('sip_4')
                ->join('sip4_kontrasepsi', 'sip_4.wuspus_id', '=', 'sip4_kontrasepsi.wuspus_id')
                ->where('sip_4.bulan', $bulan)
                ->where('sip_4.tahun', $tahun)
                ->where('sip4_kontrasepsi.jenis_kontrasepsi', 'Suntik')
                ->where('sip_4.posyandu_id', $posyandu_id)
                ->count();

            $jumlahBalita_S = (Sip3::where('posyandu_id', $posyandu_id)
                ->count())+(Sip2::where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBalita_K = (Sip3::where('posyandu_id', $posyandu_id)
                ->count())+(Sip2::where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBalita_D = (Sip3::where('posyandu_id', $posyandu_id)->join('sip3_penimbangan', 'sip_3.balita_id', '=', 'sip3_penimbangan.balita_id')
                ->where('sip3_penimbangan.bulan', $bulan)
                ->where('sip3_penimbangan.tahun', $tahun)
                ->where(function ($query) {
                    $query->whereNotNull('bb_hasil_penimbangan')
                        ->orWhereNotNull('tb_hasil_penimbangan');
                })
                ->count())+(Sip2::where('posyandu_id', $posyandu_id)->join('sip2_penimbangan', 'sip_2.bayi_id', '=', 'sip2_penimbangan.bayi_id')
                ->where('sip2_penimbangan.bulan', $bulan)
                ->where('sip2_penimbangan.tahun', $tahun)
                ->where(function ($query) {
                    $query->whereNotNull('bb_hasil_penimbangan')
                        ->orWhereNotNull('tb_hasil_penimbangan');
                })
                ->count());

            // Ambil semua penimbangan bulan sekarang
            $dataBulanIniBayi = Sip2::where('posyandu_id', $posyandu_id)
                ->join('sip2_penimbangan', 'sip_2.bayi_id', '=', 'sip2_penimbangan.bayi_id')
                ->where('sip2_penimbangan.bulan', $bulan)
                ->where('sip2_penimbangan.tahun', $tahun)
                ->get();
            
            $dataBulanIniBalita = Sip3::where('posyandu_id', $posyandu_id)
                ->join('sip3_penimbangan', 'sip_3.balita_id', '=', 'sip3_penimbangan.balita_id')
                ->where('sip3_penimbangan.bulan', $bulan)
                ->where('sip3_penimbangan.tahun', $tahun)
                ->get();

            

            // Hitung jumlah yang naik BB
            $jumlahBalitaN_N = $dataBulanIniBalita->filter(function ($item) use ($bulan, $tahun) {
                // Cek bulan sebelumnya
                $prevBulan = $bulan - 1;
                $prevTahun = $tahun;
                if ($bulan == 1) {
                    $prevBulan = 12;
                    $prevTahun = $tahun - 1;
                }

                // Ambil data bulan sebelumnya dari balita yang sama
                $prev = DB::table('sip_3')
                    ->join('sip3_penimbangan', 'sip_3.balita_id', '=', 'sip3_penimbangan.balita_id')
                    ->where('sip_3.balita_id', $item->balita_id)
                    ->where('sip3_penimbangan.bulan', $prevBulan)
                    ->where('sip3_penimbangan.tahun', $prevTahun)
                    ->first();
                    

                // Jika ada data sebelumnya dan BB naik
                return $prev && $item->bb_hasil_penimbangan > $prev->bb_hasil_penimbangan;
            })->count();

            $jumlahBayiN_N = $dataBulanIniBayi->filter(function ($item) use ($bulan, $tahun) {
                // Cek bulan sebelumnya
                $prevBulan = $bulan - 1;
                $prevTahun = $tahun;
                if ($bulan == 1) {
                    $prevBulan = 12;
                    $prevTahun = $tahun - 1;
                }

                // Ambil data bulan sebelumnya dari balita yang sama
                $prev = DB::table('sip_2')
                    ->join('sip2_penimbangan', 'sip_2.bayi_id', '=', 'sip2_penimbangan.bayi_id')
                    ->where('sip_2.bayi_id', $item->bayi_id)
                    ->where('sip2_penimbangan.bulan', $prevBulan)
                    ->where('sip2_penimbangan.tahun', $prevTahun)
                    ->first();
                    

                // Jika ada data sebelumnya dan BB naik
                return $prev && $item->bb_hasil_penimbangan > $prev->bb_hasil_penimbangan;
            })->count();

            $jumlahBalita_N = $jumlahBalitaN_N + $jumlahBayiN_N;



            $jumlahBayiBalitaMendapatVitA = (DB::table('sip_2')
                ->join('sip2_pelayanan', 'sip_2.bayi_id', '=', 'sip2_pelayanan.bayi_id')
                ->whereMonth('sip2_pelayanan.tanggal_diberikan', $bulan)
                ->whereYear('sip2_pelayanan.tanggal_diberikan', $tahun)
                ->where('sip2_pelayanan.jenis', 'Vitamin A')
                ->where('posyandu_id', $posyandu_id)
                ->count()) + (DB::table('sip_3')
                ->join('sip3_pelayanan', 'sip_3.balita_id', '=', 'sip3_pelayanan.balita_id')
                ->whereMonth('sip3_pelayanan.tanggal_diberikan', $bulan)
                ->whereYear('sip3_pelayanan.tanggal_diberikan', $tahun)
                ->where('sip3_pelayanan.jenis', 'Vitamin A')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBayiHBNol = (DB::table('sip_2')
                ->join('sip2_imunisasi', 'sip_2.bayi_id', '=', 'sip2_imunisasi.bayi_id')
                ->whereMonth('sip2_imunisasi.tanggal_diberikan', $bulan)
                ->whereYear('sip2_imunisasi.tanggal_diberikan', $tahun)
                ->where('sip2_imunisasi.jenis', 'HB Nol')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBayiBCG = (DB::table('sip_2')
                ->join('sip2_imunisasi', 'sip_2.bayi_id', '=', 'sip2_imunisasi.bayi_id')
                ->whereMonth('sip2_imunisasi.tanggal_diberikan', $bulan)
                ->whereYear('sip2_imunisasi.tanggal_diberikan', $tahun)
                ->where('sip2_imunisasi.jenis', 'BCG')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBayi_PolioI = (DB::table('sip_2')
                ->join('sip2_imunisasi', 'sip_2.bayi_id', '=', 'sip2_imunisasi.bayi_id')
                ->whereMonth('sip2_imunisasi.tanggal_diberikan', $bulan)
                ->whereYear('sip2_imunisasi.tanggal_diberikan', $tahun)
                ->where('sip2_imunisasi.jenis', 'Polio I')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBayi_PolioII = (DB::table('sip_2')
                ->join('sip2_imunisasi', 'sip_2.bayi_id', '=', 'sip2_imunisasi.bayi_id')
                ->whereMonth('sip2_imunisasi.tanggal_diberikan', $bulan)
                ->whereYear('sip2_imunisasi.tanggal_diberikan', $tahun)
                ->where('sip2_imunisasi.jenis', 'Polio II')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBayi_PolioIII = (DB::table('sip_2')
                ->join('sip2_imunisasi', 'sip_2.bayi_id', '=', 'sip2_imunisasi.bayi_id')
                ->whereMonth('sip2_imunisasi.tanggal_diberikan', $bulan)
                ->whereYear('sip2_imunisasi.tanggal_diberikan', $tahun)
                ->where('sip2_imunisasi.jenis', 'Polio III')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBayi_PolioIV = (DB::table('sip_2')
                ->join('sip2_imunisasi', 'sip_2.bayi_id', '=', 'sip2_imunisasi.bayi_id')
                ->whereMonth('sip2_imunisasi.tanggal_diberikan', $bulan)
                ->whereYear('sip2_imunisasi.tanggal_diberikan', $tahun)
                ->where('sip2_imunisasi.jenis', 'Polio IV')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBayi_DPTI = (DB::table('sip_2')
                ->join('sip2_imunisasi', 'sip_2.bayi_id', '=', 'sip2_imunisasi.bayi_id')
               ->whereMonth('sip2_imunisasi.tanggal_diberikan', $bulan)
                ->whereYear('sip2_imunisasi.tanggal_diberikan', $tahun)
                ->where('sip2_imunisasi.jenis', 'DPT/HB I')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBayi_DPTII = (DB::table('sip_2')
                ->join('sip2_imunisasi', 'sip_2.bayi_id', '=', 'sip2_imunisasi.bayi_id')
               ->whereMonth('sip2_imunisasi.tanggal_diberikan', $bulan)
                ->whereYear('sip2_imunisasi.tanggal_diberikan', $tahun)
                ->where('sip2_imunisasi.jenis', 'DPT/HB II')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBayi_DPTIII = (DB::table('sip_2')
                ->join('sip2_imunisasi', 'sip_2.bayi_id', '=', 'sip2_imunisasi.bayi_id')
               ->whereMonth('sip2_imunisasi.tanggal_diberikan', $bulan)
                ->whereYear('sip2_imunisasi.tanggal_diberikan', $tahun)
                ->where('sip2_imunisasi.jenis', 'DPT/HB III')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBayi_Campak = (DB::table('sip_2')
                ->join('sip2_imunisasi', 'sip_2.bayi_id', '=', 'sip2_imunisasi.bayi_id')
               ->whereMonth('sip2_imunisasi.tanggal_diberikan', $bulan)
                ->whereYear('sip2_imunisasi.tanggal_diberikan', $tahun)
                ->where('sip2_imunisasi.jenis', 'Campak')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahImunisasiTT_I = (DB::table('sip_4')
                ->join('sip4_imunisasitt', 'sip_4.wuspus_id', '=', 'sip4_imunisasitt.wuspus_id')
                ->whereMonth('sip4_imunisasitt.tanggal_pemberian', $bulan)
                ->whereYear('sip4_imunisasitt.tanggal_pemberian', $tahun)
                ->where('sip_4.posyandu_id', $posyandu_id)
                ->where('sip4_imunisasitt.tt_ke', 'I')
                ->count()) + (DB::table('sip_5')
                ->join('sip5_imunisasittibuhamil', 'sip_5.ibu_hamil_id', '=', 'sip5_imunisasittibuhamil.ibu_hamil_id')
                ->whereMonth('sip5_imunisasittibuhamil.tanggal_pemberian', $bulan)
                ->whereYear('sip5_imunisasittibuhamil.tanggal_pemberian', $tahun)
                ->where('sip5_imunisasittibuhamil.tt_ke', 'I')
                ->where('sip_5.posyandu_id', $posyandu_id)
                ->count());

            $jumlahImunisasiTT_II = (DB::table('sip_4')
                ->join('sip4_imunisasitt', 'sip_4.wuspus_id', '=', 'sip4_imunisasitt.wuspus_id')
                ->whereMonth('sip4_imunisasitt.tanggal_pemberian', $bulan)
                ->whereYear('sip4_imunisasitt.tanggal_pemberian', $tahun)
                ->where('sip_4.posyandu_id', $posyandu_id)
                ->where('sip4_imunisasitt.tt_ke', 'II')
                ->count()) + (DB::table('sip_5')
                ->join('sip5_imunisasittibuhamil', 'sip_5.ibu_hamil_id', '=', 'sip5_imunisasittibuhamil.ibu_hamil_id')
                ->whereMonth('sip5_imunisasittibuhamil.tanggal_pemberian', $bulan)
                ->whereYear('sip5_imunisasittibuhamil.tanggal_pemberian', $tahun)
                ->where('sip5_imunisasittibuhamil.tt_ke', 'II')
                ->where('sip_5.posyandu_id', $posyandu_id)
                ->count());

            $jumlahImunisasiTT_III = (DB::table('sip_4')
                ->join('sip4_imunisasitt', 'sip_4.wuspus_id', '=', 'sip4_imunisasitt.wuspus_id')
                ->whereMonth('sip4_imunisasitt.tanggal_pemberian', $bulan)
                ->whereYear('sip4_imunisasitt.tanggal_pemberian', $tahun)
                ->where('sip_4.posyandu_id', $posyandu_id)
                ->where('sip4_imunisasitt.tt_ke', 'III')
                ->count()) + (DB::table('sip_5')
                ->join('sip5_imunisasittibuhamil', 'sip_5.ibu_hamil_id', '=', 'sip5_imunisasittibuhamil.ibu_hamil_id')
                ->whereMonth('sip5_imunisasittibuhamil.tanggal_pemberian', $bulan)
                ->whereYear('sip5_imunisasittibuhamil.tanggal_pemberian', $tahun)
                ->where('sip5_imunisasittibuhamil.tt_ke', 'III')
                ->where('sip_5.posyandu_id', $posyandu_id)
                ->count());

            $jumlahImunisasiTT_IV = (DB::table('sip_4')
                ->join('sip4_imunisasitt', 'sip_4.wuspus_id', '=', 'sip4_imunisasitt.wuspus_id')
                ->whereMonth('sip4_imunisasitt.tanggal_pemberian', $bulan)
                ->whereYear('sip4_imunisasitt.tanggal_pemberian', $tahun)
                ->where('sip_4.posyandu_id', $posyandu_id)
                ->where('sip4_imunisasitt.tt_ke', 'IV')
                ->count()) + (DB::table('sip_5')
                ->join('sip5_imunisasittibuhamil', 'sip_5.ibu_hamil_id', '=', 'sip5_imunisasittibuhamil.ibu_hamil_id')
                ->whereMonth('sip5_imunisasittibuhamil.tanggal_pemberian', $bulan)
                ->whereYear('sip5_imunisasittibuhamil.tanggal_pemberian', $tahun)
                ->where('sip5_imunisasittibuhamil.tt_ke', 'IV')
                ->where('sip_5.posyandu_id', $posyandu_id)
                ->count());

            $jumlahImunisasiTT_V = (DB::table('sip_4')
                ->join('sip4_imunisasitt', 'sip_4.wuspus_id', '=', 'sip4_imunisasitt.wuspus_id')
                ->whereMonth('sip4_imunisasitt.tanggal_pemberian', $bulan)
                ->whereYear('sip4_imunisasitt.tanggal_pemberian', $tahun)
                ->where('sip_4.posyandu_id', $posyandu_id)
                ->where('sip4_imunisasitt.tt_ke', 'V')
                ->count()) + (DB::table('sip_5')
                ->join('sip5_imunisasittibuhamil', 'sip_5.ibu_hamil_id', '=', 'sip5_imunisasittibuhamil.ibu_hamil_id')
                ->whereMonth('sip5_imunisasittibuhamil.tanggal_pemberian', $bulan)
                ->whereYear('sip5_imunisasittibuhamil.tanggal_pemberian', $tahun)
                ->where('sip5_imunisasittibuhamil.tt_ke', 'V')
                ->where('sip_5.posyandu_id', $posyandu_id)
                ->count());

            $jumlahBalitaOralit = DB::table('sip_3')
                ->join('sip3_pelayanan', 'sip_3.balita_id', '=', 'sip3_pelayanan.balita_id')
                ->whereMonth('sip3_pelayanan.tanggal_diberikan', $bulan)
                ->whereYear('sip3_pelayanan.tanggal_diberikan', $tahun)
                ->where('sip_3.posyandu_id', $posyandu_id)
                ->where('sip3_pelayanan.jenis', 'Oralit')
                ->count();

            
            Rekapkegiatanposyandubulanan::updateOrCreate(
                ['bulan' => $bulan, 'tahun' => $tahun, 'posyandu_id' => $posyandu_id],
                [
                    'posyandu_id' => $posyandu_id,
                    'jml_ibu_hamil' => $jumlahIbuHamil,
                    'ibu_periksa' => $jumlahIbuMemeriksa,
                    'ibu_mendapat_fe' => $jumlahIbuMendapatFE,
                    'ibu_nifas_dapat_vit_a' => $jumlahIbuMendapatVitA,
                    'kb_kondom' => $jumlahPesertaKondom,
                    'kb_pil' =>  $jumlahPesertaPil,
                    'kb_suntik' =>   $jumlahPesertaSuntik,
                    'balita_sasaran' =>  $jumlahBalita_S,
                    'balita_punya_buku' => $jumlahBalita_K,
                    'balita_ditimbang' => $jumlahBalita_D,
                    'balita_naik' => $jumlahBalita_N,
                    'bayi_balita_vit_a' => $jumlahBayiBalitaMendapatVitA,
                    'imunisasi_hb0' => $jumlahBayiHBNol,
                    'imunisasi_bcg' =>  $jumlahBayiBCG,
                    'imunisasi_polio_i' =>  $jumlahBayi_PolioI,
                    'imunisasi_polio_ii' =>  $jumlahBayi_PolioII,
                    'imunisasi_polio_iii' => $jumlahBayi_PolioIII,
                    'imunisasi_polio_iv' => $balita15,
                    'imunisasi_dpt_hb_i' => $jumlahBayi_DPTI,
                    'imunisasi_dpt_hb_ii' => $jumlahBayi_DPTII,
                    'imunisasi_dpt_hb_iii' => $jumlahBayi_DPTIII,
                    'imunisasi_campak' => $jumlahBayi_Campak,
                    'tt_i' => $jumlahImunisasiTT_I,
                    'tt_ii' => $jumlahImunisasiTT_II,
                    'tt_iii' =>  $jumlahImunisasiTT_III,
                    'tt_iv' => $jumlahImunisasiTT_IV,
                    'tt_v' => $jumlahImunisasiTT_V,
                    'balita_diare_dapat_oralit' => $jumlahBalitaOralit,
                ]

            );
        }

        // \Log::info("Selesai generate data rekap untuk posyandu_id: $posyandu_id");

        $sip7 = Rekapkegiatanposyandubulanan::where('tahun', $tahun)
            ->where('posyandu_id', $posyandu_id)
            ->get();

        // Data untuk dashboard SKDN (filter berdasarkan tahun yang dipilih)
        $rekap = Rekapkegiatanposyandubulanan::where('posyandu_id', $posyandu_id)
            ->where('tahun', $tahun)
            ->orderBy('bulan', 'asc')
            ->get();

        // Debug: Log jumlah data rekap yang ditemukan
        // \Log::info("Posyandu ID: $posyandu_id, Jumlah data rekap: " . $rekap->count());

        // Siapkan label dan data persentase untuk dashboard
        $labels = [];
        $persenK = [];
        $persenD = [];
        $persenN = [];

        // Data absolut untuk chart SKDN
        $dataS = [];
        $dataK = [];
        $dataD = [];
        $dataN = [];

        // Jika tidak ada data rekap, buat data dummy untuk menghindari chart kosong
        if ($rekap->isEmpty()) {
            // \Log::warning("Tidak ada data rekap untuk posyandu_id: $posyandu_id");
            // Buat data dummy untuk 12 bulan terakhir
            for ($i = 11; $i >= 0; $i--) {
                $bulan = now()->subMonths($i)->month;
                $tahun = now()->subMonths($i)->year;
                
                $bulanNama = [
                    1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
                    7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
                ];
                
                $labels[] = $bulanNama[$bulan] . '-' . substr($tahun, -2);
                $persenK[] = 0;
                $persenD[] = 0;
                $persenN[] = 0;
                $dataS[] = 0;
                $dataK[] = 0;
                $dataD[] = 0;
                $dataN[] = 0;
            }
        }

        foreach ($rekap as $item) {
            $s = $item->balita_sasaran ?: 1; // hindari pembagi 0

            // Format label yang lebih pendek: "Jan-25" atau "Feb-25"
            $bulanNama = [
                1 => 'Jan', 2 => 'Feb', 3 => 'Mar', 4 => 'Apr', 5 => 'Mei', 6 => 'Jun',
                7 => 'Jul', 8 => 'Agu', 9 => 'Sep', 10 => 'Okt', 11 => 'Nov', 12 => 'Des'
            ];
            $labels[] = $bulanNama[$item->bulan] . '-' . substr($item->tahun, -2);

            $persenK[] = round(($item->balita_punya_buku / $s) * 100, 1);
            $persenD[] = round(($item->balita_ditimbang / $s) * 100, 1);
            $persenN[] = round(($item->balita_naik / $s) * 100, 1);

            // Data absolut
            $dataS[] = $item->balita_sasaran ?? 0;
            $dataK[] = $item->balita_punya_buku ?? 0;
            $dataD[] = $item->balita_ditimbang ?? 0;
            $dataN[] = $item->balita_naik ?? 0;
        }

        //dokumentasi kegiatan (filter berdasarkan tahun)
        $dokumentasiList = DokumentasiKegiatan::where('posyandu_id', $posyandu_id)
            ->whereYear('tanggal', $tahun)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('sip.index', compact('posyandu_id', 'posyandu', 'format1', 'bayiList', 'balitaList', 'wuspusList', 'ibuHamilList', 'sip6', 'sip7', 'dasawismaList', 'bayiList_master', 'balitaList_master', 'labels', 'persenK', 'persenD', 'persenN', 'dataS', 'dataK', 'dataD', 'dataN', 'tahun', 'dokumentasiList'));
    }

    // SIP1 CRUD Methods
    public function storeSip1(Request $request)
    {
        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'tahun' => 'required|integer|min:1900|max:2100',
            'bulan' => 'required|string|max:20',
            'nama_ibu' => 'required|string|max:255',
            'nama_bapak' => 'required|string|max:255',
            'nama_bayi' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'tgl_meninggal_ibu' => 'nullable|date',
            'tgl_meninggal_bayi' => 'nullable|date',
            'keterangan' => 'nullable|string'
        ]);

        Sip1::create($request->all());

        return redirect()->route('sip.index', $request->posyandu_id)->with('success', 'Data SIP Format 1 berhasil ditambahkan.')->with('activeTab', 'format1');
    }

    public function updateSip1(Request $request, $id)
    {
        $sip1 = Sip1::findOrFail($id);

        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'tahun' => 'required|integer|min:1900|max:2100',
            'bulan' => 'required|string|max:20',
            'nama_ibu' => 'required|string|max:255',
            'nama_bapak' => 'required|string|max:255',
            'nama_bayi' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'tgl_meninggal_ibu' => 'nullable|date',
            'tgl_meninggal_bayi' => 'nullable|date',
            'keterangan' => 'nullable|string'
        ]);

        $sip1->update($request->all());

        return redirect()->route('sip.index', $request->posyandu_id)->with('success', 'Data SIP Format 1 berhasil diperbarui.')->with('activeTab', 'format1');
    }

    public function deleteSip1($id)
    {
        $sip1 = Sip1::findOrFail($id);
        $posyandu_id = $sip1->posyandu_id;
        $nama_bayi = $sip1->nama_bayi;

        $sip1->delete();

        return redirect()->route('sip.index', $posyandu_id)->with('success', 'Data SIP Format 1 untuk ' . $nama_bayi . ' berhasil dihapus.')->with('activeTab', 'format1');
    }

    // SIP2 CRUD Methods
    public function storeSip2(Request $request)
    {
        // Debug: Log semua data yang diterima
        /*
        \Log::info('SIP2 Store Request Data:', [
            'nama_bayi' => $request->nama_bayi,
            'nama_bayi_manual' => $request->nama_bayi_manual,
            'tgl_lahir' => $request->tgl_lahir,
            'tgl_lahir_manual' => $request->tgl_lahir_manual,
            'all_data' => $request->all()
        ]);
        */
        
        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'nama_bayi' => 'nullable|string|max:255', // Bisa kosong jika menggunakan manual
            'nama_bayi_manual' => 'nullable|string|max:255', // Bisa kosong jika menggunakan database
            'tgl_lahir' => 'nullable|date', // Bisa dari input manual atau otomatis dari database
            'tgl_lahir_manual' => 'nullable|date', // Bisa kosong jika menggunakan database
            'bbl_kg' => 'required|numeric|min:0',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'dasawisma_id' => 'required|exists:dasawisma,dasawisma_id'
        ]);
        
        // Pastikan ada minimal satu nama bayi (dari database atau manual)
        if (!$request->nama_bayi && !$request->nama_bayi_manual) {
            return redirect()->back()->with('error', 'Nama bayi harus diisi, baik dari database atau input manual.');
        }

        $data = $request->all();

        // Jika tgl_lahir tidak dikirim dari form (input dari database), ambil dari master data
        if (!$request->tgl_lahir && !$request->tgl_lahir_manual) {
            $anak = Anak::where('nama_lengkap', $request->nama_bayi)->first();
            if (!$anak) {
                return redirect()->back()->with('error', 'Data anak tidak ditemukan di database master. Silakan gunakan input manual atau pastikan data anak sudah terdaftar.');
            }
            $data['tgl_lahir'] = $anak->tanggal_lahir;
        } else {
            // Prioritas: tgl_lahir_manual (dari input manual) atau tgl_lahir (dari hidden field)
            $tanggalLahir = $request->tgl_lahir_manual ?: $request->tgl_lahir;
            
            // Validasi bahwa usia bayi sesuai (0-12 bulan)
            $tglLahir = \Carbon\Carbon::parse($tanggalLahir);
            $monthsDiff = $tglLahir->diffInMonths(now());
            
            if ($monthsDiff > 12) {
                return redirect()->back()->with('error', 'Tanggal lahir tidak sesuai untuk kategori bayi (harus 0-12 bulan).');
            }
            
            $data['tgl_lahir'] = $tanggalLahir;
        }
        
        // Prioritas nama: nama_bayi_manual (input manual) atau nama_bayi (dari database/hidden field)
        $data['nama_bayi'] = $request->nama_bayi_manual ?: $request->nama_bayi;

        Sip2::create($data);

        return redirect()->route('sip.index', $request->posyandu_id)->with('success', 'Data SIP Format 2 berhasil ditambahkan. Silakan edit untuk menambah data penimbangan dan imunisasi.')->with('activeTab', 'format2');
    }

    public function updateSip2(Request $request, $id)
    {
        $sip2 = Sip2::findOrFail($id);

        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'nama_bayi' => 'required|string|max:255',
            'bbl_kg' => 'required|numeric|min:0',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'dasawisma_id' => 'required|exists:dasawisma,dasawisma_id',
            // Validasi data penimbangan (opsional)
            'tb_penimbangan.*' => 'nullable|numeric|min:0',
            'bb_penimbangan.*' => 'nullable|numeric|min:0',
            // Validasi data ASI, pelayanan, imunisasi (opsional)
            'asi.*' => 'nullable|date|before_or_equal:today',
            'pelayanan.*' => 'nullable|date|before_or_equal:today',
            'imunisasi.*' => 'nullable|date|before_or_equal:today',
            'tanggal_meninggal' => 'nullable|date|before_or_equal:today',
            'catatan' => 'nullable|string|max:1000'
        ]);

        try {
            DB::beginTransaction();

            // Ambil tanggal lahir dari data anak master berdasarkan nama
            $anak = Anak::where('nama_lengkap', $request->nama_bayi)->first();
            if (!$anak) {
                return redirect()->back()->with('error', 'Data anak tidak ditemukan di database master.');
            }

            // Update data bayi dengan tanggal lahir dari master data
            $sip2->update([
                'posyandu_id' => $request->posyandu_id,
                'nama_bayi' => $request->nama_bayi,
                'tgl_lahir' => $anak->tanggal_lahir,
                'bbl_kg' => $request->bbl_kg,
                'nama_ayah' => $request->nama_ayah,
                'nama_ibu' => $request->nama_ibu,
                'dasawisma_id' => $request->dasawisma_id
            ]);

            // Update atau create data penimbangan jika ada input
            if ($request->has('tb_penimbangan') || $request->has('bb_penimbangan')) {
                for ($bulan = 1; $bulan <= 12; $bulan++) {
                    $tb = $request->input("tb_penimbangan.{$bulan}");
                    $bb = $request->input("bb_penimbangan.{$bulan}");
                    
                    if (!empty($tb) || !empty($bb)) {
                        Sip2Penimbangan::updateOrCreate(
                            [
                                'bayi_id' => $sip2->bayi_id,
                                'bulan' => $bulan,
                                'tahun' => now()->year
                            ],
                            [
                                'tb_hasil_penimbangan' => $tb ?: null,
                                'bb_hasil_penimbangan' => $bb ?: null
                            ]
                        );
                    }
                }
            }

            // Update atau create data ASI
            if ($request->has('asi')) {
                foreach ($request->input('asi') as $jenis => $tanggal) {
                    if (!empty($tanggal)) {
                        \App\Models\Sip2Pemberianasi::updateOrCreate(
                            [
                                'bayi_id' => $sip2->bayi_id,
                                'jenis' => $jenis
                            ],
                            [
                                'tanggal_diberikan' => $tanggal
                            ]
                        );
                    }
                }
            }

            // Update atau create data pelayanan
            if ($request->has('pelayanan')) {
                foreach ($request->input('pelayanan') as $jenis => $tanggal) {
                    if (!empty($tanggal)) {
                        \App\Models\Sip2Pelayanan::updateOrCreate(
                            [
                                'bayi_id' => $sip2->bayi_id,
                                'jenis' => $jenis
                            ],
                            [
                                'tanggal_diberikan' => $tanggal
                            ]
                        );
                    }
                }
            }

            // Update atau create data imunisasi
            if ($request->has('imunisasi')) {
                foreach ($request->input('imunisasi') as $jenis => $tanggal) {
                    if (!empty($tanggal)) {
                        Sip2Imunisasi::updateOrCreate(
                            [
                                'bayi_id' => $sip2->bayi_id,
                                'jenis' => $jenis
                            ],
                            [
                                'tanggal_diberikan' => $tanggal
                            ]
                        );
                    }
                }
            }

            // Update atau create keterangan balita
            if ($request->filled('tanggal_meninggal') || $request->filled('catatan')) {
                \App\Models\Sip2KeteranganBalita::updateOrCreate(
                    ['bayi_id' => $sip2->bayi_id],
                    [
                        'tanggal_meninggal' => $request->input('tanggal_meninggal') ?: null,
                        'catatan' => $request->input('catatan') ?: null
                    ]
                );
            }

            DB::commit();

            return redirect()->route('sip.index', $request->posyandu_id)->with('success', 'Data SIP Format 2 beserta penimbangan dan imunisasi berhasil diperbarui.')->with('activeTab', 'format2');

        } catch (\Exception $e) {
            DB::rollback();
            // \Log::error('Error updating SIP2 data: ' . $e->getMessage());
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function deleteSip2($id)
    {
        $sip2 = Sip2::findOrFail($id);
        $posyandu_id = $sip2->posyandu_id;
        $nama_bayi = $sip2->nama_bayi;

        $sip2->delete();

        return redirect()->route('sip.index', $posyandu_id)->with('success', 'Data SIP Format 2 untuk ' . $nama_bayi . ' berhasil dihapus.')->with('activeTab', 'format2');
    }

    // SIP3 CRUD Methods
    public function storeSip3(Request $request)
    {
        // Debug: Log semua data yang diterima
        /*
        dd([
            'nama_balita' => $request->nama_balita,
            'nama_balita_manual' => $request->nama_balita_manual,
            'tgl_lahir' => $request->tgl_lahir,
            'tgl_lahir_manual' => $request->tgl_lahir_manual,
            'all_data' => $request->all()
        ]);
        */
        
        $request->validate([
            'dasawisma_id' => 'required|exists:dasawisma,dasawisma_id'
        ]);
        
        // Pastikan ada minimal satu nama balita (dari database atau manual)
        if (!$request->nama_balita && !$request->nama_balita_manual) {
            return redirect()->back()->with('error', 'Nama balita wajib diisi!');
        }

        $data = $request->all();

        // Gunakan nama balita dari hidden field (yang sudah diisi oleh JavaScript)
        // atau fallback ke manual jika hidden field kosong
        $data['nama_balita'] = $request->nama_balita ?: $request->nama_balita_manual;
        
        // Gunakan tanggal lahir dari hidden field atau manual
        $data['tgl_lahir'] = $request->tgl_lahir ?: $request->tgl_lahir_manual;

        // Jika masih tidak ada tanggal lahir dan nama dari database, cari di master data
        if (!$data['tgl_lahir'] && $request->nama_balita_db) {
            $anak = Anak::where('nama_lengkap', $request->nama_balita_db)->first();
            if ($anak) {
                $data['tgl_lahir'] = $anak->tanggal_lahir;
            }
        }

        // Validasi final
        if (!$data['nama_balita']) {
            return redirect()->back()->with('error', 'Nama balita tidak valid!');
        }
        
        if (!$data['tgl_lahir']) {
            return redirect()->back()->with('error', 'Tanggal lahir wajib diisi!');
        }

        // Validasi bahwa usia balita sesuai (1-5 tahun)
        $tglLahir = \Carbon\Carbon::parse($data['tgl_lahir']);
        $yearsDiff = $tglLahir->diffInYears(now());
        $monthsDiff = $tglLahir->diffInMonths(now());
        
        if ($monthsDiff <= 12) {
            return redirect()->back()->with('error', 'Tanggal lahir tidak sesuai untuk kategori balita (harus lebih dari 1 tahun).');
        }
        
        if ($yearsDiff > 5) {
            return redirect()->back()->with('error', 'Tanggal lahir tidak sesuai untuk kategori balita (harus kurang dari 5 tahun).');
        }

        // Validasi field wajib lainnya
        $request->validate([
            'bbl_kg' => 'required|numeric|min:0',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255'
        ]);

        Sip3::create($data);

        return redirect()->route('sip.index', $request->posyandu_id)->with('success', 'Data SIP Format 3 berhasil ditambahkan. Silakan edit untuk menambah data penimbangan dan imunisasi.')->with('activeTab', 'format3');
    }

    public function updateSip3(Request $request, $id)
    {
        $sip3 = Sip3::findOrFail($id);

        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'nama_balita' => 'required|string|max:255',
            'bbl_kg' => 'required|numeric|min:0',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'dasawisma_id' => 'required|exists:dasawisma,dasawisma_id'
        ]);

        // Ambil tanggal lahir dari data anak master berdasarkan nama
        $anak = Anak::where('nama_lengkap', $request->nama_balita)->first();
        if (!$anak) {
            return redirect()->back()->with('error', 'Data anak tidak ditemukan di database master.');
        }

        // Update dengan tanggal lahir dari master data
        $sip3->update([
            'posyandu_id' => $request->posyandu_id,
            'nama_balita' => $request->nama_balita,
            'tgl_lahir' => $anak->tanggal_lahir,
            'bbl_kg' => $request->bbl_kg,
            'nama_ayah' => $request->nama_ayah,
            'nama_ibu' => $request->nama_ibu,
            'dasawisma_id' => $request->dasawisma_id
        ]);

        return redirect()->route('sip.index', $request->posyandu_id)->with('success', 'Data SIP Format 3 berhasil diperbarui.')->with('activeTab', 'format3');
    }

    public function deleteSip3($id)
    {
        $sip3 = Sip3::findOrFail($id);
        $posyandu_id = $sip3->posyandu_id;
        $nama_balita = $sip3->nama_balita;

        $sip3->delete();

        return redirect()->route('sip.index', $posyandu_id)->with('success', 'Data SIP Format 3 untuk ' . $nama_balita . ' berhasil dihapus.')->with('activeTab', 'format3');
    }

    // SIP4 CRUD Methods
    public function storeSip4(Request $request)
    {
        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'tahun' => 'required|integer|min:1900|max:2100',
            'bulan' => 'required|string|max:20',
            'nama' => 'required|string|max:255',  // Changed from nama_wuspus to nama
            'nama_suami' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'dasawisma_id' => 'required|exists:dasawisma,dasawisma_id',
            'tahapan_ks' => 'nullable|string|max:10',
            'jumlah_anak_hidup' => 'nullable|integer|min:0',
            'anak_meninggal_umur' => 'nullable|string|max:100',
            'ukuran_lila_cm' => 'nullable|numeric|min:0',
            'lebih_23_5_cm' => 'nullable|boolean',
            // Optional fields handled through related models
            'jenis_kontrasepsi' => 'nullable|string|max:100',
            'tanggal_penggantian' => 'nullable|date',
            'jenis_kontrasepsi_pengganti' => 'nullable|string|max:100',
            'tt_*' => 'nullable|date',
        ]);

        // Create main SIP4 record (without contraception fields)
        $sip4 = Sip4::create([
            'posyandu_id' => $request->posyandu_id,
            'tahun' => $request->tahun,
            'bulan' => $request->bulan,
            'nama' => $request->nama,  // Use nama directly
            'nama_suami' => $request->nama_suami,
            'umur' => $request->umur,
            'dasawisma_id' => $request->dasawisma_id,
            'tahapan_ks' => $request->tahapan_ks,
            'jumlah_anak_hidup' => $request->jumlah_anak_hidup,
            'anak_meninggal_umur' => $request->anak_meninggal_umur,
            'ukuran_lila_cm' => $request->ukuran_lila_cm,
            'lebih_23_5_cm' => $request->lebih_23_5_cm
        ]);

        // Handle TT immunizations
        foreach(['I', 'II', 'III', 'IV', 'V'] as $tt_ke) {
            $fieldName = 'tt_' . $tt_ke;
            if ($request->filled($fieldName)) {
                $sip4->imunisasitt()->create([
                    'tt_ke' => $tt_ke,
                    'tanggal_pemberian' => $request->$fieldName
                ]);
            }
        }

        // Handle contraception
        if ($request->filled('jenis_kontrasepsi')) {
            $sip4->kontrasepsi()->create([
                'jenis_kontrasepsi' => $request->jenis_kontrasepsi
            ]);
        }

        // Handle contraception replacement
        if ($request->filled('tanggal_penggantian') || $request->filled('jenis_kontrasepsi_pengganti')) {
            $sip4->penggantianKontrasepsi()->create([
                'tanggal_penggantian' => $request->tanggal_penggantian,
                'jenis_baru' => $request->jenis_kontrasepsi_pengganti
            ]);
        }

        return redirect()->route('sip.index', $request->posyandu_id)->with('success', 'Data SIP Format 4 berhasil ditambahkan.')->with('activeTab', 'format4');
    }

    public function updateSip4(Request $request, $id)
    {
        $sip4 = Sip4::findOrFail($id);

        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'tahun' => 'required|integer|min:1900|max:2100',
            'bulan' => 'required|string|max:20',
            'nama' => 'required|string|max:255',
            'nama_suami' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'dasawisma_id' => 'required|exists:dasawisma,dasawisma_id',
            'tahapan_ks' => 'required|string|max:10',
            'jumlah_anak_hidup' => 'required|integer|min:0',
            'ukuran_lila_cm' => 'required|numeric|min:0',
            'lebih_23_5_cm' => 'required|boolean',
            // Optional fields handled through related models
            'jenis_kontrasepsi' => 'nullable|string|max:100',
            'tanggal_penggantian' => 'nullable|date',
            'jenis_kontrasepsi_pengganti' => 'nullable|string|max:100',
            'tt_*' => 'nullable|date',
        ]);

        // Update main SIP4 record (without contraception fields)
        $sip4->update($request->only([
            'posyandu_id', 'tahun', 'bulan', 'nama', 'nama_suami', 'umur', 
            'dasawisma_id', 'tahapan_ks', 'jumlah_anak_hidup', 'anak_meninggal_umur',
            'ukuran_lila_cm', 'lebih_23_5_cm'
        ]));

        // Handle TT immunizations
        foreach(['I', 'II', 'III', 'IV', 'V'] as $tt_ke) {
            $fieldName = 'tt_' . $tt_ke;
            if ($request->filled($fieldName)) {
                $sip4->imunisasitt()->updateOrCreate(
                    ['tt_ke' => $tt_ke],
                    ['tanggal_pemberian' => $request->$fieldName]
                );
            } else {
                // Remove if empty
                $sip4->imunisasitt()->where('tt_ke', $tt_ke)->delete();
            }
        }

        // Handle contraception
        if ($request->filled('jenis_kontrasepsi')) {
            $sip4->kontrasepsi()->updateOrCreate(
                ['wuspus_id' => $sip4->wuspus_id],
                ['jenis_kontrasepsi' => $request->jenis_kontrasepsi]
            );
        } else {
            // Remove if empty
            $sip4->kontrasepsi()->delete();
        }

        // Handle contraception replacement
        if ($request->filled('tanggal_penggantian') || $request->filled('jenis_kontrasepsi_pengganti')) {
            $sip4->penggantianKontrasepsi()->updateOrCreate(
                ['wuspus_id' => $sip4->wuspus_id],
                [
                    'tanggal_penggantian' => $request->tanggal_penggantian,
                    'jenis_baru' => $request->jenis_kontrasepsi_pengganti
                ]
            );
        } else {
            // Remove if both are empty
            $sip4->penggantianKontrasepsi()->delete();
        }

        return redirect()->route('sip.index', $request->posyandu_id)->with('success', 'Data SIP Format 4 berhasil diperbarui.')->with('activeTab', 'format4');
    }

    public function deleteSip4($id)
    {
        $sip4 = Sip4::findOrFail($id);
        $posyandu_id = $sip4->posyandu_id;
        $nama_wuspus = $sip4->nama;

        $sip4->delete();

        return redirect()->route('sip.index', $posyandu_id)->with('success', 'Data SIP Format 4 untuk ' . $nama_wuspus . ' berhasil dihapus.')->with('activeTab', 'format4');
    }

    // SIP5 CRUD Methods
    public function storeSip5(Request $request)
    {
        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'nama_ibu_hamil' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'tanggal_pendaftaran' => 'required|date',
            'dasawisma_id' => 'required|exists:dasawisma,dasawisma_id',
            'umur_kehamilan' => 'nullable|integer|min:0',
            'hamil_ke' => 'nullable|integer|min:1',
            'ukuran_lila' => 'nullable|numeric|min:0',
            'pmt_pemulihan' => 'nullable|boolean',
        ]);

        // Create main SIP5 record
        $sip5 = Sip5::create([
            'posyandu_id' => $request->posyandu_id,
            'nama_ibu' => $request->nama_ibu_hamil,  // Map nama_ibu_hamil to nama_ibu
            'umur' => $request->umur,
            'tanggal_pendaftaran' => $request->tanggal_pendaftaran,
            'dasawisma_id' => $request->dasawisma_id,
            'umur_kehamilan' => $request->umur_kehamilan,
            'hamil_ke' => $request->hamil_ke,
            'ukuran_lila' => $request->ukuran_lila,
            'pmt_pemulihan' => $request->pmt_pemulihan,
            'catatan' => $request->catatan
        ]);

        // Handle monthly weighing results (TB/BB)
        for($i = 1; $i <= 12; $i++) {
            $tbField = 'tb_' . $i;
            $bbField = 'bb_' . $i;
            
            if ($request->filled($tbField) || $request->filled($bbField)) {
                $sip5->penimbanganIbuHamil()->create([
                    'bulan' => $i,
                    'berat_badan' => $request->$bbField,
                    'umur_kehamilan' => $request->umur_kehamilan
                ]);
            }
        }

        // Handle tablet tambah darah (BKS)
        foreach(['I', 'II', 'III'] as $jenis) {
            $fieldName = 'tablet_' . $jenis;
            if ($request->filled($fieldName)) {
                $sip5->tabletTambahDarah()->create([
                    'jenis' => $jenis,
                    'tanggal_diberikan' => $request->$fieldName
                ]);
            }
        }

        // Handle immunizations
        foreach(['I', 'II', 'III', 'IV', 'V'] as $jenis) {
            $fieldName = 'imunisasi_' . $jenis;
            if ($request->filled($fieldName)) {
                $sip5->imunisasittIbuHamil()->create([
                    'jenis' => $jenis,
                    'tanggal_diberikan' => $request->$fieldName
                ]);
            }
        }

        // Handle vitamin A
        if ($request->filled('vitamin_a')) {
            $sip5->vitaminIbuHamil()->create([
                'tanggal_pemberian' => $request->vitamin_a
            ]);
        }

        return redirect()->route('sip.index', $request->posyandu_id)->with('success', 'Data SIP Format 5 berhasil ditambahkan.')->with('activeTab', 'format5');
    }

    public function updateSip5(Request $request, $id)
    {
        $sip5 = Sip5::findOrFail($id);

        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'nama_ibu' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'alamat_kelompok' => 'required|string|max:255',
            'dasawisma_id' => 'required|exists:dasawisma,dasawisma_id',
            'tanggal_pendaftaran' => 'required|date',
            'umur_kehamilan' => 'required|integer|min:0',
            'hamil_ke' => 'required|integer|min:1',
            'ukuran_lila' => 'required|numeric|min:0',
            'pmt_pemulihan' => 'required|boolean',
        ]);

        // Update main SIP5 record
        $sip5->update($request->only([
            'posyandu_id', 'nama_ibu', 'umur', 'alamat_kelompok', 'dasawisma_id',
            'tanggal_pendaftaran', 'umur_kehamilan', 'hamil_ke', 'ukuran_lila', 
            'pmt_pemulihan', 'catatan'
        ]));

        // Handle monthly weighing results (TB/BB)
        for($i = 1; $i <= 12; $i++) {
            $tbField = 'tb_' . $i;
            $bbField = 'bb_' . $i;
            
            if ($request->filled($tbField) || $request->filled($bbField)) {
                $sip5->penimbanganIbuHamil()->updateOrCreate(
                    ['bulan' => $i],
                    [
                        'berat_badan' => $request->$bbField,
                        'umur_kehamilan' => $request->umur_kehamilan
                    ]
                );
            } else {
                // Remove if both are empty
                $sip5->penimbanganIbuHamil()->where('bulan', $i)->delete();
            }
        }

        // Handle tablet tambah darah (BKS)
        foreach(['I', 'II', 'III'] as $jenis) {
            $fieldName = 'tablet_' . $jenis;
            if ($request->filled($fieldName)) {
                $sip5->tabletTambahDarah()->updateOrCreate(
                    ['jenis' => $jenis],
                    ['tanggal_diberikan' => $request->$fieldName]
                );
            } else {
                // Remove if empty
                $sip5->tabletTambahDarah()->where('jenis', $jenis)->delete();
            }
        }

        // Handle immunizations
        foreach(['I', 'II', 'III', 'IV', 'V'] as $jenis) {
            $fieldName = 'imunisasi_' . $jenis;
            if ($request->filled($fieldName)) {
                $sip5->imunisasittIbuHamil()->updateOrCreate(
                    ['jenis' => $jenis],
                    ['tanggal_diberikan' => $request->$fieldName]
                );
            } else {
                // Remove if empty
                $sip5->imunisasittIbuHamil()->where('jenis', $jenis)->delete();
            }
        }

        // Handle vitamin A
        if ($request->filled('vitamin_a')) {
            $sip5->vitaminIbuHamil()->updateOrCreate(
                ['ibu_hamil_id' => $sip5->ibu_hamil_id],
                ['tanggal_pemberian' => $request->vitamin_a]
            );
        } else {
            // Remove if empty
            $sip5->vitaminIbuHamil()->delete();
        }

        return redirect()->route('sip.index', $request->posyandu_id)->with('success', 'Data SIP Format 5 berhasil diperbarui.')->with('activeTab', 'format5');
    }

    public function deleteSip5($id)
    {
        $sip5 = Sip5::findOrFail($id);
        $posyandu_id = $sip5->posyandu_id;
        $nama_ibu_hamil = $sip5->nama_ibu;

        $sip5->delete();

        return redirect()->route('sip.index', $posyandu_id)->with('success', 'Data SIP Format 5 untuk ' . $nama_ibu_hamil . ' berhasil dihapus.')->with('activeTab', 'format5');
    }

    public function storeDokumentasi(Request $request)
    {
        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'tanggal' => 'required|date|before_or_equal:today',
            'nama_kegiatan' => 'required|string|max:255',
            'file_gambar' => 'required|file|mimes:jpg,jpeg,png|max:5120', // 5MB max
        ]);

        try {
            // Handle file upload
            $file = $request->file('file_gambar');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('dokumentasi', $fileName, 'public');

            // Debug: Log data yang akan disimpan
            /*
            \Log::info('Saving dokumentasi with data:', [
                'posyandu_id' => $request->posyandu_id,
                'tanggal' => $request->tanggal,
                'nama_kegiatan' => $request->nama_kegiatan,
                'file_path' => $filePath,
            ]);
            */

            // Create dokumentasi record
            DokumentasiKegiatan::create([
                'posyandu_id' => $request->posyandu_id,
                'tanggal' => $request->tanggal,
                'nama_kegiatan' => $request->nama_kegiatan,
                'file_path' => $filePath,
            ]);

            return redirect()->route('sip.index', $request->posyandu_id)
                ->with('success', 'Dokumentasi kegiatan berhasil ditambahkan.')
                ->with('activeTab', 'dokum');

        } catch (\Exception $e) {
            // \Log::error('Error saving dokumentasi: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal menyimpan dokumentasi: ' . $e->getMessage());
        }
    }

    public function updateDokumentasi(Request $request, $id)
    {
        $dokumentasi = DokumentasiKegiatan::findOrFail($id);

        $request->validate([
            'tanggal' => 'required|date|before_or_equal:today',
            'nama_kegiatan' => 'required|string|max:255',
            'file_gambar' => 'nullable|file|mimes:jpg,jpeg,png|max:5120', // 5MB max
        ]);

        try {
            $data = [
                'tanggal' => $request->tanggal,
                'nama_kegiatan' => $request->nama_kegiatan,
            ];

            // Handle file upload if provided
            if ($request->hasFile('file_gambar')) {
                // Delete old file
                if ($dokumentasi->file_path && Storage::disk('public')->exists($dokumentasi->file_path)) {
                    Storage::disk('public')->delete($dokumentasi->file_path);
                }

                // Upload new file
                $file = $request->file('file_gambar');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('dokumentasi', $fileName, 'public');
                $data['file_path'] = $filePath;
            }

            $dokumentasi->update($data);

            return redirect()->route('sip.index', $dokumentasi->posyandu_id)
                ->with('success', 'Dokumentasi kegiatan berhasil diperbarui.')
                ->with('activeTab', 'dokum');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui dokumentasi: ' . $e->getMessage());
        }
    }

    public function deleteDokumentasi($id)
    {
        try {
            $dokumentasi = DokumentasiKegiatan::findOrFail($id);
            $posyandu_id = $dokumentasi->posyandu_id;

            // Delete file
            if ($dokumentasi->file_path && Storage::disk('public')->exists($dokumentasi->file_path)) {
                Storage::disk('public')->delete($dokumentasi->file_path);
            }

            $dokumentasi->delete();

            return redirect()->route('sip.index', $posyandu_id)
                ->with('success', 'Dokumentasi kegiatan berhasil dihapus.')
                ->with('activeTab', 'dokum');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal menghapus dokumentasi: ' . $e->getMessage());
        }
    }

    // public function dashboard()
    // {
    //     $formats = Posyandu::all()->pluck('nama_posyandu', 'posyandu_id')->toArray();

    //     // Ambil posyandu pertama sebagai default atau buat object kosong untuk menghindari error
    //     $posyandu = Posyandu::first();
    //     if (!$posyandu) {
    //         $posyandu = (object) ['nama_posyandu' => 'Belum ada posyandu'];
    //     }

    //     return view('sip.dashboard', compact('formats', 'posyandu'));
    // }

    // public function showChart($posyandu_id)
    // {
    //     $tahun = 2025; // Sesuaikan tahun yang ingin ditampilkan

    //     // Ambil data per bulan untuk posyandu tertentu
    //     $data = Rekapkegiatanposyandubulanan::where('tahun', $tahun)
    //         ->where('posyandu_id', $posyandu_id)
    //         ->orderBy('bulan')
    //         ->get(['bulan', 'balita_sasaran', 'balita_punya_buku', 'balita_ditimbang', 'balita_naik']);

    //     $labels = [];
    //     $dataS = [];
    //     $dataK = [];
    //     $dataD = [];
    //     $dataN = [];

    //     foreach ($data as $item) {
    //         $labels[] = \Carbon\Carbon::create()->month($item->bulan)->format('M'); // ex: JAN, FEB
    //         $dataS[] = $item->balita_sasaran ?? 0;
    //         $dataK[] = $item->balita_punya_buku ?? 0;
    //         $dataD[] = $item->balita_ditimbang ?? 0;
    //         $dataN[] = $item->balita_naik ?? 0;
    //     }

    //     return view('sip.in', compact('labels', 'dataS', 'dataK', 'dataD', 'dataN'));
    // }
}
