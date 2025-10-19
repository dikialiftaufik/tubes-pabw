<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = [
            [
                'id' => 1,
                'customer_name' => 'Zufar',
                'date' => '2025-10-22',
                'time' => '18:30',
                'people' => 4,
                'status' => 'Confirmed',
            ],
            [
                'id' => 2,
                'customer_name' => 'Amara',
                'date' => '2025-10-23',
                'time' => '19:00',
                'people' => 2,
                'status' => 'Pending',
            ],
        ];

        return view('admin.reservations', ['reservations' => $reservations]);
    }
}
