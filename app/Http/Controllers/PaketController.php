<?php

namespace App\Http\Controllers;

use App\Models\Paket;
use App\Models\Fitur;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaketController extends Controller
{
    /**
     * Menampilkan daftar semua paket.
     */
    public function index()
    {
        // Mengambil data paket dengan relasi fiturs untuk Eager Loading
        $pakets = Paket::with('fiturs')->latest()->paginate(10);
        return view('admin.pakets.index', compact('pakets'));
    }

    /**
     * Menampilkan form untuk membuat paket baru.
     */
    public function create()
    {
        // Mengambil semua fitur untuk ditampilkan sebagai pilihan di form
        $fiturs = Fitur::all();
        return view('admin.pakets.create', compact('fiturs'));
    }

    /**
     * Menyimpan paket baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'fiturs' => 'nullable|array',
            'fiturs.*' => 'exists:fiturs,id' // Memastikan semua id fitur valid
        ]);

        $paket = Paket::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'description' => $request->description,
            'price' => $request->price,
        ]);

        // Menyambungkan paket dengan fitur yang dipilih menggunakan sync()
        $paket->fiturs()->sync($request->input('fiturs', []));

        return redirect()->route('pakets.index')->with('success', 'Paket berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit paket.
     */
    public function edit(Paket $paket)
    {
        $fiturs = Fitur::all();
        return view('admin.pakets.edit', compact('paket', 'fiturs'));
    }

    /**
     * Memperbarui data paket di database.
     */
    public function update(Request $request, Paket $paket)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'fiturs' => 'nullable|array',
            'fiturs.*' => 'exists:fiturs,id'
        ]);

        $paket->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name, '-'),
            'description' => $request->description,
            'price' => $request->price,
        ]);

        // Sinkronisasi ulang hubungan dengan fitur
        $paket->fiturs()->sync($request->input('fiturs', []));

        return redirect()->route('pakets.index')->with('success', 'Paket berhasil diperbarui.');
    }

    /**
     * Menghapus paket dari database.
     */
    public function destroy(Paket $paket)
    {
        $paket->delete();
        return redirect()->route('pakets.index')->with('success', 'Paket berhasil dihapus.');
    }
}
