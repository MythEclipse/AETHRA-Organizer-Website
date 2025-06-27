<?php

// database/migrations/xxxx_xx_xx_xxxxxx_create_transaksis_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_code')->unique(); // Kode unik transaksi, misal: TRX-20250627-001

            // Relasi ke User dan Paket
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('paket_id')->constrained()->onDelete('cascade');

            $table->date('event_date'); // Tanggal acara yang dipesan
            $table->unsignedBigInteger('total_amount'); // Total harga saat transaksi

            // Status transaksi: PENDING, PAID, SUCCESS, CANCELLED, FAILED
            $table->enum('status', ['PENDING', 'PAID', 'SUCCESS', 'CANCELLED', 'FAILED'])->default('PENDING');

            $table->string('payment_method')->nullable(); // Metode pembayaran
            $table->string('payment_proof')->nullable(); // Path bukti pembayaran jika transfer manual

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
