<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DasawismaController extends Controller
{
    public function index()
    {
        // Logic to retrieve and display dasawisma data
        return view('dasawisma.index');
    }
    public function create()
    {
        // Logic to show the form for creating a new dasawisma
        return view('dasawisma.create');
    }
    public function store(Request $request)
    {
        // Logic to store a new dasawisma
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'members' => 'required|array',
        ]);
        // Save the dasawisma data to the database
        // Dasawisma::create($data);
        return redirect()->route('dasawisma.index')->with('success', 'Dasawisma created successfully.');
    }
    public function edit($id)
    {
        // Logic to show the form for editing an existing dasawisma
        // $dasawisma = Dasawisma::findOrFail($id);
        return view('dasawisma.edit', compact('id'));
    }
    public function update(Request $request, $id)
    {
        // Logic to update an existing dasawisma
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'members' => 'required|array',
        ]);
        // Find the dasawisma and update it
        // $dasawisma = Dasawisma::findOrFail($id);
        // $dasawisma->update($data);
        return redirect()->route('dasawisma.index')->with('success', 'Dasawisma updated successfully.');
    }
    public function delete($id)
    {
        // Logic to delete an existing dasawisma
        // $dasawisma = Dasawisma::findOrFail($id);
        // $dasawisma->delete();
        return redirect()->route('dasawisma.index')->with('success', 'Dasawisma deleted successfully.');
    }
    public function show($id)
    {
        // Logic to show the details of a specific dasawisma
        // $dasawisma = Dasawisma::findOrFail($id);
        return view('dasawisma.show', compact('id'));
    }
}
