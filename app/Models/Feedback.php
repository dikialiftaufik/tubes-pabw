<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feedback';
    protected $primaryKey = 'id_feedback';
    public $timestamps = false;

    protected $fillable = [
        'id_user',
        'tgl_masukan',
        'pesan_masukan',
        'kategori_masukan',
        'bukti_foto'
    ];

    /* =======================
       ACCESSOR (UNTUK VIEW)
       ======================= */

    public function getIdAttribute()
    {
        return $this->id_feedback;
    }

    public function getNameAttribute()
    {
        return $this->kategori_masukan;
    }

    public function getJudulAttribute()
    {
        return $this->kategori_masukan;
    }

    public function getPesanAttribute()
    {
        return $this->pesan_masukan;
    }

    public function getCreatedAtAttribute()
    {
        return $this->tgl_masukan;
    }

    /* =======================
       RELATION
       ======================= */
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
