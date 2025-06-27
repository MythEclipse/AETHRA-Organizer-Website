<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Service;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    public function index()
    {
        // Ambil semua paket beserta relasi fiturnya
        $pakets = Paket::with('fiturs')->get();
        $services = Service::all(); // <-- Pastikan baris ini ada
        return view('welcome', compact('pakets', 'services'));
    }
}
