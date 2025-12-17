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

    // relasi ke user
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
