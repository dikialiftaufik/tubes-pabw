<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'user_id',
        'tanggal',
        'total_harga',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // PERBAIKAN: Ubah nama method dari 'detail' menjadi 'detailPesanan'
    // Ini agar cocok dengan controller: Pesanan::with('detailPesanan')
    public function detailPesanan() 
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }
}