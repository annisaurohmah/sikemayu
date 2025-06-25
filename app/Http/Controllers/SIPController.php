<?php

namespace App\Http\Controllers;

use App\Models\Posyandu;
use App\Models\Sip1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Sip2;
use App\Models\Sip3;

class SIPController extends Controller
{
    public function index($posyandu_id)
    {
        //sip format 1
        $format1 = Sip1::where('posyandu_id', $posyandu_id)->get();
        $posyandu = Posyandu::find($posyandu_id);

        //sip format 2
        $bayiList = Sip2::with([
            'penimbangan',
            'asi',
            'pelayanan',
            'imunisasi',
            'keteranganBalita',
            'dasawisma',
        ])->where('posyandu_id', $posyandu_id)->get();

         $balitaList = Sip3::with([
            'penimbangan',
            'pelayanan',
            'imunisasi',
            'keteranganBalita',
            'dasawisma',
        ])->where('posyandu_id', $posyandu_id)->get();





        return view('sip.index', compact('posyandu_id', 'posyandu', 'format1', 'bayiList', 'balitaList'));
    }
}
