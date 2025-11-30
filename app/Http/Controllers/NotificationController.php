<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Method untuk API/Landing Page - Mengambil notifikasi user
     */
    public function fetch()
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'count' => 0,
                'list' => []
            ]);
        }

        // Ambil notifikasi untuk user yang login DAN notifikasi umum (NULL)
        $notifications = Notification::where(function($query) use ($user) {
                $query->where('user_id', $user->id)
                      ->orWhereNull('user_id');
            })
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $unreadCount = $notifications->where('is_read', 0)->count();

        return response()->json([
            'count' => $unreadCount,
            'list' => $notifications
        ]);
    }

    /**
     * Method untuk Admin Dashboard - Menandai notifikasi sebagai sudah dibaca
     */
    public function markAsRead($id)
    {
        try {
            $notification = Notification::findOrFail($id);
            $notification->update(['is_read' => 1]);

            return response()->json([
                'success' => true,
                'message' => 'Notifikasi telah ditandai sebagai dibaca'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menandai notifikasi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Method untuk Admin Dashboard - Menandai semua notifikasi sebagai sudah dibaca
     */
    public function markAllAsRead()
    {
        try {
            Notification::where('is_read', 0)->update(['is_read' => 1]);

            return response()->json([
                'success' => true,
                'message' => 'Semua notifikasi telah ditandai sebagai dibaca'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menandai notifikasi: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * ADMIN DASHBOARD METHODS
     */

    /**
     * Display a listing of the resource for admin.
     * Hanya tampilkan notifikasi untuk semua user (user_id = NULL)
     */
    public function index()
    {
        $notifications = Notification::whereNull('user_id')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.notifications', compact('notifications'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.notifications.create');
    }

    /**
     * Store a newly created resource in storage.
     * Otomatis set user_id menjadi NULL untuk notifikasi umum
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'message' => 'required|string',
            'is_read' => 'boolean'
        ]);

        try {
            Notification::create([
                'title' => $request->title,
                'message' => $request->message,
                'user_id' => null, // Selalu NULL untuk notifikasi di admin (notifikasi umum)
                'is_read' => $request->is_read ?? 0,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => 'Notifikasi berhasil dibuat']);
            }

            return redirect()->route('admin.notifications.index')
                ->with('success', 'Notifikasi berhasil dibuat');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Gagal membuat notifikasi: ' . $e->getMessage()], 500);
            }

            return redirect()->back()
                ->with('error', 'Gagal membuat notifikasi: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $notification = Notification::whereNull('user_id')->findOrFail($id);
            
            // Return JSON for AJAX requests
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json($notification);
            }
            
            return view('admin.notifications.show', compact('notification'));
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Notifikasi tidak ditemukan'], 404);
            }
            return redirect()->route('admin.notifications.index')
                ->with('error', 'Notifikasi tidak ditemukan');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $notification = Notification::whereNull('user_id')->findOrFail($id);
            
            // Return JSON for AJAX requests
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json($notification);
            }
            
            return view('admin.notifications.edit', compact('notification'));
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Notifikasi tidak ditemukan'], 404);
            }
            return redirect()->route('admin.notifications.index')
                ->with('error', 'Notifikasi tidak ditemukan');
        }
    }

    /**
     * Update the specified resource in storage.
     * Pastikan user_id tetap NULL untuk notifikasi umum
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'message' => 'required|string',
            'is_read' => 'boolean'
        ]);

        try {
            $notification = Notification::whereNull('user_id')->findOrFail($id);
            $notification->update([
                'title' => $request->title,
                'message' => $request->message,
                'user_id' => null, // Tetap NULL untuk notifikasi umum
                'is_read' => $request->is_read ?? $notification->is_read,
                'updated_at' => now()
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['success' => 'Notifikasi berhasil diperbarui']);
            }

            return redirect()->route('admin.notifications.index')
                ->with('success', 'Notifikasi berhasil diperbarui');
        } catch (\Exception $e) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Gagal memperbarui notifikasi: ' . $e->getMessage()], 500);
            }

            return redirect()->back()
                ->with('error', 'Gagal memperbarui notifikasi: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $notification = Notification::whereNull('user_id')->findOrFail($id);
            $notification->delete();

            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['success' => 'Notifikasi berhasil dihapus']);
            }

            return redirect()->route('admin.notifications.index')
                ->with('success', 'Notifikasi berhasil dihapus');
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Gagal menghapus notifikasi: ' . $e->getMessage()], 500);
            }

            return redirect()->route('admin.notifications.index')
                ->with('error', 'Gagal menghapus notifikasi: ' . $e->getMessage());
        }
    }

    /**
     * Bulk actions for admin dashboard
     * Hanya untuk notifikasi umum (user_id = NULL)
     */
    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,mark_read,mark_unread',
            'ids' => 'required|array',
            'ids.*' => 'exists:notifications,id'
        ]);

        try {
            // Hanya proses notifikasi dengan user_id NULL
            $query = Notification::whereIn('id', $request->ids)->whereNull('user_id');

            switch ($request->action) {
                case 'delete':
                    $query->delete();
                    $message = 'Notifikasi terpilih berhasil dihapus';
                    break;

                case 'mark_read':
                    $query->update(['is_read' => 1, 'updated_at' => now()]);
                    $message = 'Notifikasi terpilih berhasil ditandai sebagai dibaca';
                    break;

                case 'mark_unread':
                    $query->update(['is_read' => 0, 'updated_at' => now()]);
                    $message = 'Notifikasi terpilih berhasil ditandai sebagai belum dibaca';
                    break;

                default:
                    return redirect()->back()->with('error', 'Aksi tidak valid');
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal melakukan aksi: ' . $e->getMessage());
        }
    }

    /**
     * Get notifications statistics for admin dashboard
     * Hanya hitung notifikasi umum (user_id = NULL)
     */
    public function getStatistics()
    {
        $totalNotifications = Notification::whereNull('user_id')->count();
        $unreadNotifications = Notification::whereNull('user_id')->where('is_read', 0)->count();
        $readNotifications = Notification::whereNull('user_id')->where('is_read', 1)->count();
        $todayNotifications = Notification::whereNull('user_id')->whereDate('created_at', today())->count();

        return response()->json([
            'total' => $totalNotifications,
            'unread' => $unreadNotifications,
            'read' => $readNotifications,
        ]);
    }
}