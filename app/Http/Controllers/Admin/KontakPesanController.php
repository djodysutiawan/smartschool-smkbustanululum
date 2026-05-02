<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\KontakPesan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KontakPesanController extends Controller
{
    public function index(Request $request)
    {
        $pesan = KontakPesan::query()
            ->when($request->search, fn($q) => $q->where('nama_pengirim', 'like', "%{$request->search}%")
                ->orWhere('subjek', 'like', "%{$request->search}%")
                ->orWhere('email_pengirim', 'like', "%{$request->search}%"))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        $totalBaru = KontakPesan::baru()->count();

        return view('Admin.KontakPesan.index', compact('pesan', 'totalBaru'));
    }

    public function show(KontakPesan $kontakPesan)
    {
        // Auto-tandai dibaca saat dibuka
        if ($kontakPesan->status === 'baru') {
            /** @var User $user */
            $user = Auth::user();
            $kontakPesan->markAsRead($user->id);
        }

        return view('Admin.KontakPesan.show', compact('kontakPesan'));
    }

    public function destroy(KontakPesan $kontakPesan)
    {
        $kontakPesan->delete();

        return redirect()->route('admin.kontak-pesan.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }

    public function markAsRead(KontakPesan $kontakPesan)
    {
        /** @var User $user */
        $user = Auth::user();
        $kontakPesan->markAsRead($user->id);

        return back()->with('success', 'Pesan ditandai sudah dibaca.');
    }

    public function arsip(KontakPesan $kontakPesan)
    {
        $kontakPesan->update(['status' => 'arsip']);

        return back()->with('success', 'Pesan diarsipkan.');
    }

    public function tandaiDibalas(KontakPesan $kontakPesan)
    {
        $request = request();
        $request->validate(['catatan_admin' => 'nullable|string|max:1000']);

        $kontakPesan->update([
            'status'        => 'dibalas',
            'catatan_admin' => $request->catatan_admin,
        ]);

        return back()->with('success', 'Pesan ditandai sudah dibalas.');
    }

    public function markAllRead()
    {
        /** @var User $user */
        $user = Auth::user();

        KontakPesan::baru()->update([
            'status'      => 'dibaca',
            'dibaca_at'   => now(),
            'dibaca_oleh' => $user->id,
        ]);

        return back()->with('success', 'Semua pesan baru ditandai sudah dibaca.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'exists:kontak_pesan,id',
        ]);

        KontakPesan::whereIn('id', $request->ids)->delete();

        return back()->with('success', count($request->ids) . ' pesan berhasil dihapus.');
    }

    public function exportPdf()
    {
        return back()->with('info', 'Fitur export PDF segera hadir.');
    }

    public function exportExcel()
    {
        return back()->with('info', 'Fitur export Excel segera hadir.');
    }
}