<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rw;

class RWController extends Controller
{
    public function index()
    {
        $rw = Rw::all();
        return view('masterdata.rw', compact('rw'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'no_rw' => 'required|string|max:10|unique:rw,no_rw'
        ]);

        Rw::create([
            'no_rw' => $request->no_rw
        ]);

        return redirect()->route('rw.index')->with('success', 'Data RW berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'rw_id' => 'required|integer',
            'no_rw' => 'required|string|max:10|unique:rw,no_rw,' . $request->rw_id . ',rw_id'
        ]);

        $rw = Rw::findOrFail($request->rw_id);
        $rw->update([
            'no_rw' => $request->no_rw
        ]);

        return redirect()->route('rw.index')->with('success', 'Data RW berhasil diubah!');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'rw_id' => 'required|integer'
        ]);

        $rw = Rw::findOrFail($request->rw_id);
        $rw->delete();

        return redirect()->route('rw.index')->with('success', 'Data RW berhasil dihapus!');
    }
}
