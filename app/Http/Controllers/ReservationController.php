<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class ReservationController extends Controller
{
    // landing page
    public function store(Request $request)
    {
        $request->validate([
            'name'   => 'required',
            'time'   => 'required',
            'date'   => 'required',
            'people' => 'required|integer|min:1',
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

    // dashboard admin
    public function index()
    {
        $reservations = Reservation::orderBy('date', 'asc')->get();
        return view('admin.reservations', compact('reservations'));
    }

    // view 
    public function show($id)
    {
        return Reservation::findOrFail($id);
    }

    // update
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'name'   => 'required|string',
            'date'   => 'required|date',
            'time'   => 'required',
            'people' => 'required|integer',
            'message'=> 'nullable|string',
            'status' => 'required|string'
        ]);

        $reservation->update([
            'name'    => $request->name,
            'date'    => $request->date,
            'time'    => $request->time,
            'people'  => $request->people,
            'message' => $request->message,
            'status'  => $request->status
        ]);

        return response()->json(['success' => true]);
    }

    // delete
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return response()->json(['success' => true]);
    }
}
