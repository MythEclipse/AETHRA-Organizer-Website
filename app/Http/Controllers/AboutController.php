<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\About;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function index()
    {
        // Ambil record pertama, karena hanya ada satu
        $about = About::first();
        return view('admin.about.index', compact('about'));
    }

    public function update(Request $request)
    {
        $about = About::first(); // Ambil record pertama untuk diupdate

        $request->validate([
            'headline' => 'required|string|max:255',
            'paragraph_1' => 'required|string',
            'paragraph_2' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($about->image) {
                Storage::disk('public')->delete($about->image);
            }

            $filename = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();
            $request->file('image')->storeAs('about', $filename, 'public');
            $data['image'] = 'about/' . $filename;
        }


        $about->update($data);

        return redirect()->back()->with('success', 'Konten Halaman About Us berhasil diperbarui.');
    }
}
