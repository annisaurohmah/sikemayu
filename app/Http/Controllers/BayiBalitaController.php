<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class BayiBalitaController extends Controller
{

    public function showBayi()
    {
        // Logic to show bayi data
        $bayi = Anak::where('tanggal_lahir', '>=', Carbon::now()->subYear())->get();
        return view('masterdata.bayi', compact('bayi'));
    }

    public function showBalita()
    {
        $balita = Anak::whereBetween('tanggal_lahir', [
            Carbon::now()->subYears(5),
            Carbon::now()->subYear()
        ])->get();
        return view('masterdata.balita', compact('balita'));
    }

    public function create()
    {
        // Logic to show the form for creating a new bayi or balita

        return view('bayi_balita.create');
    }

    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'nik' => 'required|string|max:16|unique:anak,nik',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'nama_lengkap_ortu' => 'required|string|max:255',
            'jenis_kelamin_ortu' => 'required|in:L,P'
        ]);

        // Create new record
        Anak::create([
            'nik' => $request->nik,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'nama_lengkap_ortu' => $request->nama_lengkap_ortu,
            'jenis_kelamin_ortu' => $request->jenis_kelamin_ortu
        ]);

        // Determine redirect based on age
        $birthDate = Carbon::parse($request->tanggal_lahir);
        $age = $birthDate->diffInMonths(Carbon::now());
        
        if ($age < 12) {
            return redirect()->route('bayi.show')->with('success', 'Data bayi berhasil disimpan.');
        } else {
            return redirect()->route('balita.show')->with('success', 'Data balita berhasil disimpan.');
        }
    }

    public function show($id)
    {
        // Logic to show a specific bayi or balita
        return view('bayi_balita.show', compact('id'));
    }

    public function edit($id)
    {
        // Logic to edit a specific bayi or balita
        return view('bayi_balita.edit', compact('id'));
    }

    public function update(Request $request, $nik)
    {
        // Debug log
        Log::info('Update method called with NIK: ' . $nik);
        Log::info('Request data: ', $request->all());
        
        // Find the record
        $anak = Anak::where('nik', $nik)->firstOrFail();
        
        // Validate request
        $request->validate([
            'nik_new' => 'required|string|max:16|unique:anak,nik,' . $anak->nik . ',nik',
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'tanggal_lahir' => 'required|date',
            'nama_lengkap_ortu' => 'required|string|max:255',
            'jenis_kelamin_ortu' => 'required|in:L,P'
        ]);

        // Update the record
        $anak->update([
            'nik' => $request->nik_new,
            'nama_lengkap' => $request->nama_lengkap,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
            'nama_lengkap_ortu' => $request->nama_lengkap_ortu,
            'jenis_kelamin_ortu' => $request->jenis_kelamin_ortu
        ]);

        // Determine redirect based on age
        $birthDate = Carbon::parse($request->tanggal_lahir);
        $age = $birthDate->diffInMonths(Carbon::now());
        
        if ($age < 12) {
            return redirect()->route('bayi.show')->with('success', 'Data bayi berhasil diperbarui.');
        } else {
            return redirect()->route('balita.show')->with('success', 'Data balita berhasil diperbarui.');
        }
    }

    public function destroy($nik)
    {
        // Find and delete the record
        $anak = Anak::where('nik', $nik)->firstOrFail();
        $nama = $anak->nama_lengkap;
        $birthDate = $anak->tanggal_lahir;
        $age = Carbon::parse($birthDate)->diffInMonths(Carbon::now());
        
        $anak->delete();
        
        // Determine redirect based on age
        if ($age < 12) {
            return redirect()->route('bayi.show')->with('success', 'Data bayi "' . $nama . '" berhasil dihapus.');
        } else {
            return redirect()->route('balita.show')->with('success', 'Data balita "' . $nama . '" berhasil dihapus.');
        }
    }
}
