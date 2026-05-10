<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PengumumanController extends Controller
{
    public function index(Request $request): View
    {
        $query = Pengumuman::dipublikasikan()   // scope: dipublikasikan_pada not null & <= now()
            ->belumKadaluarsa()                  // scope: kadaluarsa_pada null atau > now()
            ->untukRole('guru')                  // scope: target_role 'guru' atau 'semua'
            ->latest('dipublikasikan_pada');

        // FIX: Validasi & batasi panjang input search agar tidak membebani DB
        // dengan query LIKE pada string sangat panjang.
        if ($request->filled('search')) {
            $keyword = mb_substr(trim($request->search), 0, 100);
            $query->where('judul', 'like', '%' . $keyword . '%');
        }

        // FIX: Eager load relasi dibuatOleh di index agar tidak N+1 jika
        // suatu saat kolom pembuat ditampilkan di tabel.
        $pengumuman = $query->with('dibuatOleh')
            ->paginate(15)
            ->withQueryString();

        return view('guru.pengumuman.index', compact('pengumuman'));
    }

    public function show(Pengumuman $pengumuman): View
    {
        // FIX #1: Cek dipublikasikan_pada tidak null DAN waktunya sudah lewat.
        // Sebelumnya hanya cek !dipublikasikan_pada → pengumuman terjadwal
        // (scheduled, dipublikasikan_pada di masa depan) bisa diakses via URL langsung.
        abort_if(
            ! $pengumuman->dipublikasikan_pada || $pengumuman->dipublikasikan_pada->isFuture(),
            404
        );

        // FIX #2: Cek target_role — guru tidak boleh akses pengumuman untuk siswa saja.
        abort_unless(
            in_array($pengumuman->target_role, ['semua', 'guru'], true),
            403,
            'Pengumuman ini tidak ditujukan untuk Anda.'
        );

        // FIX #3: Cek kadaluarsa — guru tidak boleh akses pengumuman expired via URL.
        // Index sudah memfilter ini, tapi show() perlu guard sendiri agar
        // akses langsung via URL tetap aman.
        abort_if(
            $pengumuman->kadaluarsa_pada && $pengumuman->kadaluarsa_pada->isPast(),
            404
        );

        // FIX #4: Gunakan eager load dengan relasi yang benar sesuai nama di model.
        $pengumuman->load('dibuatOleh');

        return view('guru.pengumuman.show', compact('pengumuman'));
    }
}