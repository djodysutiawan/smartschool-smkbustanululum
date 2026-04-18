<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrangTuaExport;
use App\Http\Controllers\Controller;
use App\Models\OrangTua;
use App\Models\Siswa;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class OrangTuaController extends Controller
{
    private function validasiPesan(): array
    {
        return [
            'nama_lengkap.required'      => 'Nama lengkap wajib diisi.',
            'nama_lengkap.max'           => 'Nama lengkap tidak boleh lebih dari 150 karakter.',
            'no_hp.required'             => 'Nomor HP wajib diisi.',
            'no_hp.max'                  => 'Nomor HP tidak boleh lebih dari 20 karakter.',
            'email.email'                => 'Format email tidak valid.',
            'email.max'                  => 'Email tidak boleh lebih dari 100 karakter.',
            'user_email.required_if'     => 'Email akun wajib diisi jika membuat akun baru.',
            'user_email.email'           => 'Format email akun tidak valid.',
            'user_email.unique'          => 'Email akun sudah terdaftar di sistem.',
            'user_password.required_if'  => 'Kata sandi wajib diisi jika membuat akun baru.',
            'user_password.min'          => 'Kata sandi minimal 8 karakter.',
            'pengguna_id.exists'         => 'Akun pengguna yang dipilih tidak valid.',
            'siswa_ids.array'            => 'Data siswa tidak valid.',
            'siswa_ids.*.exists'         => 'Salah satu siswa yang dipilih tidak ditemukan.',
            'hubungan.required'          => 'Hubungan wajib dipilih.',
            'kontak_utama.exists'        => 'Kontak utama yang dipilih tidak valid.',
        ];
    }

    public function index(Request $request)
    {
        $query = OrangTua::with('pengguna')->withCount('siswa');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('nama_lengkap', 'like', "%{$s}%")
                                      ->orWhere('no_hp', 'like', "%{$s}%")
                                      ->orWhere('email', 'like', "%{$s}%"));
        }

        $orangTua = $query->orderBy('nama_lengkap')->paginate(20)->withQueryString();

        return view('admin.orang-tua.index', compact('orangTua'));
    }

    public function create()
    {
        $siswaAktif = Siswa::aktif()->orderBy('nama_lengkap')->get();

        return view('admin.orang-tua.create', compact('siswaAktif'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'buat_akun_baru'  => ['boolean'],
            'user_email'      => ['nullable', 'required_if:buat_akun_baru,1', 'email', 'unique:users,email'],
            'user_password'   => ['nullable', 'required_if:buat_akun_baru,1', 'string', 'min:8'],
            'pengguna_id'     => ['nullable', 'exists:users,id'],
            'nama_lengkap'    => ['required', 'string', 'max:150'],
            'no_hp'           => ['required', 'string', 'max:20'],
            'email'           => ['nullable', 'email', 'max:100'],
            'alamat'          => ['nullable', 'string'],
            'pekerjaan'       => ['nullable', 'string', 'max:100'],
            'siswa_ids'       => ['nullable', 'array'],
            'siswa_ids.*'     => ['exists:siswa,id'],
            'hubungan'        => ['nullable', 'array'],
            'hubungan.*'      => ['in:ayah,ibu,wali,orang_tua'],
            'kontak_utama'    => ['nullable', 'integer', 'exists:siswa,id'],
        ], $this->validasiPesan());

        DB::transaction(function () use ($request, $validated) {
            if ($request->boolean('buat_akun_baru')) {
                $user = User::create([
                    'name'      => $validated['nama_lengkap'],
                    'email'     => $validated['user_email'],
                    'password'  => Hash::make($validated['user_password']),
                    'role'      => 'orang_tua',
                    'is_active' => true,
                ]);
                $user->assignRole('orang_tua');
                $validated['pengguna_id'] = $user->id;
            }

            $orangTua = OrangTua::create([
                'pengguna_id'  => $validated['pengguna_id'] ?? null,
                'nama_lengkap' => $validated['nama_lengkap'],
                'no_hp'        => $validated['no_hp'],
                'email'        => $validated['email'] ?? null,
                'alamat'       => $validated['alamat'] ?? null,
                'pekerjaan'    => $validated['pekerjaan'] ?? null,
            ]);

            if (!empty($validated['siswa_ids'])) {
                $syncData = [];
                foreach ($validated['siswa_ids'] as $siswaId) {
                    $syncData[$siswaId] = [
                        'hubungan'     => $request->hubungan[$siswaId] ?? 'orang_tua',
                        'kontak_utama' => ($request->kontak_utama == $siswaId),
                    ];
                }
                $orangTua->siswa()->sync($syncData);
            }
        });

        return redirect()->route('admin.orang-tua.index')
            ->with('success', 'Data orang tua berhasil ditambahkan.');
    }

    public function show(OrangTua $orangTua)
    {
        $orangTua->load(['pengguna', 'siswa.kelas']);

        return view('admin.orang-tua.show', compact('orangTua'));
    }

    public function edit(OrangTua $orangTua)
    {
        $orangTua->load('siswa');
        $siswaAktif = Siswa::aktif()->orderBy('nama_lengkap')->get();

        return view('admin.orang-tua.edit', compact('orangTua', 'siswaAktif'));
    }

    public function update(Request $request, OrangTua $orangTua)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:150'],
            'no_hp'        => ['required', 'string', 'max:20'],
            'email'        => ['nullable', 'email', 'max:100'],
            'alamat'       => ['nullable', 'string'],
            'pekerjaan'    => ['nullable', 'string', 'max:100'],
            'siswa_ids'    => ['nullable', 'array'],
            'siswa_ids.*'  => ['exists:siswa,id'],
            'hubungan'     => ['nullable', 'array'],
            'hubungan.*'   => ['in:ayah,ibu,wali,orang_tua'],
            'kontak_utama' => ['nullable', 'integer', 'exists:siswa,id'],
        ], $this->validasiPesan());

        DB::transaction(function () use ($request, $validated, $orangTua) {
            $orangTua->update([
                'nama_lengkap' => $validated['nama_lengkap'],
                'no_hp'        => $validated['no_hp'],
                'email'        => $validated['email'] ?? null,
                'alamat'       => $validated['alamat'] ?? null,
                'pekerjaan'    => $validated['pekerjaan'] ?? null,
            ]);

            if (!empty($validated['siswa_ids'])) {
                $syncData = [];
                foreach ($validated['siswa_ids'] as $siswaId) {
                    $syncData[$siswaId] = [
                        'hubungan'     => $request->hubungan[$siswaId] ?? 'orang_tua',
                        'kontak_utama' => ($request->kontak_utama == $siswaId),
                    ];
                }
                $orangTua->siswa()->sync($syncData);
            } else {
                $orangTua->siswa()->detach();
            }
        });

        return redirect()->route('admin.orang-tua.show', $orangTua)
            ->with('success', 'Data orang tua berhasil diperbarui.');
    }

    public function destroy(OrangTua $orangTua)
    {
        $orangTua->siswa()->detach();
        $orangTua->delete();

        return redirect()->route('admin.orang-tua.index')
            ->with('success', 'Data orang tua berhasil dihapus.');
    }

    public function linkSiswa(Request $request, OrangTua $orangTua)
    {
        $request->validate([
            'siswa_id'     => ['required', 'exists:siswa,id'],
            'hubungan'     => ['required', 'in:ayah,ibu,wali,orang_tua'],
            'kontak_utama' => ['boolean'],
        ], [
            'siswa_id.required' => 'Siswa wajib dipilih.',
            'siswa_id.exists'   => 'Siswa yang dipilih tidak ditemukan.',
            'hubungan.required' => 'Hubungan wajib dipilih.',
            'hubungan.in'       => 'Hubungan yang dipilih tidak valid.',
        ]);

        if ($orangTua->siswa()->where('siswa_id', $request->siswa_id)->exists()) {
            return back()->with('error', 'Relasi orang tua dengan siswa ini sudah ada.');
        }

        $orangTua->siswa()->syncWithoutDetaching([
            $request->siswa_id => [
                'hubungan'     => $request->hubungan,
                'kontak_utama' => $request->boolean('kontak_utama'),
            ],
        ]);

        return back()->with('success', 'Relasi orang tua-siswa berhasil ditambahkan.');
    }

    public function unlinkSiswa(OrangTua $orangTua, Siswa $siswa)
    {
        $orangTua->siswa()->detach($siswa->id);

        return back()->with('success', 'Relasi orang tua-siswa berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $query = OrangTua::with(['pengguna', 'siswa.kelas'])->withCount('siswa');

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('nama_lengkap', 'like', "%{$s}%")
                                      ->orWhere('no_hp', 'like', "%{$s}%")
                                      ->orWhere('email', 'like', "%{$s}%"));
        }

        $orangTua    = $query->orderBy('nama_lengkap')->get();
        $filterLabel = $request->filled('search') ? 'Cari: ' . $request->search : 'Semua Data';

        $pdf = Pdf::loadView('admin.orang-tua.pdf', compact('orangTua', 'filterLabel'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('data-orang-tua-' . now()->format('Ymd-His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $filters  = $request->only(['search']);
        $filename = 'data-orang-tua-' . now()->format('Ymd-His') . '.xlsx';

        return Excel::download(new OrangTuaExport($filters), $filename);
    }
}