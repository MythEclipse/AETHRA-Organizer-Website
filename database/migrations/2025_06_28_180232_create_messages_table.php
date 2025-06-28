<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  // database/migrations/xxxx_xx_xx_xxxxxx_create_messages_table.php
public function up(): void
{
    Schema::create('messages', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Siapa yang mengirim
        $table->string('name');
        $table->string('email');
        $table->string('phone_number')->nullable();
        $table->string('subject');
        $table->text('message');
        $table->boolean('is_read')->default(false); // Status pesan (sudah dibaca/belum)
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
