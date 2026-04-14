<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class NotificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Notification::where('user_id', Auth::id());

        $query->when($request->filled('is_read'),
            fn ($q) => $q->where('is_read', $request->boolean('is_read'))
        );

        return response()->json([
            'success' => true,
            'data'    => $query->latest()->paginate(15)->withQueryString(),
            'meta'    => [
                'unread_count' => Notification::where('user_id', Auth::id())
                                              ->where('is_read', false)
                                              ->count(),
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $notification = Notification::where('user_id', Auth::id())->find($id);

        if (! $notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notifikasi tidak ditemukan.',
            ], 404);
        }

        $notification->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'data'    => $notification->fresh(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | MARK ALL READ
    |--------------------------------------------------------------------------
    */
    public function markAllRead()
    {
        $updated = Notification::where('user_id', Auth::id())
                               ->where('is_read', false)
                               ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'message' => "{$updated} notifikasi telah ditandai dibaca.",
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $notification = Notification::where('user_id', Auth::id())->find($id);

        if (! $notification) {
            return response()->json([
                'success' => false,
                'message' => 'Notifikasi tidak ditemukan.',
            ], 404);
        }

        $notification->delete();

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil dihapus.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | BULK DELETE
    |--------------------------------------------------------------------------
    */
    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids'   => 'required|array',
                'ids.*' => 'exists:notifications,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        Notification::where('user_id', Auth::id())
                    ->whereIn('id', $request->ids)
                    ->delete();

        return response()->json([
            'success' => true,
            'message' => count($request->ids) . ' notifikasi berhasil dihapus.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | BROADCAST
    |--------------------------------------------------------------------------
    */
    public function broadcast(Request $request)
    {
        try {
            $request->validate([
                'title'      => 'required|string|max:255',
                'message'    => 'required|string|max:1000',
                'user_ids'   => 'nullable|array',
                'user_ids.*' => 'exists:users,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

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

        return response()->json([
            'success' => true,
            'message' => 'Notifikasi berhasil dikirim ke ' . count($userIds) . ' pengguna.',
        ], 201);
    }
}