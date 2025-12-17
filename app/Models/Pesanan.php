<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    // PENTING: Primary key di database baru adalah 'id_pesanan'
    protected $primaryKey = 'id_pesanan';

    // Kolom sesuai tubes-pabw (4).sql
    protected $fillable = [
        'id_user',          // Menggantikan user_id
        'id_kasir',
        'id_reservasi',
        'tanggal',
        'total_hrg',        // Menggantikan total_harga
        'status_pesanan',   // Menggantikan status
        'status_pembayaran',
        'metode_pembayaran'
    ];

    public function user()
    {
        // Relasi ke tabel users (id) melalui kolom id_user di tabel pesanan
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function detailPesanan()
    {
        // Relasi ke detail_pesanan melalui id_pesanan
        return $this->hasMany(DetailPesanan::class, 'id_pesanan', 'id_pesanan');
    }

    public function reservasi()
    {
        return $this->belongsTo(Reservation::class, 'id_reservasi', 'id_reservasi');
    }

    public function kasir()
    {
        return $this->belongsTo(User::class, 'id_kasir', 'id');
    }
}