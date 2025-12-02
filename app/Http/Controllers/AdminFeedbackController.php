<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;

class AdminFeedbackController extends Controller
{
    /**
     * Display a listing of the feedback.
     */
    public function index()
    {
        $feedbackData = Feedback::orderBy('created_at', 'desc')->get();
        return view('admin.feedback.index', compact('feedbackData'));
    }

    /**
     * Show the form for editing the specified feedback.
     */
    public function edit($id)
    {
        $feedback = Feedback::findOrFail($id);
        return response()->json($feedback);
    }

    /**
     * Update the specified feedback in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'pesan' => 'required|string',
        ]);

        $feedback = Feedback::findOrFail($id);
        $feedback->update([
            'name' => $request->nama_user,
            'judul' => $request->judul,
            'pesan' => $request->pesan,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Feedback berhasil diperbarui.'
        ]);
    }

    /**
     * Remove the specified feedback from storage.
     */
    public function destroy($id)
    {
        $feedback = Feedback::findOrFail($id);
        $feedback->delete();

        return response()->json([
            'success' => true,
            'message' => 'Feedback berhasil dihapus.'
        ]);
    }

    /**
     * Show the specified feedback.
     */
    public function show($id)
    {
        $feedback = Feedback::findOrFail($id);
        return response()->json($feedback);
    }
}