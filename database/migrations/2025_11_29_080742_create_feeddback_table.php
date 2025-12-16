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
        // Cek dulu apakah tabel sudah ada. Jika belum, baru buat.
        // Ini mencegah error "Table already exists"
        if (!Schema::hasTable('feedback')) {
            Schema::create('feedback', function (Blueprint $table) {
                // Sesuaikan dengan struktur SQL tubes-pabw (4).sql
                $table->integer('id_feedback', true); // Primary Key & Auto Increment
                $table->unsignedBigInteger('id_user')->nullable(); // Foreign Key
                $table->date('tgl_masukan')->nullable();
                $table->text('pesan_masukan')->nullable();
                $table->string('kategori_masukan', 100)->nullable();
                $table->string('bukti_foto', 255)->nullable();
                
                // Timestamp tidak ada di SQL asli, tapi jika ingin dipakai di Laravel:
                // $table->timestamps(); 
                
                // Definisi Foreign Key
                $table->foreign('id_user')
                      ->references('id')
                      ->on('users')
                      ->onDelete('cascade')
                      ->onUpdate('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('feedback');
    }
};