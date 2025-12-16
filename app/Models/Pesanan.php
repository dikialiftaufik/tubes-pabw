<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
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