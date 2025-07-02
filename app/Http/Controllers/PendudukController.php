<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk; // Assuming you have a Penduduk model
use App\Models\Rw;

class PendudukController extends Controller
{
    public function index()
    {
        // Check if this is an AJAX request for DataTable
        if (request()->ajax()) {
            return $this->getDataTableData();
        }
        
        $rw = Rw::all(); // Get all RW data for dropdown
        // For initial page load, don't load all penduduk data
        return view('masterdata.penduduk', compact('rw'));
    }
    
    /**
     * Get data for DataTable with server-side processing
     */
    public function getDataTableData()
    {
        $draw = request()->get('draw');
        $start = request()->get('start');
        $length = request()->get('length');
        $search = request()->get('search');
        
        // Select only necessary columns to improve performance
        $query = Penduduk::select([
            'nik', 'no_kk', 'nama', 'jenis_kelamin', 'tanggal_lahir', 
            'shdk', 'bpjs', 'faskes', 'pendidikan', 'pekerjaan', 
            'alamat', 'rt', 'rw'
        ])->with(['rwData:rw_id,no_rw']);
        
        // Search functionality
        if (!empty($search['value'])) {
            $searchTerm = $search['value'];
            $query->where(function($q) use ($searchTerm) {
                $q->where('nik', 'like', "%{$searchTerm}%")
                  ->orWhere('no_kk', 'like', "%{$searchTerm}%")
                  ->orWhere('nama', 'like', "%{$searchTerm}%")
                  ->orWhere('alamat', 'like', "%{$searchTerm}%");
            });
        }
        
        $totalRecords = Penduduk::count();
        $filteredRecords = $query->count();
        
        $penduduk = $query->skip($start)
                         ->take($length)
                         ->get();
        
        $data = [];
        foreach ($penduduk as $index => $item) {
            $data[] = [
                'DT_RowIndex' => $start + $index + 1,
                'nik' => $item->nik,
                'no_kk' => $item->no_kk,
                'nama' => $item->nama,
                'jenis_kelamin' => $item->jenis_kelamin,
                'tanggal_lahir' => $item->tanggal_lahir ? $item->tanggal_lahir->format('d-m-Y') : '',
                'shdk' => $item->shdk,
                'bpjs' => $item->bpjs,
                'faskes' => $item->faskes,
                'pendidikan' => $item->pendidikan,
                'pekerjaan' => $item->pekerjaan,
                'alamat' => $item->alamat,
                'rt' => $item->rt,
                'rw' => $item->rwData ? $item->rwData->no_rw : $item->rw,
                'actions' => view('masterdata.penduduk_actions', compact('item'))->render()
            ];
        }
        
        return response()->json([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $filteredRecords,
            'data' => $data
        ]);
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
        $penduduk = Penduduk::with('rwData')->findOrFail($id);
        $rw = Rw::all();
        
        return view('includes.edit_delete_penduduk', compact('penduduk', 'rw'))
               ->with('modalType', 'edit');
    }
    
    public function getDeleteModal($id)
    {
        $penduduk = Penduduk::findOrFail($id);
        
        return view('includes.edit_delete_penduduk', compact('penduduk'))
               ->with('modalType', 'delete');
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
