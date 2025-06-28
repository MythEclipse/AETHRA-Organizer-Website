<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Gallery;

class GallerySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus data lama agar tidak duplikat saat seeding ulang
        // Gallery::truncate();

        $galleries = [
            [
                'title' => 'Pernikahan Modern',
                'description' => 'Momen indah dari pernikahan modern dengan tema minimalis di outdoor.',
                'image' => 'https://images.unsplash.com/photo-1519741497674-611481863552?q=80&w=1470',
            ],
            [
                'title' => 'Konser Musik Indie',
                'description' => 'Suasana energik dari konser musik indie yang dihadiri ribuan penonton.',
                'image' => 'https://images.unsplash.com/photo-1524368535928-5b5e00ddc76b?q=80&w=1470',
            ],
            [
                'title' => 'Ulang Tahun Anak',
                'description' => 'Keceriaan pesta ulang tahun anak dengan tema superhero dan dekorasi penuh warna.',
                'image' => 'https://images.unsplash.com/photo-1560352058-db782104a3f3?q=80&w=1470',
            ],
            [
                'title' => 'Acara Korporat',
                'description' => 'Suasana formal namun hangat dari acara penghargaan tahunan perusahaan.',
                'image' => 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?q=80&w=1470',
            ],
            [
                'title' => 'Pesta Kebun Santai',
                'description' => 'Momen kebersamaan dalam acara pesta kebun di sore hari.',
                'image' => 'https://images.unsplash.com/photo-1561722883-8395c73a3c20?q=80&w=1470',
            ],
            [
                'title' => 'Pameran Seni Kreatif',
                'description' => 'Karya-karya inspiratif yang ditampilkan dalam pameran seni lokal.',
                'image' => 'https://images.unsplash.com/photo-1582555172866-f73bb12a2ab3?q=80&w=1470',
            ],
        ];

        foreach ($galleries as $gallery) {
            // Gunakan updateOrCreate untuk menghindari duplikat berdasarkan judul
            Gallery::updateOrCreate(['title' => $gallery['title']], $gallery);
        }
    }
}
