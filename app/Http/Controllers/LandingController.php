<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil semua paket beserta relasi fiturnya
        $pakets = Paket::with('fiturs')->get();
        return view('welcome', compact('pakets'));
    }
}
