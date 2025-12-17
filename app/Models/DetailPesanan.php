<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';
    public $timestamps = false;

    // Sesuaikan dengan kolom di database baru
    protected $fillable = [
        'id_pesanan', // Menggantikan pesanan_id
        'id_menu',    // Menggantikan menu_id
        'jumlah',
        'subtotal'
    ];

    public function menu()
    {
        return $this->belongsTo(Menu::class, 'id_menu', 'id');
    }

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
}