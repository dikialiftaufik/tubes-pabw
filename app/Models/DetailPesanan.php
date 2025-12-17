<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';
    public $timestamps = false;

    // PERBAIKAN: Sesuaikan dengan nama kolom di database (id_pesanan, id_menu)
    protected $fillable = [
        'id_pesanan', 
        'id_menu',
        'jumlah',
        'subtotal'
    ];

    public function menu()
    {
        // PERBAIKAN: Foreign key di database adalah 'id_menu'
        return $this->belongsTo(Menu::class, 'id_menu', 'id');
    }

    public function pesanan()
    {
        // PERBAIKAN: Foreign key di database adalah 'id_pesanan'
        return $this->belongsTo(Pesanan::class, 'id_pesanan', 'id_pesanan');
    }
}