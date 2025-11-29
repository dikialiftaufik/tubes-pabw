<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_pesanan', function (Blueprint $table) {
            $table->id();

            // Relasi ke pesanan
            $table->foreignId('pesanan_id')->constrained('pesanan')->onDelete('cascade');

            // Relasi ke menu
            $table->foreignId('menu_id')->constrained('menu')->onDelete('cascade');

            $table->integer('jumlah')->default(1);
            $table->integer('subtotal')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_pesanan');
    }
};
