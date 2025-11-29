<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();

            // Relasi ke user (pembeli)
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');

            // Kode pesanan unik
            $table->string('kode_pesanan')->unique();

            // Total harga
            $table->integer('total_harga')->default(0);

            // Status pesanan
            $table->enum('status', ['Belum Dibayar', 'Sudah Dibayar', 'Diproses', 'Selesai'])
                  ->default('Belum Dibayar');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
