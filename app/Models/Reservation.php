<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservasi'; // Table yang benar
    protected $primaryKey = 'id_reservasi'; // Primary key yang benar

    protected $fillable = [
        'id_user',
        'nama_pemesan',
        'jml_org',
        'tgl_reservasi',
        'jam_mulai',
        'jam_selesai',
        'status_reservasi',
    ];

    /* ===== ACCESSOR AGAR KODE LAMA TETAP JALAN ===== */
    // Ini tambahan dari teman kamu, kita simpan karena berguna
    public function getIdAttribute()
    {
        return $this->id_reservasi;
    }
    public function getNameAttribute()
    {
        return $this->nama_pemesan;
    }
    public function getPeopleAttribute()
    {
        return $this->jml_org;
    }
    public function getDateAttribute()
    {
        return $this->tgl_reservasi;
    }
    public function getTimeAttribute()
    {
        return $this->jam_mulai;
    }
    public function getStatusAttribute()
    {
        return ucfirst($this->status_reservasi);
    }

    // relasi ke user
    public function user()
    {
        // PAKE YG INI: key di user adalah 'id', bukan 'id_user'
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
