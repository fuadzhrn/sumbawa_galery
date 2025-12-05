<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('karya_seni', function (Blueprint $table) {
            $table->integer('views')->default(0)->after('alasan_penolakan');
            $table->integer('likes')->default(0)->after('views');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('karya_seni', function (Blueprint $table) {
            $table->dropColumn(['views', 'likes']);
        });
    }
};
