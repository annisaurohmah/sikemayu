<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rw;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        $rwList = Rw::all();
        $posyanduList = Posyandu::all();
        
        return view('masterdata.user', compact('users', 'rwList', 'posyanduList'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:admin_desa,admin_kader,admin_rw',
            'no_rw' => 'nullable|string|max:10',
            'nama_posyandu' => 'nullable|string|max:255'
        ]);

        // Additional validation based on role
        if ($request->role === 'admin_rw' && empty($request->no_rw)) {
            return redirect()->back()->withErrors(['no_rw' => 'Nomor RW harus dipilih untuk role Admin RW'])->withInput();
        }

        if ($request->role === 'admin_kader' && empty($request->nama_posyandu)) {
            return redirect()->back()->withErrors(['nama_posyandu' => 'Nama Posyandu harus dipilih untuk role Admin Kader'])->withInput();
        }

        // Clean data based on role
        $no_rw = $request->role === 'admin_rw' ? $request->no_rw : null;
        $nama_posyandu = $request->role === 'admin_kader' ? $request->nama_posyandu : null;

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'no_rw' => $no_rw,
            'nama_posyandu' => $nama_posyandu
        ]);

        return redirect()->route('user.index')->with('success', 'Data pengguna berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'username' => 'required|string|max:255|unique:users,username,' . $request->user_id . ',user_id',
            'password' => 'nullable|string|min:6',
            'role' => 'required|string|in:admin_desa,admin_kader,admin_rw',
            'no_rw' => 'nullable|string|max:10',
            'nama_posyandu' => 'nullable|string|max:255'
        ]);

        // Additional validation based on role
        if ($request->role === 'admin_rw' && empty($request->no_rw)) {
            return redirect()->back()->withErrors(['no_rw' => 'Nomor RW harus dipilih untuk role Admin RW'])->withInput();
        }

        if ($request->role === 'admin_kader' && empty($request->nama_posyandu)) {
            return redirect()->back()->withErrors(['nama_posyandu' => 'Nama Posyandu harus dipilih untuk role Admin Kader'])->withInput();
        }

        $user = User::findOrFail($request->user_id);
        
        // Clean data based on role
        $no_rw = $request->role === 'admin_rw' ? $request->no_rw : null;
        $nama_posyandu = $request->role === 'admin_kader' ? $request->nama_posyandu : null;
        
        $updateData = [
            'username' => $request->username,
            'role' => $request->role,
            'no_rw' => $no_rw,
            'nama_posyandu' => $nama_posyandu
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return redirect()->route('user.index')->with('success', 'Data pengguna berhasil diubah!');
    }

    public function delete(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer'
        ]);

        $user = User::findOrFail($request->user_id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'Data pengguna berhasil dihapus!');
    }
}
