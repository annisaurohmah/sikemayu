<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rw; // Assuming you have a Rw model

class RWController extends Controller
{
    public function index()
    {
        $rw = Rw::all(); // Assuming you have a RW model

        // Logic to retrieve and display RW data
        return view('masterdata.rw', compact('rw'));
    }   
}
