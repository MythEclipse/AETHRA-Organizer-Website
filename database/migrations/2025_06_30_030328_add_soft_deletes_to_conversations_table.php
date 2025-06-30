<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_xx_xx_xxxxxx_add_soft_deletes_to_conversations_table.php
public function up(): void
{
    Schema::table('conversations', function (Blueprint $table) {
        $table->softDeletes(); // Ini akan menambahkan kolom 'deleted_at'
    });
}

public function down(): void
{
    Schema::table('conversations', function (Blueprint $table) {
        $table->dropSoftDeletes();
    });
}
};
