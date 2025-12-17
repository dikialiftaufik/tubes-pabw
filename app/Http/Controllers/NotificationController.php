<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notifikasi;

class NotificationController extends Controller
{
    public function index()
    {
        // AMBIL SEMUA DATA TANPA FILTER
        $notifications = Notifikasi::orderBy('created_at', 'desc')->get();

        return view('admin.notifications', compact('notifications'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul_notifikasi' => 'required|string|max:150',
            'pesan_notifikasi' => 'required|string',
        ]);

        Notifikasi::create([
            'judul_notifikasi' => $request->judul_notifikasi,
            'pesan_notifikasi' => $request->pesan_notifikasi,
            'id_user'          => 1 // atau auth()->id() nanti
        ]);

        return redirect()->back()->with('success', 'Notifikasi berhasil dibuat');
    }

    public function show($id)
    {
        return Notifikasi::where('id_notifikasi', $id)->firstOrFail();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'judul_notifikasi' => 'required|string|max:150',
            'pesan_notifikasi' => 'required|string',
        ]);

        Notifikasi::where('id_notifikasi', $id)->update([
            'judul_notifikasi' => $request->judul_notifikasi,
            'pesan_notifikasi' => $request->pesan_notifikasi,
        ]);

        return response()->json(['success' => true]);
    }

    public function destroy($id)
    {
        Notifikasi::where('id_notifikasi', $id)->delete();
        return response()->json(['success' => true]);
    }

    public function fetch()
    {
        $notifications = Notifikasi::where('id_user', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($n) {
                return [
                    'id' => $n->id_notifikasi,
                    'title' => $n->judul_notifikasi,
                    'message' => $n->pesan_notifikasi,
                    'is_read' => 0, // Default unread karena tidak ada kolom is_read
                    'created_at' => $n->created_at,
                ];
            });

        return response()->json([
            'count' => $notifications->count(),
            'list' => $notifications
        ]);
    }

}
