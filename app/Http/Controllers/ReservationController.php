<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    public function store(Request $request)
{
    $request->validate([
        'jml_org'       => 'required|integer|min:1',
        'tgl_reservasi' => 'required|date',
        'jam_mulai'     => 'required',
    ]);

    Reservation::create([
        'id_user'          => Auth::id(),
        'nama_pemesan'     => Auth::user()->name,
        'jml_org'          => $request->jml_org,
        'tgl_reservasi'    => $request->tgl_reservasi,
        'jam_mulai'        => $request->jam_mulai,
        'status_reservasi' => 'pending',
    ]);

    return redirect('/')->with('success', 'Reservasi berhasil dikirim');
    }

    public function index()
    {
        $reservations = Reservation::orderBy('tgl_reservasi')->get();
        return view('admin.reservations', compact('reservations'));
    }

    public function show($id)
    {
        return Reservation::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        Reservation::findOrFail($id)->update([
            'nama_pemesan'    => $request->nama_pemesan,
            'jml_org'         => $request->jml_org,
            'tgl_reservasi'   => $request->tgl_reservasi,
            'jam_mulai'       => $request->jam_mulai,
            'status_reservasi'=> strtolower($request->status_reservasi)
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Reservation::findOrFail($id)->delete();
        return response()->json(['success' => true]);
    }
}
