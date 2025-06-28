<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryLikeController extends Controller
{
    /**
     * Menangani permintaan untuk "menyukai" item galeri.
     */
    public function store(Gallery $gallery)
    {
        // Tambah nilai kolom 'likes' sebanyak 1
        $gallery->increment('likes');

        // Kembalikan response dalam format JSON yang berisi jumlah likes terbaru
        return response()->json([
            'likes' => $gallery->likes
        ]);
    }
}
