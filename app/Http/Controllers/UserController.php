<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('masterdata.user', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
            'role' => 'required|string|in:admin,kader,user',
            'no_rw' => 'nullable|string|max:10',
            'nama_posyandu' => 'nullable|string|max:255'
        ]);

        User::create([
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'no_rw' => $request->no_rw,
            'nama_posyandu' => $request->nama_posyandu
        ]);

        return redirect()->route('user.index')->with('success', 'Data pengguna berhasil ditambahkan!');
    }

    public function update(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'username' => 'required|string|max:255|unique:users,username,' . $request->user_id . ',user_id',
            'password' => 'nullable|string|min:6',
            'role' => 'required|string|in:admin,kader,user',
            'no_rw' => 'nullable|string|max:10',
            'nama_posyandu' => 'nullable|string|max:255'
        ]);

        $user = User::findOrFail($request->user_id);
        
        $updateData = [
            'username' => $request->username,
            'role' => $request->role,
            'no_rw' => $request->no_rw,
            'nama_posyandu' => $request->nama_posyandu
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
