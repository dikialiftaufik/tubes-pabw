<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feeddback extends Model
{
    protected $table = 'feeddback';

    protected $fillable = [
        'nama',
        'judul',
        'pesan',
    ];
}
