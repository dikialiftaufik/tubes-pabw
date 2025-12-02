<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $table = 'feeddback';

    /**
     * Kolom yang dapat diisi secara massal.
     */
    protected $fillable = [
        'name',
        'judul',
        'pesan',
        'created_at',
        'updated_at'
    ];

    /**
     * Kolom yang harus di-cast ke tipe data tertentu.
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Accessor untuk nama_user (alias dari name)
     */
    public function getNamaUserAttribute()
    {
        return $this->name;
    }

    /**
     * Accessor untuk tanggal (alias dari created_at)
     */
    public function getTanggalAttribute()
    {
        return $this->created_at;
    }
}