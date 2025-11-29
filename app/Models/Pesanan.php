<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    protected $table = 'pesanan'; // sesuai nama tabelmu
    protected $fillable = ['user_id','tanggal','total_harga','status'];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function detail()
    {
        return $this->hasMany(\App\Models\DetailPesanan::class, 'pesanan_id');
    }
}
