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

        // Sesuaikan query dengan kolom 'id_user'
        $notifications = Notification::where(function($query) use ($user) {
                $query->where('id_user', $user->id)
                      ->orWhereNull('id_user');
            })
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Karena tidak ada kolom is_read di database, kita anggap count 0 atau hitung semua
        // Jika ingin menghitung jumlah, sementara kita return jumlah total notifikasi saja
        $unreadCount = $notifications->count(); 

        return response()->json([
            'count' => $unreadCount,
            'list' => $notifications
        ]);
    }

    /**
     * Method Dummy untuk Mark As Read (Karena kolom is_read tidak ada di DB)
     */
    public function markAsRead($id)
    {
        // Fitur dimatikan sementara karena tidak ada kolom is_read di tabel notifikasi
        return response()->json([
            'success' => true,
            'message' => 'Fitur mark read dinonaktifkan (Kolom DB tidak tersedia)'
        ]);
    }

    public function markAllAsRead()
    {
        return response()->json([
            'success' => true,
            'message' => 'Fitur mark all read dinonaktifkan (Kolom DB tidak tersedia)'
        ]);
    }

    /**
     * ADMIN DASHBOARD METHODS
     */

    public function index()
    {
        // Ubah user_id menjadi id_user
        $notifications = Notification::whereNull('id_user')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.notifications', compact('notifications'));
    }

    public function create()
    {
        return view('admin.notifications');
    }

    public function store(Request $request)
    {
        // Validasi input form (name field di view mungkin masih 'title'/'message', kita mapping disini)
        $request->validate([
            'title' => 'nullable|string|max:150', // Sesuai varchar(150)
            'message' => 'required|string',
        ]);

        try {
            Notification::create([
                'judul_notifikasi' => $request->title,     // Mapping ke kolom DB
                'pesan_notifikasi' => $request->message,   // Mapping ke kolom DB
                'id_user' => null,                         // Mapping ke kolom DB
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

    public function show($id)
    {
        try {
            $notification = Notification::whereNull('id_user')->findOrFail($id);
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json($notification);
            }
            
            return view('admin.notifications', compact('notification'));
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Notifikasi tidak ditemukan'], 404);
            }
            return redirect()->route('admin.notifications.index')
                ->with('error', 'Notifikasi tidak ditemukan');
        }
    }

    public function edit($id)
    {
        try {
            $notification = Notification::whereNull('id_user')->findOrFail($id);
            
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json($notification);
            }
            
            return view('admin.notifications', compact('notification'));
        } catch (\Exception $e) {
            if (request()->ajax() || request()->wantsJson()) {
                return response()->json(['error' => 'Notifikasi tidak ditemukan'], 404);
            }
            return redirect()->route('admin.notifications.index')
                ->with('error', 'Notifikasi tidak ditemukan');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'nullable|string|max:150',
            'message' => 'required|string',
        ]);

        try {
            $notification = Notification::whereNull('id_user')->findOrFail($id);
            $notification->update([
                'judul_notifikasi' => $request->title,
                'pesan_notifikasi' => $request->message,
                'id_user' => null,
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

    public function destroy($id)
    {
        try {
            $notification = Notification::whereNull('id_user')->findOrFail($id);
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

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete', // Hapus mark_read/unread karena tidak support
            'ids' => 'required|array',
            'ids.*' => 'exists:notifikasi,id_notifikasi' // Sesuaikan table & PK
        ]);

        try {
            $query = Notification::whereIn('id_notifikasi', $request->ids)->whereNull('id_user');

            switch ($request->action) {
                case 'delete':
                    $query->delete();
                    $message = 'Notifikasi terpilih berhasil dihapus';
                    break;
                
                default:
                    return redirect()->back()->with('error', 'Aksi tidak valid atau tidak didukung database');
            }

            return redirect()->back()->with('success', $message);

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal melakukan aksi: ' . $e->getMessage());
        }
    }

    public function getStatistics()
    {
        // Sesuaikan dengan kolom yang ada
        $totalNotifications = Notification::whereNull('id_user')->count();
        // Unread/Read tidak bisa dihitung real, kita return 0 atau total
        $unreadNotifications = 0; 
        $readNotifications = 0;
        $todayNotifications = Notification::whereNull('id_user')->whereDate('created_at', today())->count();

        return response()->json([
            'total' => $totalNotifications,
            'unread' => $unreadNotifications,
            'read' => $readNotifications,
        ]);
    }
}