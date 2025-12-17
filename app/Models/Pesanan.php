<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';
    
    // TAMBAHKAN INI: Karena primary key di DB adalah 'id_pesanan', bukan 'id'
    protected $primaryKey = 'id_pesanan';

    // PERBAIKAN: Sesuaikan dengan nama kolom asli di database (tubes-pabw.sql)
    protected $fillable = [
        'id_user',         // Bukan 'user_id'
        'id_kasir', 
        'id_reservasi',
        'tanggal', 
        'total_hrg',       // Bukan 'total_harga'
        'status_pesanan',  // Bukan 'status'
        'status_pembayaran',
        'metode_pembayaran'
    ];

    public function user()
    {
        // PERBAIKAN: Foreign key di tabel pesanan adalah 'id_user'
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function detailPesanan()
    {
        // PERBAIKAN: Foreign key di tabel detail_pesanan adalah 'id_pesanan'
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