<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{
    /* ================= USER ================= */

    // form feedback user
    public function index()
    {
        return view('feedback');
    }

    // simpan feedback user
    public function store(Request $request)
    {
        $request->validate([
            'kategori_masukan' => 'required|string|max:100',
            'pesan_masukan'    => 'required|string',
        ]);

        Feedback::create([
            'id_user'          => Auth::id(),
            'tgl_masukan'      => now()->toDateString(),
            'kategori_masukan' => $request->kategori_masukan,
            'pesan_masukan'    => $request->pesan_masukan,
        ]);

        return redirect()->back()->with('success', 'Masukan berhasil dikirim');
    }

    /* ================= ADMIN ================= */

    // dashboard feedback admin
    public function adminIndex()
    {
        $feedbackData = Feedback::orderBy('tgl_masukan', 'desc')->get();
        return view('admin.feedback', compact('feedbackData'));
    }

    // update feedback
    public function update(Request $request, $id)
    {
        $request->validate([
            'kategori_masukan' => 'required',
            'pesan_masukan'    => 'required',
        ]);

        Feedback::where('id_feedback', $id)->update([
            'kategori_masukan' => $request->kategori_masukan,
            'pesan_masukan'    => $request->pesan_masukan,
        ]);

        return response()->json(['success' => true]);
    }

    // hapus feedback
    public function destroy($id)
    {
        Feedback::where('id_feedback', $id)->delete();
        return response()->json(['success' => true]);
    }
}
