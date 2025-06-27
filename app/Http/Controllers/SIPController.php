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
use App\Models\Sip3;
use App\Models\Sip4;
use App\Models\Sip5;
use App\Models\Sip2KeteranganBalita;
use App\Models\Sip5Penimbanganibuhamil;
use App\Models\Sip5Tablettambahdarah;
use App\Models\Sip5Vitaminaibuhamil;
use App\Models\Sip6;
use Carbon\Carbon;

class SIPController extends Controller
{
    public function index($posyandu_id)
    {
        //sip format 1
        $format1 = Sip1::where('posyandu_id', $posyandu_id)->get();
        $posyandu = Posyandu::find($posyandu_id);
        
        // Get data for dropdowns
        $dasawismaList = Dasawisma::all();
        
        // Filter bayi (0-12 bulan) dan balita (1-5 tahun) berdasarkan umur dari tanggal lahir
        $today = now();
        $bayiList_master = Anak::whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, ?) <= 12', [$today])->get();
        $balitaList_master = Anak::whereRaw('TIMESTAMPDIFF(MONTH, tanggal_lahir, ?) > 12 AND TIMESTAMPDIFF(YEAR, tanggal_lahir, ?) <= 5', [$today, $today])->get();

        //sip format 2
        $bayiList = Sip2::with([
            'penimbangan',
            'asi',
            'pelayanan',
            'imunisasi',
            'keteranganBalita',
            'dasawisma',
        ])->where('posyandu_id', $posyandu_id)->get();

        //sip format 3
        $balitaList = Sip3::with([
            'penimbangan',
            'pelayanan',
            'imunisasi',
            'keteranganBalita',
            'dasawisma',
        ])->where('posyandu_id', $posyandu_id)->get();

        //sip format 4
        $wuspusList = Sip4::with([
            'imunisasitt',
            'kontrasepsi',
            'penggantianKontrasepsi',
            'dasawisma',
        ])->where('posyandu_id', $posyandu_id)->get();

        //sip format 5
        $ibuHamilList = Sip5::with([
            'imunisasittIbuHamil',
            'penimbanganIbuHamil',
            'tabletTambahDarah',
            'vitaminIbuHamil',
            'dasawisma',
        ])->where('posyandu_id', $posyandu_id)->get();

        //sip format 6
        $tahun = now()->year;

        for ($bulan = 1; $bulan <= 12; $bulan++) {

            $bayi012 = Sip2::whereRaw("TIMESTAMPDIFF(MONTH, tgl_lahir, ?) <= 12", [Carbon::create($tahun, $bulan, 1)])
                ->count();

            $balita15 = Sip2::whereRaw("TIMESTAMPDIFF(MONTH, tgl_lahir, ?) > 12 AND TIMESTAMPDIFF(YEAR, tgl_lahir, ?) <= 5", [
                Carbon::create($tahun, $bulan, 1),
                Carbon::create($tahun, $bulan, 1)
            ])->count();

            $jumlahBayiLahir = Sip1::whereMonth('tgl_lahir', $bulan)
                ->whereYear('tgl_lahir', $tahun)
                ->count();
            $jumlahBayiMeninggal = Sip1::whereMonth('tgl_meninggal_bayi', $bulan)
                ->whereYear('tgl_meninggal_bayi', $tahun)
                ->count();

            $jumlahIbuHamil = Sip5::whereMonth('tanggal_pendaftaran', $bulan)
                ->whereYear('tanggal_pendaftaran', $tahun)
                ->count();

            Sip6::updateOrCreate(
                ['bulan' => $bulan, 'tahun' => $tahun],
                [
                    'jumlah_lahir' => $jumlahBayiLahir,
                    'jumlah_meninggal' => $jumlahBayiMeninggal,
                    'bayi_0_12_bulan' => $bayi012,
                    'balita_1_5_tahun' => $balita15,
                ]
            );
        }

        // Retrieve the latest SIP6 record for the current year
        $sip6 = Sip6::where('tahun', $tahun)->get();

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
                ->where('sip4_kontrasepsi.jenis_kontrasepsi', 'Pil')
                ->where('sip_4.posyandu_id', $posyandu_id)
                ->count();

            $jumlahBalita_S = Sip3::where('posyandu_id', $posyandu_id)
                ->whereMonth('tgl_lahir', $bulan)
                ->whereYear('tgl_lahir', $tahun)
                ->count();

            $jumlahBalita_K = Sip3::where('posyandu_id', $posyandu_id)
                ->whereMonth('tgl_lahir', $bulan)
                ->whereYear('tgl_lahir', $tahun)
                ->count();

            $jumlahBalita_D = Sip3::where('posyandu_id', $posyandu_id)->join('sip3_penimbangan', 'sip_3.balita_id', '=', 'sip3_penimbangan.balita_id')
                ->whereMonth('tgl_lahir', $bulan)
                ->whereYear('tgl_lahir', $tahun)
                ->where(function ($query) {
                    $query->whereNotNull('bb_hasil_penimbangan')
                        ->orWhereNotNull('tb_hasil_penimbangan');
                })
                ->count();

            // Ambil semua penimbangan bulan sekarang
            $dataBulanIni = Sip3::where('posyandu_id', $posyandu_id)
                ->whereMonth('tgl_lahir', $bulan)
                ->whereYear('tgl_lahir', $tahun)
                ->get();

            // Hitung jumlah yang naik BB
            $jumlahBalita_N = $dataBulanIni->filter(function ($item) use ($bulan, $tahun) {
                // Cek bulan sebelumnya
                $prevBulan = $bulan - 1;
                $prevTahun = $tahun;
                if ($bulan == 1) {
                    $prevBulan = 12;
                    $prevTahun = $tahun - 1;
                }

                // Ambil data bulan sebelumnya dari balita yang sama
                $prev = Sip3::where('balita_id', $item->balita_id)
                    ->whereMonth('tgl_lahir', $prevBulan)
                    ->whereYear('tgl_lahir', $prevTahun)
                    ->first();

                // Jika ada data sebelumnya dan BB naik
                return $prev && $item->bb_hasil_penimbangan > $prev->bb_hasil_penimbangan;
            })->count();

            $jumlahBayiBalitaMendapatVitA = (DB::table('sip_2')
                ->join('sip2_pelayanan', 'sip_2.bayi_id', '=', 'sip2_pelayanan.bayi_id')
                ->whereMonth('sip_2.tgl_lahir', $bulan)
                ->whereYear('sip_2.tgl_lahir', $tahun)
                ->where('sip2_pelayanan.jenis', 'Vitamin A')
                ->where('posyandu_id', $posyandu_id)
                ->count()) + (DB::table('sip_3')
                ->join('sip3_pelayanan', 'sip_3.balita_id', '=', 'sip3_pelayanan.balita_id')
                ->whereMonth('sip_3.tgl_lahir', $bulan)
                ->whereYear('sip_3.tgl_lahir', $tahun)
                ->where('sip3_pelayanan.jenis', 'Vitamin A')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBayiHBNol = (DB::table('sip_2')
                ->join('sip2_imunisasi', 'sip_2.bayi_id', '=', 'sip2_imunisasi.bayi_id')
                ->whereMonth('sip_2.tgl_lahir', $bulan)
                ->whereYear('sip_2.tgl_lahir', $tahun)
                ->where('sip2_imunisasi.jenis', 'HB Nol')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBayiBCG = (DB::table('sip_2')
                ->join('sip2_imunisasi', 'sip_2.bayi_id', '=', 'sip2_imunisasi.bayi_id')
                ->whereMonth('sip_2.tgl_lahir', $bulan)
                ->whereYear('sip_2.tgl_lahir', $tahun)
                ->where('sip2_imunisasi.jenis', 'BCG')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBayi_PolioI = (DB::table('sip_2')
                ->join('sip2_imunisasi', 'sip_2.bayi_id', '=', 'sip2_imunisasi.bayi_id')
                ->whereMonth('sip_2.tgl_lahir', $bulan)
                ->whereYear('sip_2.tgl_lahir', $tahun)
                ->where('sip2_imunisasi.jenis', 'Polio I')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBayi_PolioII = (DB::table('sip_2')
                ->join('sip2_imunisasi', 'sip_2.bayi_id', '=', 'sip2_imunisasi.bayi_id')
                ->whereMonth('sip_2.tgl_lahir', $bulan)
                ->whereYear('sip_2.tgl_lahir', $tahun)
                ->where('sip2_imunisasi.jenis', 'Polio II')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBayi_PolioIII = (DB::table('sip_2')
                ->join('sip2_imunisasi', 'sip_2.bayi_id', '=', 'sip2_imunisasi.bayi_id')
                ->whereMonth('sip_2.tgl_lahir', $bulan)
                ->whereYear('sip_2.tgl_lahir', $tahun)
                ->where('sip2_imunisasi.jenis', 'Polio III')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBayi_PolioIV = (DB::table('sip_2')
                ->join('sip2_imunisasi', 'sip_2.bayi_id', '=', 'sip2_imunisasi.bayi_id')
                ->whereMonth('sip_2.tgl_lahir', $bulan)
                ->whereYear('sip_2.tgl_lahir', $tahun)
                ->where('sip2_imunisasi.jenis', 'Polio IV')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBayi_DPTI = (DB::table('sip_2')
                ->join('sip2_imunisasi', 'sip_2.bayi_id', '=', 'sip2_imunisasi.bayi_id')
                ->whereMonth('sip_2.tgl_lahir', $bulan)
                ->whereYear('sip_2.tgl_lahir', $tahun)
                ->where('sip2_imunisasi.jenis', 'DPT/HB I')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBayi_DPTII = (DB::table('sip_2')
                ->join('sip2_imunisasi', 'sip_2.bayi_id', '=', 'sip2_imunisasi.bayi_id')
                ->whereMonth('sip_2.tgl_lahir', $bulan)
                ->whereYear('sip_2.tgl_lahir', $tahun)
                ->where('sip2_imunisasi.jenis', 'DPT/HB II')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBayi_DPTIII = (DB::table('sip_2')
                ->join('sip2_imunisasi', 'sip_2.bayi_id', '=', 'sip2_imunisasi.bayi_id')
                ->whereMonth('sip_2.tgl_lahir', $bulan)
                ->whereYear('sip_2.tgl_lahir', $tahun)
                ->where('sip2_imunisasi.jenis', 'DPT/HB III')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBayi_Campak = (DB::table('sip_2')
                ->join('sip2_imunisasi', 'sip_2.bayi_id', '=', 'sip2_imunisasi.bayi_id')
                ->whereMonth('sip_2.tgl_lahir', $bulan)
                ->whereYear('sip_2.tgl_lahir', $tahun)
                ->where('sip2_imunisasi.jenis', 'Campak')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahImunisasiTT_I = (DB::table('sip_4')
                ->join('sip4_imunisasitt', 'sip_4.wuspus_id', '=', 'sip4_imunisasitt.wuspus_id')
                ->whereMonth('sip4_imunisasitt.tanggal_pemberian', $bulan)
                ->whereYear('sip4_imunisasitt.tanggal_pemberian', $tahun)
                ->where('posyandu_id', $posyandu_id)
                ->where('sip4_imunisasitt.tt_ke', 'I')
                ->count()) + (DB::table('sip_5')
                ->join('sip5_imunisasittibuhamil', 'sip_5.ibu_hamil_id', '=', 'sip5_imunisasittibuhamil.ibu_hamil_id')
                ->whereMonth('sip5_imunisasittibuhamil.tanggal_pemberian', $bulan)
                ->whereYear('sip5_imunisasittibuhamil.tanggal_pemberian', $tahun)
                ->where('sip5_imunisasittibuhamil.tt_ke', 'IV')
                ->where('sip5_imunisasittibuhamil.tt_ke', 'I')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahImunisasiTT_II = (DB::table('sip_4')
                ->join('sip4_imunisasitt', 'sip_4.wuspus_id', '=', 'sip4_imunisasitt.wuspus_id')
                ->whereMonth('sip4_imunisasitt.tanggal_pemberian', $bulan)
                ->whereYear('sip4_imunisasitt.tanggal_pemberian', $tahun)
                ->where('posyandu_id', $posyandu_id)
                ->where('sip4_imunisasitt.tt_ke', 'I')
                ->count()) + (DB::table('sip_5')
                ->join('sip5_imunisasittibuhamil', 'sip_5.ibu_hamil_id', '=', 'sip5_imunisasittibuhamil.ibu_hamil_id')
                ->whereMonth('sip5_imunisasittibuhamil.tanggal_pemberian', $bulan)
                ->whereYear('sip5_imunisasittibuhamil.tanggal_pemberian', $tahun)
                ->where('sip5_imunisasittibuhamil.tt_ke', 'IV')
                ->where('sip5_imunisasittibuhamil.tt_ke', 'II')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahImunisasiTT_III = (DB::table('sip_4')
                ->join('sip4_imunisasitt', 'sip_4.wuspus_id', '=', 'sip4_imunisasitt.wuspus_id')
                ->whereMonth('sip4_imunisasitt.tanggal_pemberian', $bulan)
                ->whereYear('sip4_imunisasitt.tanggal_pemberian', $tahun)
                ->where('posyandu_id', $posyandu_id)
                ->where('sip4_imunisasitt.tt_ke', 'III')
                ->count()) + (DB::table('sip_5')
                ->join('sip5_imunisasittibuhamil', 'sip_5.ibu_hamil_id', '=', 'sip5_imunisasittibuhamil.ibu_hamil_id')
                ->whereMonth('sip5_imunisasittibuhamil.tanggal_pemberian', $bulan)
                ->whereYear('sip5_imunisasittibuhamil.tanggal_pemberian', $tahun)
                ->where('sip5_imunisasittibuhamil.tt_ke', 'I')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahImunisasiTT_IV = (DB::table('sip_4')
                ->join('sip4_imunisasitt', 'sip_4.wuspus_id', '=', 'sip4_imunisasitt.wuspus_id')
                ->whereMonth('sip4_imunisasitt.tanggal_pemberian', $bulan)
                ->whereYear('sip4_imunisasitt.tanggal_pemberian', $tahun)
                ->where('posyandu_id', $posyandu_id)
                ->where('sip4_imunisasitt.tt_ke', 'I')
                ->count()) + (DB::table('sip_5')
                ->join('sip5_imunisasittibuhamil', 'sip_5.ibu_hamil_id', '=', 'sip5_imunisasittibuhamil.ibu_hamil_id')
                ->whereMonth('sip5_imunisasittibuhamil.tanggal_pemberian', $bulan)
                ->whereYear('sip5_imunisasittibuhamil.tanggal_pemberian', $tahun)
                ->where('sip5_imunisasittibuhamil.tt_ke', 'IV')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahImunisasiTT_V = (DB::table('sip_4')
                ->join('sip4_imunisasitt', 'sip_4.wuspus_id', '=', 'sip4_imunisasitt.wuspus_id')
                ->whereMonth('sip4_imunisasitt.tanggal_pemberian', $bulan)
                ->whereYear('sip4_imunisasitt.tanggal_pemberian', $tahun)
                ->where('posyandu_id', $posyandu_id)
                ->where('sip4_imunisasitt.tt_ke', 'I')
                ->count()) + (DB::table('sip_5')
                ->join('sip5_imunisasittibuhamil', 'sip_5.ibu_hamil_id', '=', 'sip5_imunisasittibuhamil.ibu_hamil_id')
                ->whereMonth('sip5_imunisasittibuhamil.tanggal_pemberian', $bulan)
                ->whereYear('sip5_imunisasittibuhamil.tanggal_pemberian', $tahun)
                ->where('sip5_imunisasittibuhamil.tt_ke', 'IV')
                ->where('sip5_imunisasittibuhamil.tt_ke', 'V')
                ->where('posyandu_id', $posyandu_id)
                ->count());

            $jumlahBalitaOralit = DB::table('sip_3')
                ->join('sip3_pelayanan', 'sip_3.balita_id', '=', 'sip3_pelayanan.balita_id')
                ->whereMonth('sip3_pelayanan.tanggal_diberikan', $bulan)
                ->whereYear('sip3_pelayanan.tanggal_diberikan', $tahun)
                ->where('posyandu_id', $posyandu_id)
                ->where('sip3_pelayanan.jenis', 'Oralit')
                ->count();


            Rekapkegiatanposyandubulanan::updateOrCreate(
                ['bulan' => $bulan, 'tahun' => $tahun],
                [
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

        $sip7 = Rekapkegiatanposyandubulanan::where('tahun', $tahun)->get();







        return view('sip.index', compact('posyandu_id', 'posyandu', 'format1', 'bayiList', 'balitaList', 'wuspusList', 'ibuHamilList', 'sip6', 'sip7', 'dasawismaList', 'bayiList_master', 'balitaList_master'));
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

        return redirect()->route('sip.index', $request->posyandu_id)->with('success', 'Data SIP Format 1 berhasil ditambahkan.');
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

        return redirect()->route('sip.index', $request->posyandu_id)->with('success', 'Data SIP Format 1 berhasil diperbarui.');
    }

    public function deleteSip1($id)
    {
        $sip1 = Sip1::findOrFail($id);
        $posyandu_id = $sip1->posyandu_id;
        $nama_bayi = $sip1->nama_bayi;
        
        $sip1->delete();

        return redirect()->route('sip.index', $posyandu_id)->with('success', 'Data SIP Format 1 untuk ' . $nama_bayi . ' berhasil dihapus.');
    }

    // SIP2 CRUD Methods
    public function storeSip2(Request $request)
    {
        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'nama_bayi' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'bbl_kg' => 'required|numeric|min:0',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'dasawisma_id' => 'required|exists:dasawisma,dasawisma_id'
        ]);

        Sip2::create($request->all());

        return redirect()->route('sip.index', $request->posyandu_id)->with('success', 'Data SIP Format 2 berhasil ditambahkan.');
    }

    public function updateSip2(Request $request, $id)
    {
        $sip2 = Sip2::findOrFail($id);
        
        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'nama_bayi' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'bbl_kg' => 'required|numeric|min:0',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'dasawisma_id' => 'required|exists:dasawisma,dasawisma_id'
        ]);

        $sip2->update($request->all());

        return redirect()->route('sip.index', $request->posyandu_id)->with('success', 'Data SIP Format 2 berhasil diperbarui.');
    }

    public function deleteSip2($id)
    {
        $sip2 = Sip2::findOrFail($id);
        $posyandu_id = $sip2->posyandu_id;
        $nama_bayi = $sip2->nama_bayi;
        
        $sip2->delete();

        return redirect()->route('sip.index', $posyandu_id)->with('success', 'Data SIP Format 2 untuk ' . $nama_bayi . ' berhasil dihapus.');
    }

    // SIP3 CRUD Methods
    public function storeSip3(Request $request)
    {
        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'nama_balita' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'bbl_kg' => 'required|numeric|min:0',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'dasawisma_id' => 'required|exists:dasawisma,dasawisma_id'
        ]);

        Sip3::create($request->all());

        return redirect()->route('sip.index', $request->posyandu_id)->with('success', 'Data SIP Format 3 berhasil ditambahkan.');
    }

    public function updateSip3(Request $request, $id)
    {
        $sip3 = Sip3::findOrFail($id);
        
        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'nama_balita' => 'required|string|max:255',
            'tgl_lahir' => 'required|date',
            'bbl_kg' => 'required|numeric|min:0',
            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'dasawisma_id' => 'required|exists:dasawisma,dasawisma_id'
        ]);

        $sip3->update($request->all());

        return redirect()->route('sip.index', $request->posyandu_id)->with('success', 'Data SIP Format 3 berhasil diperbarui.');
    }

    public function deleteSip3($id)
    {
        $sip3 = Sip3::findOrFail($id);
        $posyandu_id = $sip3->posyandu_id;
        $nama_balita = $sip3->nama_balita;
        
        $sip3->delete();

        return redirect()->route('sip.index', $posyandu_id)->with('success', 'Data SIP Format 3 untuk ' . $nama_balita . ' berhasil dihapus.');
    }

    // SIP4 CRUD Methods
    public function storeSip4(Request $request)
    {
        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'tahun' => 'required|integer|min:1900|max:2100',
            'bulan' => 'required|string|max:20',
            'nama_wuspus' => 'required|string|max:255',
            'nama_suami' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'dasawisma_id' => 'required|exists:dasawisma,dasawisma_id'
        ]);

        Sip4::create($request->all());

        return redirect()->route('sip.index', $request->posyandu_id)->with('success', 'Data SIP Format 4 berhasil ditambahkan.');
    }

    public function updateSip4(Request $request, $id)
    {
        $sip4 = Sip4::findOrFail($id);
        
        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'tahun' => 'required|integer|min:1900|max:2100',
            'bulan' => 'required|string|max:20',
            'nama_wuspus' => 'required|string|max:255',
            'nama_suami' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'dasawisma_id' => 'required|exists:dasawisma,dasawisma_id'
        ]);

        $sip4->update($request->all());

        return redirect()->route('sip.index', $request->posyandu_id)->with('success', 'Data SIP Format 4 berhasil diperbarui.');
    }

    public function deleteSip4($id)
    {
        $sip4 = Sip4::findOrFail($id);
        $posyandu_id = $sip4->posyandu_id;
        $nama_wuspus = $sip4->nama_wuspus;
        
        $sip4->delete();

        return redirect()->route('sip.index', $posyandu_id)->with('success', 'Data SIP Format 4 untuk ' . $nama_wuspus . ' berhasil dihapus.');
    }

    // SIP5 CRUD Methods
    public function storeSip5(Request $request)
    {
        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'tahun' => 'required|integer|min:1900|max:2100',
            'bulan' => 'required|string|max:20',
            'nama_ibu_hamil' => 'required|string|max:255',
            'nama_suami' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'tanggal_pendaftaran' => 'required|date',
            'dasawisma_id' => 'required|exists:dasawisma,dasawisma_id'
        ]);

        Sip5::create($request->all());

        return redirect()->route('sip.index', $request->posyandu_id)->with('success', 'Data SIP Format 5 berhasil ditambahkan.');
    }

    public function updateSip5(Request $request, $id)
    {
        $sip5 = Sip5::findOrFail($id);
        
        $request->validate([
            'posyandu_id' => 'required|exists:posyandu,posyandu_id',
            'tahun' => 'required|integer|min:1900|max:2100',
            'bulan' => 'required|string|max:20',
            'nama_ibu_hamil' => 'required|string|max:255',
            'nama_suami' => 'required|string|max:255',
            'umur' => 'required|integer|min:0',
            'tanggal_pendaftaran' => 'required|date',
            'dasawisma_id' => 'required|exists:dasawisma,dasawisma_id'
        ]);

        $sip5->update($request->all());

        return redirect()->route('sip.index', $request->posyandu_id)->with('success', 'Data SIP Format 5 berhasil diperbarui.');
    }

    public function deleteSip5($id)
    {
        $sip5 = Sip5::findOrFail($id);
        $posyandu_id = $sip5->posyandu_id;
        $nama_ibu_hamil = $sip5->nama_ibu_hamil;
        
        $sip5->delete();

        return redirect()->route('sip.index', $posyandu_id)->with('success', 'Data SIP Format 5 untuk ' . $nama_ibu_hamil . ' berhasil dihapus.');
    }
}
