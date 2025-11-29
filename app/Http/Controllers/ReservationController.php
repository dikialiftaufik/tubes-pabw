<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required',
            'time'   => 'required',
            'date'   => 'required',
            'people' => 'required|integer|min=1',
            'message'=> 'nullable'
        ]);

        Reservation::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'name'    => $request->name,
            'time'    => $request->time,
            'date'    => $request->date,
            'people'  => $request->people,
            'message' => $request->message,
            'status'  => 'Pending'
        ]);

        return redirect('/')->with('success', 'Reservasi Berhasil Dikirim!');
    }
}
