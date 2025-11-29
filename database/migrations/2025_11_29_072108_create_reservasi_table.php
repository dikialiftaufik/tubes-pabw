<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservasi', function (Blueprint $table) {
            $table->id();

            // Jika memakai login user
            $table->unsignedBigInteger('user_id')->nullable();

            $table->string('nama_pelanggan');
            $table->string('no_hp', 20);
            $table->unsignedBigInteger('meja_id')->nullable();
            $table->date('tanggal');
            $table->time('waktu');
            $table->integer('jumlah_orang');

            // status: pending, dikonfirmasi, dibatalkan
            $table->enum('status', ['pending', 'dikonfirmasi', 'dibatalkan'])->default('pending');

            $table->text('catatan')->nullable();

            $table->timestamps();

            // Foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservasi');
    }
};
