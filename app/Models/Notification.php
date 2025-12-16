<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    // 1. Sesuaikan nama tabel dengan SQL
    protected $table = 'notifikasi';

    // 2. Sesuaikan Primary Key
    protected $primaryKey = 'id_notifikasi';

    // 3. Sesuaikan kolom yang bisa diisi (Fillable)
    protected $fillable = [
        'id_user',           // SQL: id_user
        'judul_notifikasi',  // SQL: judul_notifikasi
        'pesan_notifikasi',  // SQL: pesan_notifikasi
        'gambar_notifikasi', // SQL: gambar_notifikasi
        // 'is_read' dihapus karena tidak ada di tabel SQL Anda
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    // Relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}