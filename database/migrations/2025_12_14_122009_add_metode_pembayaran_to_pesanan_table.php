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
        Schema::table('pesanan', function (Blueprint $table) {
            // Cek dulu apakah kolom sudah ada agar tidak duplicate error
            if (!Schema::hasColumn('pesanan', 'metode_pembayaran')) {
                // PERBAIKAN: Ubah 'status' menjadi 'status_pesanan' 
                // (sesuai nama kolom yang ada di database Anda)
                $table->string('metode_pembayaran')->nullable()->after('status_pesanan');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            if (Schema::hasColumn('pesanan', 'metode_pembayaran')) {
                $table->dropColumn('metode_pembayaran');
            }
        });
    }
};