<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    // Menampilkan halaman form checkout
    public function show(Paket $paket)
    {
        return view('checkout', compact('paket'));
    }

    // Memproses dan menyimpan transaksi
    public function store(Request $request)
    {
        $request->validate([
            'paket_id' => 'required|exists:pakets,id',
            'event_date' => 'required|date|after_or_equal:today',
        ]);

        $paket = Paket::findOrFail($request->paket_id);

        $transaksi = Transaksi::create([
            'transaction_code' => 'TRX-' . date('Ymd') . '-' . Str::upper(Str::random(5)),
            'user_id' => Auth::id(),
            'paket_id' => $paket->id,
            'event_date' => $request->event_date,
            'total_amount' => $paket->price,
            'status' => 'PENDING',
        ]);

        return redirect()->route('my-transactions')->with('success', 'Pemesanan berhasil! Silakan selesaikan pembayaran.');
    }

    // Menampilkan halaman riwayat transaksi milik user yang sedang login
    public function myTransactions()
    {
        $transaksis = Transaksi::where('user_id', Auth::id())
                                ->with('paket')
                                ->latest()
                                ->paginate(10);

        return view('my-transactions', compact('transaksis'));
    }
}
