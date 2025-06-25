<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function getDashboard()
    {
        // Logic to retrieve and display dashboard data
        return view('admin.dashboard');
    }

    public function getAdminDashboard()
    {
        // Logic to retrieve and display admin dashboard data
        return view('admin.dashboard');
    }

    public function getUsers()
    {
        // Logic to retrieve and display users
        return view('admin.users.index');
    }

    public function createUser(Request $request)
    {
        // Logic to create a new user
        // Validate and save user data
        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }

    public function updateUser(Request $request, $id)
    {
        // Logic to update an existing user
        // Validate and update user data
        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }

    public function deleteUser($id)
    {
        // Logic to delete a user
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }
}
