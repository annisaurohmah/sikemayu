<?php

namespace App\Http\Controllers;

use App\Models\Dasawisma;
use App\Models\Dw;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DasawismaController extends Controller
{
    public function index()
    {
        $dasawisma = Dasawisma::all(); // Retrieve all dasawisma records
        // Logic to retrieve and display dasawisma data
        return view('masterdata.dasawisma', compact('dasawisma'));
    }
    public function create()
    {
        // Logic to show the form for creating a new dasawisma
        return view('dasawisma.create');
    }
    public function store(Request $request)
    {
        // Logic to store a new dasawisma
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'members' => 'required|array',
        ]);
        // Save the dasawisma data to the database
        // Dasawisma::create($data);
        return redirect()->route('dasawisma.index')->with('success', 'Dasawisma created successfully.');
    }
    public function edit($id)
    {
        // Logic to show the form for editing an existing dasawisma
        // $dasawisma = Dasawisma::findOrFail($id);
        return view('dasawisma.edit', compact('id'));
    }
    public function update(Request $request, $id)
    {
        // Logic to update an existing dasawisma
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'members' => 'required|array',
        ]);
        // Find the dasawisma and update it
        // $dasawisma = Dasawisma::findOrFail($id);
        // $dasawisma->update($data);
        return redirect()->route('dasawisma.index')->with('success', 'Dasawisma updated successfully.');
    }
    public function delete($id)
    {
        // Logic to delete an existing dasawisma
        // $dasawisma = Dasawisma::findOrFail($id);
        // $dasawisma->delete();
        return redirect()->route('dasawisma.index')->with('success', 'Dasawisma deleted successfully.');
    }
    public function show($id)
    {
        // Logic to show the details of a specific dasawisma
        // $dasawisma = Dasawisma::findOrFail($id);
        return view('dasawisma.show', compact('id'));
    }

    public function indexRekap()
    {
        $dasawisma = DB::table('dw')
            ->leftJoin('dw_jak', 'dw.dw_id', '=', 'dw_jak.dw_id')
            ->leftJoin('dw_kr', 'dw.dw_id', '=', 'dw_kr.dw_id')
            ->leftJoin('dw_mp', 'dw.dw_id', '=', 'dw_mp.dw_id')
            ->leftJoin('dw_sak', 'dw.dw_id', '=', 'dw_sak.dw_id')
            ->leftJoin('dw_wmk', 'dw.dw_id', '=', 'dw_wmk.dw_id')
            ->leftJoin('rw', 'rw.rw_id', '=', 'dw.rw_id')
            ->select(
                'dw.dw_id',
                'dw.bulan',
                'dw.tahun',
                'dw.rw_id',
                'dw.jumlah_RT',
                'dw.jumlah_DW',
                'dw.jumlah_KRT',
                'dw.jumlah_KK',
                'dw.jumlah_jamban',
                'dw.keterangan',
                'rw.no_rw',
                'dw_jak.total_P',
                'dw_jak.total_L',
                'dw_jak.balita_L',
                'dw_jak.balita_P',
                'dw_jak.PUS',
                'dw_jak.WUS',
                'dw_jak.ibu_hamil',
                'dw_jak.ibu_menyusui',
                'dw_jak.lansia',
                'dw_jak.tiga_buta_L',
                'dw_jak.tiga_buta_P',
                'dw_kr.sehat',
                'dw_kr.krg_sehat',
                'dw_kr.tempat_sampah',
                'dw_kr.spal',
                'dw_kr.stiker_pak',
                'dw_mp.beras',
                'dw_mp.non_beras',
                'dw_sak.pdam',
                'dw_sak.sumur',
                'dw_sak.sungai',
                'dw_sak.dll',
                'dw_wmk.up2k',
                'dw_wmk.tanah_pkrgn',
                'dw_wmk.industri_rt',
                'dw_wmk.kesling'
            )
            ->get();

        // Logic to show the rekapitulasi of dasawisma
        return view('dasawisma.index', compact('dasawisma'));
    }
    public function createRekap()
    {
        // Logic to show the form for creating a new rekapitulasi dasawisma
        return view('dasawisma.rekap.create'); 
    }
    public function storeRekap(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validate input
            $request->validate([
                'no_rw' => 'required',
                'jumlah_RT' => 'required|integer',
                'jumlah_DW' => 'required|integer',
                'jumlah_KRT' => 'required|integer',
                'jumlah_KK' => 'required|integer',
            ]);

            // Get or create RW
            $rw = DB::table('rw')->where('no_rw', $request->no_rw)->first();
            if (!$rw) {
                $rwId = DB::table('rw')->insertGetId(['no_rw' => $request->no_rw]);
            } else {
                $rwId = $rw->rw_id;
            }

            // Insert into dw table
            $dwId = DB::table('dw')->insertGetId([
                'rw_id' => $rwId,
                'jumlah_RT' => $request->jumlah_RT,
                'jumlah_DW' => $request->jumlah_DW,
                'jumlah_KRT' => $request->jumlah_KRT,
                'jumlah_KK' => $request->jumlah_KK,
                'jumlah_jamban' => $request->jumlah_jamban ?? 0,
                'keterangan' => $request->keterangan,
                'bulan' => date('m'),
                'tahun' => date('Y')
            ]);

            // Insert into related tables
            DB::table('dw_jak')->insert([
                'dw_id' => $dwId,
                'total_L' => $request->total_L ?? 0,
                'total_P' => $request->total_P ?? 0,
                'balita_L' => $request->balita_L ?? 0,
                'balita_P' => $request->balita_P ?? 0,
                'PUS' => $request->PUS ?? 0,
                'WUS' => $request->WUS ?? 0,
                'ibu_hamil' => $request->ibu_hamil ?? 0,
                'ibu_menyusui' => $request->ibu_menyusui ?? 0,
                'lansia' => $request->lansia ?? 0,
                'tiga_buta_L' => $request->tiga_buta_L ?? 0,
                'tiga_buta_P' => $request->tiga_buta_P ?? 0,
            ]);

            DB::table('dw_kr')->insert([
                'dw_id' => $dwId,
                'sehat' => $request->sehat ?? 0,
                'krg_sehat' => $request->krg_sehat ?? 0,
                'tempat_sampah' => $request->tempat_sampah ?? 0,
                'spal' => $request->spal ?? 0,
                'stiker_pak' => $request->stiker_pak ?? 0,
            ]);

            DB::table('dw_sak')->insert([
                'dw_id' => $dwId,
                'pdam' => $request->pdam ?? 0,
                'sumur' => $request->sumur ?? 0,
                'sungai' => $request->sungai ?? 0,
                'dll' => $request->dll ?? 0,
            ]);

            DB::table('dw_mp')->insert([
                'dw_id' => $dwId,
                'beras' => $request->beras ?? 0,
                'non_beras' => $request->non_beras ?? 0,
            ]);

            DB::table('dw_wmk')->insert([
                'dw_id' => $dwId,
                'up2k' => $request->up2k ?? 0,
                'tanah_pkrgn' => $request->tanah_pkrgn ?? 0,
                'industri_rt' => $request->industri_rt ?? 0,
                'kesling' => $request->kesling ?? 0,
            ]);

            DB::commit();
            return redirect()->route('dasawisma.rekap')->with('success', 'Data dasawisma berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menambahkan data dasawisma: ' . $e->getMessage());
        }
    }

    public function updateRekap(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            // Validate input
            $request->validate([
                'no_rw' => 'required',
                'jumlah_RT' => 'required|integer',
                'jumlah_DW' => 'required|integer',
                'jumlah_KRT' => 'required|integer',
                'jumlah_KK' => 'required|integer',
            ]);

            // Get or create RW
            $rw = DB::table('rw')->where('no_rw', $request->no_rw)->first();
            if (!$rw) {
                $rwId = DB::table('rw')->insertGetId(['no_rw' => $request->no_rw]);
            } else {
                $rwId = $rw->rw_id;
            }

            // Update dw table
            DB::table('dw')->where('dw_id', $id)->update([
                'rw_id' => $rwId,
                'jumlah_RT' => $request->jumlah_RT,
                'jumlah_DW' => $request->jumlah_DW,
                'jumlah_KRT' => $request->jumlah_KRT,
                'jumlah_KK' => $request->jumlah_KK,
                'jumlah_jamban' => $request->jumlah_jamban ?? 0,
                'keterangan' => $request->keterangan,
            ]);

            // Update related tables
            DB::table('dw_jak')->where('dw_id', $id)->update([
                'total_L' => $request->total_L ?? 0,
                'total_P' => $request->total_P ?? 0,
                'balita_L' => $request->balita_L ?? 0,
                'balita_P' => $request->balita_P ?? 0,
                'PUS' => $request->PUS ?? 0,
                'WUS' => $request->WUS ?? 0,
                'ibu_hamil' => $request->ibu_hamil ?? 0,
                'ibu_menyusui' => $request->ibu_menyusui ?? 0,
                'lansia' => $request->lansia ?? 0,
                'tiga_buta_L' => $request->tiga_buta_L ?? 0,
                'tiga_buta_P' => $request->tiga_buta_P ?? 0,
            ]);

            DB::table('dw_kr')->where('dw_id', $id)->update([
                'sehat' => $request->sehat ?? 0,
                'krg_sehat' => $request->krg_sehat ?? 0,
                'tempat_sampah' => $request->tempat_sampah ?? 0,
                'spal' => $request->spal ?? 0,
                'stiker_pak' => $request->stiker_pak ?? 0,
            ]);

            DB::table('dw_sak')->where('dw_id', $id)->update([
                'pdam' => $request->pdam ?? 0,
                'sumur' => $request->sumur ?? 0,
                'sungai' => $request->sungai ?? 0,
                'dll' => $request->dll ?? 0,
            ]);

            DB::table('dw_mp')->where('dw_id', $id)->update([
                'beras' => $request->beras ?? 0,
                'non_beras' => $request->non_beras ?? 0,
            ]);

            DB::table('dw_wmk')->where('dw_id', $id)->update([
                'up2k' => $request->up2k ?? 0,
                'tanah_pkrgn' => $request->tanah_pkrgn ?? 0,
                'industri_rt' => $request->industri_rt ?? 0,
                'kesling' => $request->kesling ?? 0,
            ]);

            DB::commit();
            return redirect()->route('dasawisma.rekap')->with('success', 'Data dasawisma berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal mengupdate data dasawisma: ' . $e->getMessage());
        }
    }

    public function deleteRekap($id)
    {
        DB::beginTransaction();
        try {
            // Delete from related tables first
            DB::table('dw_jak')->where('dw_id', $id)->delete();
            DB::table('dw_kr')->where('dw_id', $id)->delete();
            DB::table('dw_sak')->where('dw_id', $id)->delete();
            DB::table('dw_mp')->where('dw_id', $id)->delete();
            DB::table('dw_wmk')->where('dw_id', $id)->delete();
            
            // Finally delete from main table
            DB::table('dw')->where('dw_id', $id)->delete();

            DB::commit();
            return redirect()->route('dasawisma.rekap')->with('success', 'Data dasawisma berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Gagal menghapus data dasawisma: ' . $e->getMessage());
        }
    }

    public function storeMasterdata(Request $request)
    {
        $request->validate([
            'nama_dasawisma' => 'required|string|max:255',
            'alamat_dasawisma' => 'nullable|string|max:500'
        ]);

        Dasawisma::create([
            'nama_dasawisma' => $request->nama_dasawisma,
            'alamat_dasawisma' => $request->alamat_dasawisma
        ]);

        return redirect()->route('dasawisma.index')->with('success', 'Data Dasawisma berhasil ditambahkan!');
    }

    public function updateMasterdata(Request $request)
    {
        $request->validate([
            'dasawisma_id' => 'required|integer',
            'nama_dasawisma' => 'required|string|max:255',
            'alamat_dasawisma' => 'nullable|string|max:500'
        ]);

        $dasawisma = Dasawisma::findOrFail($request->dasawisma_id);
        $dasawisma->update([
            'nama_dasawisma' => $request->nama_dasawisma,
            'alamat_dasawisma' => $request->alamat_dasawisma
        ]);

        return redirect()->route('dasawisma.index')->with('success', 'Data Dasawisma berhasil diubah!');
    }

    public function deleteMasterdata(Request $request)
    {
        $request->validate([
            'dasawisma_id' => 'required|integer'
        ]);

        $dasawisma = Dasawisma::findOrFail($request->dasawisma_id);
        $dasawisma->delete();

        return redirect()->route('dasawisma.index')->with('success', 'Data Dasawisma berhasil dihapus!');
    }
}
