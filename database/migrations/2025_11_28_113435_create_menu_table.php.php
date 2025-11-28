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
        Schema::create('menu', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->string('foto')->nullable(); 
        $table->integer('harga');
        $table->integer('stok');
        $table->string('bahan'); 
        $table->integer('kalori');
        $table->string('kategori')->default('main course');
        $table->text('deskripsi');
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
