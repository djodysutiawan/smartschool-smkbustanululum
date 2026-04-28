<?php

namespace App\Http\Controllers\Piket;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Piket\Concerns\PiketActiveGuru;
use App\Models\Guru;
use App\Models\JadwalPiketGuru;
use App\Models\LogPiket;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogPiketController extends Controller
{
    use PiketActiveGuru;

    // ─── Halaman Check-In ─────────────────────────────────────────────────────
    // Halaman ini tetap accessible meski belum check-in (memang tempat check-in)

    public function checkin()
    {
        $hariIni = strtolower(Carbon::now()->locale('id')->isoFormat('dddd'));

        // Guru yang terjadwal hari ini — ditampilkan pertama di dropdown
        $guruTerjadwal = JadwalPiketGuru::with('guru')
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->get()
            ->pluck('guru')
            ->filter()
            ->unique('id')
            ->values();

        // Semua guru aktif — fallback jika guru tidak ada di jadwal
        $semuaGuru = Guru::aktif()->orderBy('nama_lengkap')->get();

        // Semua log hari ini (bisa lebih dari 1 guru, shift berbeda)
        $logHariIni = LogPiket::with('guru')
            ->whereDate('tanggal', today())
            ->orderByDesc('masuk_pada')
            ->get();

        // Log yang masih aktif (belum checkout) — kandidat untuk checkout
        $logAktif = $logHariIni->whereNull('keluar_pada')->values();

        // Riwayat 7 hari terakhir — semua guru (bukan hanya yang login)
        $riwayatTerakhir = LogPiket::with('guru')
            ->whereDate('tanggal', '>=', now()->subDays(7))
            ->orderByDesc('tanggal')
            ->orderByDesc('masuk_pada')
            ->get();

        return view('piket.log.checkin', compact(
            'guruTerjadwal',
            'semuaGuru',
            'logHariIni',
            'logAktif',
            'riwayatTerakhir',
            'hariIni',
        ));
    }

    // ─── Proses Check-In ──────────────────────────────────────────────────────

    public function doCheckin(Request $request)
    {
        $validated = $request->validate([
            'guru_id' => ['required', 'exists:guru,id'],
            'catatan' => ['nullable', 'string', 'max:500'],
            'shift'   => ['nullable', 'string', 'in:pagi,siang,sore'],
        ], [
            'guru_id.required' => 'Pilih nama guru yang akan check-in.',
            'guru_id.exists'   => 'Guru tidak ditemukan.',
        ]);

        $guruId  = $validated['guru_id'];
        $hariIni = strtolower(Carbon::now()->locale('id')->isoFormat('dddd'));

        // Cek apakah guru ini MASIH aktif piket (belum checkout) hari ini.
        // Guru yang sama bisa check-in lagi setelah checkout (misalnya shift berbeda).
        $sudahAktif = LogPiket::where('guru_id', $guruId)
            ->whereDate('tanggal', today())
            ->whereNull('keluar_pada')
            ->exists();

        if ($sudahAktif) {
            return redirect()->route('piket.log.checkin')
                ->with('warning', 'Guru ini masih aktif piket dan belum melakukan check-out.');
        }

        $jadwal = JadwalPiketGuru::where('guru_id', $guruId)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->first();

        $shift = $validated['shift'] ?? $this->tentukanShift($jadwal?->jam_mulai);

        LogPiket::create([
            'guru_id'              => $guruId,
            'jadwal_piket_guru_id' => $jadwal?->id,
            // pengguna_id = akun yang login (akun bersama guru_piket)
            'pengguna_id'          => Auth::id(),
            'tanggal'              => today(),
            'masuk_pada'           => now(),
            'keluar_pada'          => null,
            'shift'                => $shift,
            'catatan'              => $validated['catatan'] ?? null,
        ]);

        $namaGuru = Guru::find($guruId)?->nama_lengkap ?? 'Guru';

        return redirect()->route('piket.log.checkin')
            ->with('success', "{$namaGuru} berhasil check-in pukul " . now()->format('H:i') . '.');
    }

    // ─── Proses Check-Out ─────────────────────────────────────────────────────

    public function checkout(Request $request, LogPiket $log)
    {
        if (! $log->masuk_pada) {
            return back()->with('error', 'Tidak dapat checkout: belum ada data check-in.');
        }

        if ($log->keluar_pada) {
            return back()->with('warning', 'Log ini sudah melakukan check-out sebelumnya.');
        }

        // Pastikan log ini memang dari hari ini
        if (! $log->tanggal->isToday()) {
            return back()->with('error', 'Hanya log hari ini yang bisa di-checkout.');
        }

        $validated = $request->validate([
            'catatan_keluar' => ['nullable', 'string', 'max:500'],
        ]);

        $log->checkOut();

        if (! empty($validated['catatan_keluar'])) {
            $log->update([
                'catatan' => ($log->catatan ? $log->catatan . ' | ' : '') . $validated['catatan_keluar'],
            ]);
        }

        $namaGuru = $log->guru?->nama_lengkap ?? 'Guru';

        return redirect()->route('piket.log.checkin')
            ->with('success', "{$namaGuru} berhasil check-out pukul " . now()->format('H:i') . '.');
    }

    // ─── Helper ───────────────────────────────────────────────────────────────

    private function tentukanShift(?string $jamMulai): string
    {
        if (! $jamMulai) return 'pagi';
        $jam = (int) Carbon::createFromFormat('H:i', $jamMulai)->format('H');
        return match (true) {
            $jam < 12 => 'pagi',
            default   => 'siang',
        };
    }
}