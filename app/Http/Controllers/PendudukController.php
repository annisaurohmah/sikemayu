<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penduduk; // Assuming you have a Penduduk model

class PendudukController extends Controller
{
    public function index()
    {
        $penduduk = Penduduk::all(); // Assuming you have a Penduduk model
        // Logic to retrieve and display the list of residents
        return view('masterdata.penduduk', compact('penduduk'));
    }

    public function create()
    {
        // Logic to show the form for creating a new resident
        return view('penduduk.create');
    }

    public function store(Request $request)
    {
        // Logic to store a new resident in the database
        // Validate and save the data
        return redirect()->route('penduduk.index')->with('success', 'Resident created successfully.');
    }

    public function edit($id)
    {
        // Logic to show the form for editing an existing resident
        return view('penduduk.edit', compact('id'));
    }

    public function update(Request $request, $id)
    {
        // Logic to update an existing resident in the database
        // Validate and update the data
        return redirect()->route('penduduk.index')->with('success', 'Resident updated successfully.');
    }

    public function destroy($id)
    {
        // Logic to delete a resident from the database
        return redirect()->route('penduduk.index')->with('success', 'Resident deleted successfully.');
    }
}
