<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_create_services_table.php
public function up(): void
{
    Schema::create('services', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // Judul yang tampil di halaman depan
        $table->string('slug')->unique(); // Pengenal unik untuk setiap layanan
        $table->text('description')->nullable(); // Deskripsi yang bisa diubah
        $table->string('icon'); // Kita simpan ikonnya juga agar sesuai desain awal
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
