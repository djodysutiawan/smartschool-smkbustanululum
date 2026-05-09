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
        // FIX: gunakan getNamaHari() dari model — mapping statis yang tidak
        // bergantung locale sistem, konsisten dengan JadwalController.
        $hariIni = JadwalPiketGuru::getNamaHari(now());

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
            ->whereDate('tanggal', '>=', now()->subDays(7)->startOfDay())
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

        $guruId  = (int) $validated['guru_id'];

        // FIX: konsisten dengan checkin() — pakai getNamaHari()
        $hariIni = JadwalPiketGuru::getNamaHari(now());

        // Cek apakah guru ini MASIH aktif piket (belum checkout) hari ini.
        // Guru yang sama bisa check-in lagi setelah checkout (misal shift berbeda).
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

        // FIX: null-safe pada jam_mulai sebelum diteruskan ke tentukanShift()
        $shift = $validated['shift'] ?? $this->tentukanShift($jadwal?->jam_mulai);

        LogPiket::create([
            'guru_id'              => $guruId,
            'jadwal_piket_guru_id' => $jadwal?->id,
            // pengguna_id = akun yang login (akun bersama / petugas piket)
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

        // FIX: $log->tanggal bisa berupa string jika model belum men-cast kolom ini.
        // Carbon::parse() aman untuk keduanya (Carbon object maupun string date).
        // Hindari memanggil ->isToday() langsung pada string.
        if (! Carbon::parse($log->tanggal)->isToday()) {
            return back()->with('error', 'Hanya log hari ini yang bisa di-checkout.');
        }

        $validated = $request->validate([
            'catatan_keluar' => ['nullable', 'string', 'max:500'],
        ]);

        // Panggil accessor checkOut() dari model LogPiket
        $log->checkOut();

        // Append catatan keluar ke catatan yang sudah ada (jika diisi)
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

    /**
     * Tentukan shift berdasarkan jam mulai jadwal.
     * FIX: gunakan Carbon::parse() bukan createFromFormat('H:i', ...)
     * agar aman untuk format 'H:i:s' yang dikembalikan DB maupun 'H:i'.
     */
    private function tentukanShift(?string $jamMulai): string
    {
        if (! $jamMulai) {
            return 'pagi';
        }

        $jam = (int) Carbon::parse($jamMulai)->format('H');

        return match (true) {
            $jam < 12  => 'pagi',
            $jam < 15  => 'siang',
            default    => 'sore',
        };
    }
}