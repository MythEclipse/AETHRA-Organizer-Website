<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_xxxxxx_modify_messages_to_conversations_table.php
    public function up(): void
    {
        // Ganti nama tabel
        Schema::rename('messages', 'conversations');

        // Tambahkan kolom baru ke tabel yang sudah di-rename
        Schema::table('conversations', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable()->after('id');
            $table->boolean('is_admin_reply')->default(false)->after('user_id');

            // Membuat relasi ke dirinya sendiri untuk balasan
            $table->foreign('parent_id')->references('id')->on('conversations')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('conversations', function (Blueprint $table) {
            //
        });
    }
};
