<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk; // Assuming you have a Penduduk model
use App\Models\Rw;

class PendudukController extends Controller
{
    public function index()
    {
        $penduduk = Penduduk::with('rwData')->get(); // Load relasi RW data
        $rw = Rw::all(); // Get all RW data for dropdown
        // Logic to retrieve and display the list of residents
        return view('masterdata.penduduk', compact('penduduk', 'rw'));
    }

    public function create()
    {
        // Logic to show the form for creating a new resident
        return view('penduduk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|string|unique:penduduk,nik',
            'no_kk' => 'required|string',
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'shdk' => 'required|string',
            'alamat' => 'required|string',
            'rt' => 'required|integer',
            'rw' => 'required|integer|exists:rw,rw_id'
        ]);

        Penduduk::create([
            'nik' => $request->nik,
            'no_kk' => $request->no_kk,
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'shdk' => $request->shdk,
            'bpjs' => $request->bpjs,
            'faskes' => $request->faskes,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw
        ]);

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        // Logic to show the form for editing an existing resident
        return view('penduduk.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nik_new' => 'required|string',
            'no_kk' => 'required|string',
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'shdk' => 'required|string',
            'alamat' => 'required|string',
            'rt' => 'required|integer',
            'rw' => 'required|integer|exists:rw,rw_id'
        ]);

        $penduduk = Penduduk::findOrFail($id);
        $penduduk->update([
            'nik' => $request->nik_new,
            'no_kk' => $request->no_kk,
            'nama' => $request->nama,
            'tanggal_lahir' => $request->tanggal_lahir,
            'jenis_kelamin' => $request->jenis_kelamin,
            'shdk' => $request->shdk,
            'bpjs' => $request->bpjs,
            'faskes' => $request->faskes,
            'pendidikan' => $request->pendidikan,
            'pekerjaan' => $request->pekerjaan,
            'alamat' => $request->alamat,
            'rt' => $request->rt,
            'rw' => $request->rw
        ]);

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil diperbarui!');
    }

    public function delete($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        $penduduk->delete();

        return redirect()->route('penduduk.index')->with('success', 'Data penduduk berhasil dihapus!');
    }

    public function destroy($id)
    {
        // Logic to delete a resident from the database
        return redirect()->route('penduduk.index')->with('success', 'Resident deleted successfully.');
    }
}
