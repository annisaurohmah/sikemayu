<?php

namespace App\Http\Controllers;

use App\Models\Anak;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        // Logic to store bayi or balita data
        // Validate and save the data
        return redirect()->route('bayi_balita.index')->with('success', 'Data saved successfully.');
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

    public function update(Request $request, $id)
    {
        // Logic to update bayi or balita data
        return redirect()->route('bayi_balita.index')->with('success', 'Data updated successfully.');
    }

    public function destroy($id)
    {
        // Logic to delete a specific bayi or balita
        return redirect()->route('bayi_balita.index')->with('success', 'Data deleted successfully.');
    }
}
