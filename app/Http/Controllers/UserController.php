<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all(); // Assuming you have a User model
        // Logic to retrieve and display user data
        return view('masterdata.user', compact('users'));
    }

    public function create()
    {
        // Logic to show the form for creating a new user
        return view('users.create');
    }

    public function store(Request $request)
    {
        // Logic to store a new user in the database
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
        // Save the user data to the database
        // User::create($data);
        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function edit($id)
    {
        // Logic to show the form for editing an existing user
        return view('users.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Logic to update an existing user in the database
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);
        // Find the user and update it
        // $user = User::findOrFail($id);
        // $user->update($data);
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        // Logic to delete a user from the database
        // $user = User::findOrFail($id);
        // $user->delete();
        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
}
