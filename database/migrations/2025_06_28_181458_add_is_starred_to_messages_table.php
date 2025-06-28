<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_xx_xx_xxxxxx_add_is_starred_to_messages_table.php
public function up(): void
{
    Schema::table('messages', function (Blueprint $table) {
        $table->boolean('is_starred')->default(false)->after('is_read');
    });
}

public function down(): void
{
    Schema::table('messages', function (Blueprint $table) {
        $table->dropColumn('is_starred');
    });
}
};
