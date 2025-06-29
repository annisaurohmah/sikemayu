<?php

namespace App\Http\Controllers;

use App\Models\Rekapkegiatanposyandubulanan;
use Illuminate\Http\Request;
use App\Models\Sip7;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;


class SIP7Controller extends Controller
{
    public function index()
    {
        $sip7 = Rekapkegiatanposyandubulanan::all();
        return view('sip.format7', compact('sip7'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:' . date('Y'),
            'posyandu_id' => 'required|exists:posyandu,id',
            'jumlah_wus' => 'required|integer|min:0',
            'jumlah_pus' => 'required|integer|min:0',
            'jumlah_hamil' => 'required|integer|min:0',
            'jumlah_menyusui' => 'required|integer|min:0',
            'ibu_hamil_meninggal' => 'required|integer|min:0',
            'ibu_melahirkan_meninggal' => 'required|integer|min:0',
            'nifas' => 'required|integer|min:0',
            'kader_posyandu' => 'required|integer|min:0',
            'plkb' => 'required|integer|min:0',
            'medis_paramedis' => 'required|integer|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Rekapkegiatanposyandubulanan::create([
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'bayi_0_12_bulan' => 0, // Akan dihitung otomatis
            'balita_1_5_tahun' => 0, // Akan dihitung otomatis
            'jumlah_wus' => $request->jumlah_wus,
            'jumlah_pus' => $request->jumlah_pus,
            'jumlah_hamil' => $request->jumlah_hamil,
            'jumlah_menyusui' => $request->jumlah_menyusui,
            'bayi_lahir' => 0, // Akan dihitung otomatis
            'bayi_meninggal' => 0, // Akan dihitung otomatis
            'ibu_hamil_meninggal' => $request->ibu_hamil_meninggal,
            'ibu_melahirkan_meninggal' => $request->ibu_melahirkan_meninggal,
            'nifas' => $request->nifas,
            'kader_posyandu' => $request->kader_posyandu,
            'plkb' => $request->plkb,
            'medis_paramedis' => $request->medis_paramedis,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Data SIP7 berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000|max:' . date('Y'),
            'jumlah_wus' => 'required|integer|min:0',
            'jumlah_pus' => 'required|integer|min:0',
            'jumlah_hamil' => 'required|integer|min:0',
            'jumlah_menyusui' => 'required|integer|min:0',
            'ibu_hamil_meninggal' => 'required|integer|min:0',
            'ibu_melahirkan_meninggal' => 'required|integer|min:0',
            'nifas' => 'required|integer|min:0',
            'kader_posyandu' => 'required|integer|min:0',
            'plkb' => 'required|integer|min:0',
            'medis_paramedis' => 'required|integer|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $sip7 = Rekapkegiatanposyandubulanan::findOrFail($id);
        $sip7->update([
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'jumlah_wus' => $request->jumlah_wus,
            'jumlah_pus' => $request->jumlah_pus,
            'jumlah_hamil' => $request->jumlah_hamil,
            'jumlah_menyusui' => $request->jumlah_menyusui,
            'ibu_hamil_meninggal' => $request->ibu_hamil_meninggal,
            'ibu_melahirkan_meninggal' => $request->ibu_melahirkan_meninggal,
            'nifas' => $request->nifas,
            'kader_posyandu' => $request->kader_posyandu,
            'plkb' => $request->plkb,
            'medis_paramedis' => $request->medis_paramedis,
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->back()->with('success', 'Data SIP6 berhasil diperbarui!');
    }

    public function delete($id)
    {
        $sip7 = Rekapkegiatanposyandubulanan::findOrFail($id);
        $sip7->delete();

        return redirect()->back()->with('success', 'Data SIP6 berhasil dihapus!');
    }
}
