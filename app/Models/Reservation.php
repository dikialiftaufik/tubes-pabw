<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservasi';
    protected $primaryKey = 'id_reservasi';

    protected $fillable = [
        'id_user',
        'nama_pemesan',
        'jml_org',
        'tgl_reservasi',
        'jam_mulai',
        'jam_selesai',
        'status_reservasi'
    ];

    /* ===== ACCESSOR AGAR VIEW TIDAK DIUBAH ===== */

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

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
