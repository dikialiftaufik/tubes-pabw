<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    protected $table = 'reservations'; // sesuai migration kamu

    protected $fillable = [
        'user_id',
        'name',
        'time',
        'date',
        'people',
        'message',
        'status',
    ];

    // relasi ke user (opsional)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
