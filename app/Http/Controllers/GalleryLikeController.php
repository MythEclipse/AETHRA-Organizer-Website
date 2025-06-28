<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryLikeController extends Controller
{
    public function store(Gallery $gallery)
    {
        $gallery->increment('likes');
        return response()->json(['likes' => $gallery->likes]);
    }
}
