<?php

namespace App\Http\Controllers;

use App\Models\AgendaSekolah;
use App\Models\BeritaPublik;
use App\Models\GaleriFoto;
use App\Models\Jurusan;
use App\Models\KontakPesan;
use App\Models\LinkCepat;
use App\Models\Prestasi;
use App\Models\ProfilSekolah;
use App\Models\SliderBeranda;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        // Profil Sekolah
        $profil = ProfilSekolah::instance();

        // Slider Hero
        $sliders = SliderBeranda::where('is_published', true)
            ->orderBy('urutan')
            ->get();

        // Jurusan yang dipublikasikan
        $jurusan = Jurusan::where('is_published', true)
            ->with(['kompetensi', 'prospekKerja'])
            ->orderBy('urutan')
            ->get();

        // Berita terbaru (7 artikel — 1 featured + 4 grid, ambil lebih untuk buffer)
        $semuaBerita = BeritaPublik::with('kategori')
            ->where('status', 'published')
            ->latest('published_at')
            ->limit(7)
            ->get();

        // Berita featured: prioritaskan is_featured, fallback ke yang pertama
        $beritaFeatured = $semuaBerita->firstWhere('is_featured', true)
            ?? $semuaBerita->first();

        // Berita grid: exclude featured agar tidak duplikat
        $berita = $semuaBerita->filter(
            fn($b) => $b->id !== optional($beritaFeatured)->id
        )->values()->take(4);

        // Agenda mendatang
        $agenda = AgendaSekolah::where('is_published', true)
            ->where('tanggal_mulai', '>=', now()->toDateString())
            ->orderBy('tanggal_mulai')
            ->limit(5)
            ->get();

        // Prestasi unggulan
        $prestasi = Prestasi::where('is_published', true)
            ->where('is_featured', true)
            ->orderByDesc('tanggal')
            ->limit(6)
            ->get();

        // Statistik prestasi
        $totalPrestasi    = Prestasi::where('is_published', true)->count();
        $prestasiNasional = Prestasi::where('is_published', true)
            ->whereIn('tingkat', ['nasional', 'internasional'])
            ->count();

        // Galeri foto terbaru
        $galeri = GaleriFoto::where('is_published', true)
            ->with('kategori')
            ->orderBy('urutan')
            ->limit(9)
            ->get();

        // Link cepat
        $linkCepat = LinkCepat::where('is_published', true)
            ->orderBy('urutan')
            ->get();

        // Statistik ringkasan
        $stats = [
            'jurusan'           => $jurusan->count(),
            'prestasi'          => $totalPrestasi,
            'prestasi_nasional' => $prestasiNasional,
            'pengguna_aktif'    => 500, // ganti dengan query aktif jika tersedia
        ];

        return view('welcome', compact(
            'profil',
            'sliders',
            'jurusan',
            'berita',
            'beritaFeatured',
            'agenda',
            'prestasi',
            'galeri',
            'linkCepat',
            'stats',
        ));
    }

    /**
     * Terima & simpan pesan kontak dari halaman publik.
     */
    public function kirimKontak(Request $request)
    {
        $validated = $request->validate([
            'nama_pengirim'  => ['required', 'string', 'max:100'],
            'email_pengirim' => ['required', 'email', 'max:150'],
            'no_telepon'     => ['nullable', 'string', 'max:20'],
            'subjek'         => ['required', 'string', 'max:200'],
            'pesan'          => ['required', 'string', 'max:3000'],
        ], [
            'nama_pengirim.required'  => 'Nama wajib diisi.',
            'email_pengirim.required' => 'Email wajib diisi.',
            'email_pengirim.email'    => 'Format email tidak valid.',
            'subjek.required'         => 'Subjek wajib diisi.',
            'pesan.required'          => 'Pesan wajib diisi.',
        ]);

        KontakPesan::create([
            ...$validated,
            'ip_address' => $request->ip(),
            'status'     => 'baru',
        ]);

        return redirect()
            ->to(route('welcome') . '#kontak')
            ->with('kontak_success', 'Pesan Anda berhasil terkirim! Kami akan menghubungi Anda segera.');
    }
}