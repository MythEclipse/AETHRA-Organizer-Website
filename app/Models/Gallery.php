<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Gallery extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'image',
        'description',
        'likes',
    ];

    /**
     * Get the image URL for the gallery.
     *
     * @return string|null
     */
    public function getImageUrlAttribute()
    {
        // Jika 'image' kosong atau null, kembalikan gambar placeholder/default
        if (empty($this->image)) {
            return asset('images/default_gallery.jpg'); // Sesuaikan dengan path gambar default Anda
        }

        // Periksa apakah ini adalah URL eksternal (dimulai dengan http:// atau https://)
        if (filter_var($this->image, FILTER_VALIDATE_URL)) {
            return $this->image; // Langsung kembalikan URL eksternal
        }

        // Jika bukan URL eksternal, asumsikan itu adalah path storage internal
        // Pastikan file ada di storage yang dikonfigurasi
        // Anda bisa menambahkan pengecekan exists() jika ingin fallback ke default image
        if (Storage::disk('public')->exists($this->image)) {
            return asset('storage/' . $this->image);
        }

        // Fallback jika file storage tidak ditemukan (tapi ada path-nya)
        return asset('images/broken_image.jpg'); // Misalnya, gambar 'gambar tidak ditemukan'
    }
}
