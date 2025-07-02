<?php

namespace App\Http\Controllers;

use App\Models\Pokja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Traits\HasDataAccess;

class PokjaController extends Controller
{
    use HasDataAccess;
    
    public function index($pokjaType = 'pokja1')
    {
        $access = $this->getDataAccess();
        
        // Get pokja structure
        $pokjaStructure = Pokja::getPokjaStructure();
        
        // Validate pokja type
        if (!isset($pokjaStructure[$pokjaType])) {
            $pokjaType = 'pokja1';
        }
        
        $currentPokja = $pokjaStructure[$pokjaType];
        $tabs = $currentPokja['tabs'];
        
        // Get data for each tab
        $tabsData = [];
        foreach ($tabs as $tabKey => $tabName) {
            $tabsData[$tabKey] = Pokja::getByPokjaName($tabKey);
        }
        
        return view('pokja.index', compact(
            'pokjaType', 
            'pokjaStructure', 
            'currentPokja', 
            'tabs', 
            'tabsData',
            'access'
        ));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'nama_pokja' => 'required|string|max:50',
            'judul_pokja' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file_gambar' => 'required|image|mimes:jpeg,jpg,png|max:5120' // 5MB max
        ]);
        
        try {
            $data = $request->only([
                'nama_pokja', 'judul_pokja', 'tanggal', 
                'nama_kegiatan', 'deskripsi'
            ]);
            
            // Handle file upload
            if ($request->hasFile('file_gambar')) {
                $file = $request->file('file_gambar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('pokja', $filename, 'public');
                $data['file_gambar'] = $path;
            }
            
            $data['created_by'] = Auth::user()->username ?? 'system';
            
            Pokja::create($data);
            
            return redirect()->back()->with('success', 'Data Pokja berhasil ditambahkan!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_pokja' => 'required|string|max:255',
            'tanggal' => 'required|date',
            'nama_kegiatan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'file_gambar' => 'nullable|image|mimes:jpeg,jpg,png|max:5120'
        ]);
        
        try {
            $pokja = Pokja::findOrFail($id);
            
            $data = $request->only([
                'judul_pokja', 'tanggal', 'nama_kegiatan', 'deskripsi'
            ]);
            
            // Handle file upload
            if ($request->hasFile('file_gambar')) {
                // Delete old file if exists
                if ($pokja->file_gambar && Storage::disk('public')->exists($pokja->file_gambar)) {
                    Storage::disk('public')->delete($pokja->file_gambar);
                }
                
                $file = $request->file('file_gambar');
                $filename = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('pokja', $filename, 'public');
                $data['file_gambar'] = $path;
            }
            
            $data['updated_by'] = Auth::user()->username ?? 'system';
            
            $pokja->update($data);
            
            return redirect()->back()->with('success', 'Data Pokja berhasil diperbarui!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    
    public function destroy($id)
    {
        try {
            $pokja = Pokja::findOrFail($id);
            
            // Delete file if exists
            if ($pokja->file_gambar && Storage::disk('public')->exists($pokja->file_gambar)) {
                Storage::disk('public')->delete($pokja->file_gambar);
            }
            
            $pokja->delete();
            
            return redirect()->back()->with('success', 'Data Pokja berhasil dihapus!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
