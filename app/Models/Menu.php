<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Menu extends Model
{
    use HasFactory;

    protected $table = 'menu'; 
    protected $fillable = [
        'nama', 'foto', 'harga', 'stok', 'bahan', 'kalori', 'kategori', 'deskripsi'
    ];
}
