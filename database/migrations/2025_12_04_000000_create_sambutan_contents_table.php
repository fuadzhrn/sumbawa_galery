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
        Schema::create('sambutan_contents', function (Blueprint $table) {
            $table->id();
            
            // Hero Section
            $table->string('hero_image')->default('assets/images/img1.png');
            
            // Visi
            $table->string('visi_image')->default('assets/images/visi.jpg');
            $table->longText('visi_text')->nullable();
            
            // Misi
            $table->string('misi_image')->default('assets/images/misi.jpg');
            $table->longText('misi_text')->nullable();
            
            // Objective 1
            $table->string('obj1_image')->default('assets/images/objective1.jpg');
            $table->string('obj1_title')->default('Dokumentasi Komprehensif');
            $table->longText('obj1_deskripsi')->nullable();
            
            // Objective 2
            $table->string('obj2_image')->default('assets/images/objective2.jpg');
            $table->string('obj2_title')->default('Akses Mudah');
            $table->longText('obj2_deskripsi')->nullable();
            
            // Objective 3
            $table->string('obj3_image')->default('assets/images/objective3.jpg');
            $table->string('obj3_title')->default('Promosi Budaya');
            $table->longText('obj3_deskripsi')->nullable();
            
            // Objective 4
            $table->string('obj4_image')->default('assets/images/objective4.jpg');
            $table->string('obj4_title')->default('Pelestarian Warisan');
            $table->longText('obj4_deskripsi')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sambutan_contents');
    }
};
