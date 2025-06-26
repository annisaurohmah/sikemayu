<?php

namespace App\Http\Controllers;

use App\Models\Anak;
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
                $prev = Sip3::where('bayi_id', $item->bayi_id)
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







        return view('sip.index', compact('posyandu_id', 'posyandu', 'format1', 'bayiList', 'balitaList', 'wuspusList', 'ibuHamilList', 'sip6', 'sip7'));
    }
}
