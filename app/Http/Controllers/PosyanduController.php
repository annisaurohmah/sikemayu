<?php

namespace App\Http\Controllers;

use App\Models\Posyandu;
use Illuminate\Http\Request;

class PosyanduController extends Controller
{
    public function index()
    {
        $posyandus = Posyandu::all();
        return view('masterdata.posyandu', compact('posyandus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_posyandu' => 'required|string|max:255'
        ]);

        Posyandu::create([
            'nama_posyandu' => $request->nama_posyandu
        ]);

        return redirect()->route('posyandu.index')->with('success', 'Data Posyandu berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'posyandu_id' => 'required|integer',
            'nama_posyandu' => 'required|string|max:255'
        ]);

        $posyandu = Posyandu::findOrFail($request->posyandu_id);
        $posyandu->update([
            'nama_posyandu' => $request->nama_posyandu
        ]);

        return redirect()->route('posyandu.index')->with('success', 'Data Posyandu berhasil diubah!');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'posyandu_id' => 'required|integer'
        ]);

        $posyandu = Posyandu::findOrFail($request->posyandu_id);
        $posyandu->delete();

        return redirect()->route('posyandu.index')->with('success', 'Data Posyandu berhasil dihapus!');
    }
}
