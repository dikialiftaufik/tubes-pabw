<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Pesanan extends Model
{
    protected $table = 'pesanan';
    protected $primaryKey = 'id_pesanan';
    protected $fillable = [
        'id_user', 'tanggal', 'total_hrg', 
        'status_pesanan', 'status_pembayaran', 'metode_pembayaran'
    ];
    public function details() {
        return $this->hasMany(DetailPesanan::class, 'id_pesanan');
    }
}