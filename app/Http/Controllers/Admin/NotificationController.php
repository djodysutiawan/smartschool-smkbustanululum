<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX — semua notifikasi milik admin yang login
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Notification::where('user_id', Auth::id());

        $query->when($request->filled('is_read'),
            fn ($q) => $q->where('is_read', $request->boolean('is_read'))
        );

        return view('admin.notifications.index', [
            'notifications' => $query->latest()->paginate(15)->withQueryString(),
            'unreadCount'   => Notification::where('user_id', Auth::id())
                                           ->where('is_read', false)
                                           ->count(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW — tandai sebagai dibaca + tampilkan detail
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $notification = Notification::where('user_id', Auth::id())->findOrFail($id);

        $notification->update(['is_read' => true]);

        return view('admin.notifications.show', compact('notification'));
    }

    /*
    |--------------------------------------------------------------------------
    | MARK ALL READ
    |--------------------------------------------------------------------------
    */
    public function markAllRead()
    {
        Notification::where('user_id', Auth::id())
                    ->where('is_read', false)
                    ->update(['is_read' => true]);

        return back()->with('success', 'Semua notifikasi telah ditandai dibaca.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        Notification::where('user_id', Auth::id())->findOrFail($id)->delete();

        return back()->with('success', 'Notifikasi berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | BULK DELETE
    |--------------------------------------------------------------------------
    */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'exists:notifications,id',
        ]);

        Notification::where('user_id', Auth::id())
                    ->whereIn('id', $request->ids)
                    ->delete();

        return back()->with('success', count($request->ids) . ' notifikasi berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | BROADCAST — kirim notifikasi ke user tertentu (atau semua)
    |--------------------------------------------------------------------------
    */
    public function broadcast(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'message'  => 'required|string|max:1000',
            'user_ids' => 'nullable|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        // Jika tidak ada user_ids spesifik, kirim ke semua user
        $userIds = $request->filled('user_ids')
            ? $request->user_ids
            : User::pluck('id')->toArray();

        $notifications = collect($userIds)->map(fn ($uid) => [
            'user_id'    => $uid,
            'title'      => $request->title,
            'message'    => $request->message,
            'is_read'    => false,
            'created_at' => now(),
            'updated_at' => now(),
        ])->toArray();

        Notification::insert($notifications);

        return back()->with('success', 'Notifikasi berhasil dikirim ke ' . count($userIds) . ' pengguna.');
    }
}