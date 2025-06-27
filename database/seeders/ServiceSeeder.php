<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'venue selection',
                'slug' => 'venue-selection',
                'icon' => 'fas fa-map-marker-alt',
                'description' => 'Kami bantu Anda menemukan dan memilih lokasi terbaik yang sesuai dengan tema dan kapasitas acara Anda.'
            ],
            [
                'title' => 'invitation card',
                'slug' => 'invitation-card',
                'icon' => 'fas fa-envelope',
                'description' => 'Desain undangan yang eksklusif dan personal untuk mengumumkan momen spesial Anda kepada para tamu.'
            ],
            [
                'title' => 'entertainment',
                'slug' => 'entertainment',
                'icon' => 'fas fa-music',
                'description' => 'Menyediakan berbagai pilihan hiburan, mulai dari live music, DJ, hingga pertunjukan seni untuk memeriahkan acara.'
            ],
            [
                'title' => 'food and drinks',
                'slug' => 'food-and-drinks',
                'icon' => 'fas fa-utensils',
                'description' => 'Pilihan menu katering yang lezat dan beragam, disajikan dengan standar kualitas dan kebersihan tertinggi.'
            ],
            [
                'title' => 'photos and videos',
                'slug' => 'photos-and-videos',
                'icon' => 'fas fa-photo-video',
                'description' => 'Tim dokumentasi profesional kami siap mengabadikan setiap momen berharga Anda dalam bentuk foto dan video sinematik.'
            ],
            [
                'title' => 'custom food',
                'slug' => 'custom-food',
                'icon' => 'fas fa-birthday-cake',
                'description' => 'Layanan kustomisasi menu, termasuk kue spesial dan hidangan penutup sesuai dengan tema dan selera Anda.'
            ],
        ];

        foreach ($services as $service) {
            // Gunakan updateOrCreate agar data tidak duplikat jika seeder dijalankan lagi
            Service::updateOrCreate(['slug' => $service['slug']], $service);
        }
    }
}
