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
        $hariIni = JadwalPiketGuru::getNamaHari(now());

        // Guru yang terjadwal hari ini — ditampilkan pertama di dropdown.
        // Filter ->filter() untuk membuang relasi guru yang null (data kotor).
        $guruTerjadwal = JadwalPiketGuru::with('guru')
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->get()
            ->pluck('guru')
            ->filter()          // buang null (jadwal tanpa relasi guru valid)
            ->unique('id')
            ->values();

        // Semua guru aktif — fallback / pilihan tambahan di dropdown
        $semuaGuru = Guru::aktif()->orderBy('nama_lengkap')->get();

        // Semua log hari ini (bisa lebih dari 1 guru, bisa multi-shift)
        $logHariIni = LogPiket::with('guru')
            ->whereDate('tanggal', today())
            ->orderByDesc('masuk_pada')
            ->get();

        // Log yang masih aktif (belum checkout) — kandidat untuk checkout
        // Gunakan ->values() agar index integer berurutan (aman untuk looping Blade)
        $logAktif = $logHariIni->whereNull('keluar_pada')->values();

        // Riwayat 7 hari terakhir — semua guru
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
            'guru_id' => ['required', 'integer', 'exists:guru,id'],
            'catatan' => ['nullable', 'string', 'max:500'],
            'shift'   => ['nullable', 'string', 'in:pagi,siang,sore'],
        ], [
            'guru_id.required' => 'Pilih nama guru yang akan check-in.',
            'guru_id.exists'   => 'Guru tidak ditemukan dalam sistem.',
        ]);

        $guruId  = (int) $validated['guru_id'];
        $hariIni = JadwalPiketGuru::getNamaHari(now());

        // ── Guard: guru masih aktif piket (belum checkout) hari ini ──────────
        // Guru yang sama BOLEH check-in lagi setelah checkout (shift berbeda).
        $sudahAktif = LogPiket::where('guru_id', $guruId)
            ->whereDate('tanggal', today())
            ->whereNotNull('masuk_pada')
            ->whereNull('keluar_pada')
            ->exists();

        if ($sudahAktif) {
            return redirect()->route('piket.log.checkin')
                ->withInput()
                ->with('warning', 'Guru ini masih aktif piket. Lakukan check-out terlebih dahulu sebelum check-in kembali.');
        }

        // ── Ambil jadwal piket hari ini untuk guru ini ────────────────────────
        $jadwal = JadwalPiketGuru::where('guru_id', $guruId)
            ->where('hari', $hariIni)
            ->where('is_active', true)
            ->first();

        // Tentukan shift: dari input user → dari jadwal → default 'pagi'
        // Carbon::parse() aman untuk 'H:i' maupun 'H:i:s' dari DB.
        $shift = $validated['shift'] ?? $this->tentukanShift($jadwal?->jam_mulai);

        LogPiket::create([
            'guru_id'              => $guruId,
            // jadwal_piket_guru_id boleh null jika guru tidak terjadwal hari ini
            'jadwal_piket_guru_id' => $jadwal?->id,
            // pengguna_id = akun operator yang melakukan check-in (bisa petugas piket)
            'pengguna_id'          => Auth::id(),
            'tanggal'              => today(),
            'masuk_pada'           => now(),
            'keluar_pada'          => null,
            'shift'                => $shift,
            'catatan'              => $validated['catatan'] ?? null,
        ]);

        // Ambil nama guru langsung dari relasi jadwal jika ada, fallback ke query
        $namaGuru = $jadwal?->guru?->nama_lengkap
            ?? Guru::find($guruId)?->nama_lengkap
            ?? 'Guru';

        return redirect()->route('piket.log.checkin')
            ->with('success', "{$namaGuru} berhasil check-in pukul " . now()->format('H:i') . '.');
    }

    // ─── Proses Check-Out ─────────────────────────────────────────────────────

    public function checkout(Request $request, LogPiket $log)
    {
        // ── Guard: belum check-in sama sekali ─────────────────────────────────
        if (! $log->masuk_pada) {
            return back()->with('error', 'Tidak dapat checkout: data check-in tidak ditemukan.');
        }

        // ── Guard: sudah checkout sebelumnya ──────────────────────────────────
        if ($log->keluar_pada) {
            return back()->with('warning', 'Log ini sudah melakukan check-out sebelumnya.');
        }

        // ── Guard: hanya log hari ini yang bisa di-checkout ───────────────────
        // Carbon::parse() aman untuk string date maupun Carbon object dari model.
        // Model sudah men-cast 'tanggal' => 'date', jadi $log->tanggal adalah Carbon.
        // Panggil ->isToday() langsung pada Carbon object sudah aman.
        if (! $log->tanggal->isToday()) {
            return back()->with('error', 'Hanya log piket hari ini yang dapat di-checkout.');
        }

        $validated = $request->validate([
            'catatan_keluar' => ['nullable', 'string', 'max:500'],
        ]);

        // ── Proses checkout ───────────────────────────────────────────────────
        // checkOut() melempar LogicException jika guard dilanggar (double check).
        // Guard di atas seharusnya mencegah ini, tapi tetap aman.
        try {
            $log->checkOut();
        } catch (\LogicException $e) {
            return back()->with('error', $e->getMessage());
        }

        // Append catatan keluar jika diisi.
        // $log->fresh() memastikan kita ambil state terkini setelah checkOut().
        if (! empty($validated['catatan_keluar'])) {
            $log->refresh(); // sync state setelah update dari checkOut()
            $log->update([
                'catatan' => trim(($log->catatan ? $log->catatan . ' | ' : '') . $validated['catatan_keluar']),
            ]);
        }

        // Eager load relasi guru jika belum ter-load (untuk pesan flash)
        $log->loadMissing('guru');
        $namaGuru = $log->guru?->nama_lengkap ?? 'Guru';

        return redirect()->route('piket.log.checkin')
            ->with('success', "{$namaGuru} berhasil check-out pukul " . now()->format('H:i') . '.');
    }

    // ─── Helper ───────────────────────────────────────────────────────────────

    /**
     * Tentukan shift berdasarkan jam mulai jadwal.
     *
     * Menggunakan Carbon::parse() agar aman untuk format 'H:i' maupun 'H:i:s'.
     * Jika $jamMulai null (guru tidak terjadwal), default ke 'pagi'.
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