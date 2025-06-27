<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksis = Transaksi::with(['user', 'paket'])->latest()->paginate(15);
        return view('admin.transaksis.index', compact('transaksis'));
    }

    public function show(Transaksi $transaksi)
    {
        return view('admin.transaksis.show', compact('transaksi'));
    }

    public function updateStatus(Request $request, Transaksi $transaksi)
    {
        $request->validate([
            'status' => 'required|in:PENDING,PAID,SUCCESS,CANCELLED,FAILED',
        ]);

        $transaksi->update(['status' => $request->status]);

        return redirect()->route('admin.transaksis.show', $transaksi)->with('success', 'Status transaksi berhasil diperbarui.');
    }
}
