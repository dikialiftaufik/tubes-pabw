<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_pesanan';
    public $incrementing = true;
    protected $table = 'pesanan';

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id', 'id_pesanan');
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