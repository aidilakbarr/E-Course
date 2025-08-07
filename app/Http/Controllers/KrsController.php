<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateKrsPdf;
use App\Models\Krs;
use App\Models\Mahasiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class KrsController extends Controller
{
    public function index()
    {
        return view('public.krs.index', );
    }


}
