<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GiziController extends Controller
{
    public function index()
    {
        // Logic to retrieve and display Gizi data
        return view('gizi.index');
    }
}
