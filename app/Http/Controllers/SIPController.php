<?php

namespace App\Http\Controllers;
use App\Models\Posyandu;

use Illuminate\Http\Request;

class SIPController extends Controller
{
    public function index($posyandu_id)
    {
        // Ensure the posyandu_id is valid and exists in the database
        // You might want to add validation or a check here
        if (!is_numeric($posyandu_id)) {
            abort(404, 'Posyandu not found');
        }
        
        // You can fetch the posyandu details from the database if needed
        $posyandu = Posyandu::findOrFail($posyandu_id);

        return view('sip.index', compact('posyandu_id', 'posyandu'));
    }
}
