<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';

    protected $fillable = [
        'judul_notifikasi',
        'pesan_notifikasi',
        'gambar_notifikasi',
        'id_user'
    ];
}
