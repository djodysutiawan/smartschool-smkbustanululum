<?php

namespace App\Http\Controllers\Admin;

use App\Exports\SiswaExport;
use App\Http\Controllers\Controller;
use App\Imports\SiswaImport;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\TahunAjaran;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class SiswaController extends Controller
{
    private function validasiPesan(): array
    {
        return [
            'required'                    => ':attribute wajib diisi.',
            'required_if'                 => ':attribute wajib diisi.',
            'string'                      => ':attribute harus berupa teks.',
            'max'                         => ':attribute tidak boleh lebih dari :max karakter.',
            'min'                         => ':attribute minimal :min karakter.',
            'email'                       => ':attribute harus berupa alamat email yang valid.',
            'in'                          => ':attribute yang dipilih tidak valid.',
            'date'                        => ':attribute harus berupa tanggal yang valid.',
            'image'                       => ':attribute harus berupa gambar.',
            'mimes'                       => ':attribute harus berformat: :values.',
            'exists'                      => ':attribute yang dipilih tidak valid.',
            'nis.required'                => 'NIS wajib diisi.',
            'nis.unique'                  => 'NIS sudah digunakan oleh siswa lain.',
            'nisn.unique'                 => 'NISN sudah digunakan oleh siswa lain.',
            'user_email.unique'           => 'Email akun sudah terdaftar di sistem.',
            'user_email.required_if'      => 'Email akun wajib diisi jika membuat akun baru.',
            'user_password.required_if'   => 'Kata sandi wajib diisi jika membuat akun baru.',
            'kelas_id.required'           => 'Kelas wajib dipilih.',
            'tahun_ajaran_id.required'    => 'Tahun ajaran wajib dipilih.',
            'nama_lengkap.required'       => 'Nama lengkap wajib diisi.',
            'jenis_kelamin.required'      => 'Jenis kelamin wajib dipilih.',
            'status.required'             => 'Status wajib dipilih.',
            'foto.max'                    => 'Ukuran foto tidak boleh lebih dari 2 MB.',
        ];
    }

    public function index(Request $request)
    {
        $query = Siswa::with(['kelas', 'tahunAjaran', 'pengguna'])->withTrashed();

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('nama_lengkap', 'like', "%{$s}%")
                                      ->orWhere('nis', 'like', "%{$s}%")
                                      ->orWhere('nisn', 'like', "%{$s}%"));
        }

        $siswa        = $query->orderBy('nama_lengkap')->paginate(25)->withQueryString();
        $kelas        = Kelas::aktif()->orderBy('nama_kelas')->get();
        $tahunAjarans = TahunAjaran::orderByDesc('id')->get();

        $stats = [
            'total'     => Siswa::count(),
            'aktif'     => Siswa::aktif()->count(),
            'laki'      => Siswa::aktif()->where('jenis_kelamin', 'L')->count(),
            'perempuan' => Siswa::aktif()->where('jenis_kelamin', 'P')->count(),
        ];

        return view('admin.siswa.index', compact('siswa', 'kelas', 'tahunAjarans', 'stats'));
    }

    public function create()
    {
        $kelas        = Kelas::aktif()->with('tahunAjaran')->orderBy('nama_kelas')->get();
        $tahunAjarans = TahunAjaran::orderByDesc('id')->get();

        return view('admin.siswa.create', compact('kelas', 'tahunAjarans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'buat_akun_baru'  => ['boolean'],
            'user_email'      => ['nullable', 'required_if:buat_akun_baru,1', 'email', 'unique:users,email'],
            'user_password'   => ['nullable', 'required_if:buat_akun_baru,1', 'string', 'min:8'],
            'pengguna_id'     => ['nullable', 'exists:users,id'],
            'nis'             => ['required', 'string', 'max:20', 'unique:siswa,nis'],
            'nisn'            => ['nullable', 'string', 'max:20', 'unique:siswa,nisn'],
            'nama_lengkap'    => ['required', 'string', 'max:150'],
            'jenis_kelamin'   => ['required', 'in:L,P'],
            'tempat_lahir'    => ['nullable', 'string', 'max:100'],
            'tanggal_lahir'   => ['nullable', 'date'],
            'agama'           => ['nullable', 'string', 'max:20'],
            'alamat'          => ['nullable', 'string'],
            'no_hp'           => ['nullable', 'string', 'max:20'],
            'email'           => ['nullable', 'email', 'max:100'],
            'foto'            => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'nama_ayah'       => ['nullable', 'string', 'max:150'],
            'pekerjaan_ayah'  => ['nullable', 'string', 'max:100'],
            'no_hp_ayah'      => ['nullable', 'string', 'max:20'],
            'nama_ibu'        => ['nullable', 'string', 'max:150'],
            'pekerjaan_ibu'   => ['nullable', 'string', 'max:100'],
            'no_hp_ibu'       => ['nullable', 'string', 'max:20'],
            'nama_wali'       => ['nullable', 'string', 'max:150'],
            'hubungan_wali'   => ['nullable', 'string', 'max:50'],
            'pekerjaan_wali'  => ['nullable', 'string', 'max:100'],
            'no_hp_wali'      => ['nullable', 'string', 'max:20'],
            'kelas_id'        => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id' => ['required', 'exists:tahun_ajaran,id'],
            'status'          => ['required', 'in:aktif,tidak_aktif,lulus,pindah,keluar'],
            'tanggal_masuk'   => ['nullable', 'date'],
        ], $this->validasiPesan());

        $kelas = Kelas::findOrFail($validated['kelas_id']);
        if ($kelas->isSudahPenuh()) {
            return back()->withInput()->with('error', 'Kelas yang dipilih sudah penuh, silakan pilih kelas lain.');
        }

        DB::transaction(function () use ($request, $validated) {
            if ($request->boolean('buat_akun_baru')) {
                $user = User::create([
                    'name'      => $validated['nama_lengkap'],
                    'email'     => $validated['user_email'],
                    'password'  => Hash::make($validated['user_password']),
                    'role'      => 'siswa',
                    'is_active' => true,
                ]);
                $user->assignRole('siswa');
                $validated['pengguna_id'] = $user->id;
            }

            if ($request->hasFile('foto')) {
                $validated['foto'] = $request->file('foto')->store('siswa/foto', 'public');
            }

            unset($validated['buat_akun_baru'], $validated['user_email'], $validated['user_password']);

            Siswa::create($validated);
        });

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil ditambahkan.');
    }

    public function show(Siswa $siswa)
    {
        $siswa->load([
            'pengguna',
            'kelas.tahunAjaran',
            'orangTua',
            'absensi'    => fn($q) => $q->latest()->limit(20),
            'nilai.mataPelajaran',
            'pelanggaran' => fn($q) => $q->with('kategori')->latest()->limit(10),
        ]);

        $stats = [
            'persentase_kehadiran'   => $siswa->persentase_kehadiran,
            'total_poin_pelanggaran' => $siswa->total_poin_pelanggaran,
            'total_nilai'            => $siswa->nilai()->count(),
        ];

        return view('admin.siswa.show', compact('siswa', 'stats'));
    }

    public function edit(Siswa $siswa)
    {
        $kelas        = Kelas::aktif()->with('tahunAjaran')->orderBy('nama_kelas')->get();
        $tahunAjarans = TahunAjaran::orderByDesc('id')->get();

        return view('admin.siswa.edit', compact('siswa', 'kelas', 'tahunAjarans'));
    }

    public function update(Request $request, Siswa $siswa)
    {
        $validated = $request->validate([
            'nis'             => ['required', 'string', 'max:20', Rule::unique('siswa', 'nis')->ignore($siswa->id)],
            'nisn'            => ['nullable', 'string', 'max:20', Rule::unique('siswa', 'nisn')->ignore($siswa->id)],
            'nama_lengkap'    => ['required', 'string', 'max:150'],
            'jenis_kelamin'   => ['required', 'in:L,P'],
            'tempat_lahir'    => ['nullable', 'string', 'max:100'],
            'tanggal_lahir'   => ['nullable', 'date'],
            'agama'           => ['nullable', 'string', 'max:20'],
            'alamat'          => ['nullable', 'string'],
            'no_hp'           => ['nullable', 'string', 'max:20'],
            'email'           => ['nullable', 'email', 'max:100'],
            'foto'            => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'nama_ayah'       => ['nullable', 'string', 'max:150'],
            'pekerjaan_ayah'  => ['nullable', 'string', 'max:100'],
            'no_hp_ayah'      => ['nullable', 'string', 'max:20'],
            'nama_ibu'        => ['nullable', 'string', 'max:150'],
            'pekerjaan_ibu'   => ['nullable', 'string', 'max:100'],
            'no_hp_ibu'       => ['nullable', 'string', 'max:20'],
            'nama_wali'       => ['nullable', 'string', 'max:150'],
            'hubungan_wali'   => ['nullable', 'string', 'max:50'],
            'pekerjaan_wali'  => ['nullable', 'string', 'max:100'],
            'no_hp_wali'      => ['nullable', 'string', 'max:20'],
            'kelas_id'        => ['required', 'exists:kelas,id'],
            'tahun_ajaran_id' => ['required', 'exists:tahun_ajaran,id'],
            'status'          => ['required', 'in:aktif,tidak_aktif,lulus,pindah,keluar'],
            'tanggal_masuk'   => ['nullable', 'date'],
            'tanggal_keluar'  => ['nullable', 'date', 'after_or_equal:tanggal_masuk'],
        ], array_merge($this->validasiPesan(), [
            'tanggal_keluar.after_or_equal' => 'Tanggal keluar harus setelah atau sama dengan tanggal masuk.',
        ]));

        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $validated['foto'] = $request->file('foto')->store('siswa/foto', 'public');
        }

        if (!in_array($validated['status'], ['lulus', 'pindah', 'keluar'])) {
            $validated['tanggal_keluar'] = null;
        }

        $siswa->update($validated);

        return redirect()->route('admin.siswa.show', $siswa)
            ->with('success', 'Data siswa berhasil diperbarui.');
    }

    public function destroy(Siswa $siswa)
    {
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }
        $siswa->delete();

        return redirect()->route('admin.siswa.index')
            ->with('success', 'Data siswa berhasil dihapus.');
    }

    public function restore(int $id)
    {
        $siswa = Siswa::onlyTrashed()->findOrFail($id);
        $siswa->restore();

        return back()->with('success', 'Data siswa berhasil dipulihkan.');
    }

    public function pindahKelas(Request $request, Siswa $siswa)
    {
        $request->validate([
            'kelas_id' => ['required', 'exists:kelas,id'],
        ], [
            'kelas_id.required' => 'Kelas tujuan wajib dipilih.',
            'kelas_id.exists'   => 'Kelas tujuan tidak ditemukan.',
        ]);

        $kelas = Kelas::findOrFail($request->kelas_id);

        if ($kelas->isSudahPenuh()) {
            return back()->with('error', 'Kelas tujuan sudah penuh.');
        }

        if ($kelas->id === $siswa->kelas_id) {
            return back()->with('error', 'Siswa sudah berada di kelas tersebut.');
        }

        $siswa->update(['kelas_id' => $kelas->id]);

        return back()->with('success', "Siswa berhasil dipindah ke kelas {$kelas->nama_kelas}.");
    }

    public function exportPdf(Request $request)
    {
        $query = Siswa::with(['kelas', 'tahunAjaran']);

        if ($request->filled('kelas_id')) {
            $query->where('kelas_id', $request->kelas_id);
        }
        if ($request->filled('tahun_ajaran_id')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('jenis_kelamin')) {
            $query->where('jenis_kelamin', $request->jenis_kelamin);
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('nama_lengkap', 'like', "%{$s}%")
                                      ->orWhere('nis', 'like', "%{$s}%")
                                      ->orWhere('nisn', 'like', "%{$s}%"));
        }

        $siswa = $query->orderBy('nama_lengkap')->get();

        $filterParts = [];
        if ($request->filled('status')) {
            $filterParts[] = 'Status: ' . ucfirst(str_replace('_', ' ', $request->status));
        }
        if ($request->filled('jenis_kelamin')) {
            $filterParts[] = 'JK: ' . ($request->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan');
        }
        if ($request->filled('search')) {
            $filterParts[] = 'Cari: ' . $request->search;
        }
        $filterLabel = $filterParts ? implode(', ', $filterParts) : 'Semua Data';

        $pdf = Pdf::loadView('admin.siswa.pdf', compact('siswa', 'filterLabel'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('data-siswa-' . now()->format('Ymd-His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $filters  = $request->only(['kelas_id', 'tahun_ajaran_id', 'status', 'jenis_kelamin', 'search']);
        $filename = 'data-siswa-' . now()->format('Ymd-His') . '.xlsx';

        return Excel::download(new SiswaExport($filters), $filename);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimes:xlsx,xls,csv', 'max:5120'],
        ], [
            'file.required' => 'File import wajib dipilih.',
            'file.mimes'    => 'File harus berformat xlsx, xls, atau csv.',
            'file.max'      => 'Ukuran file tidak boleh lebih dari 5 MB.',
        ]);

        $import = new SiswaImport();
        Excel::import($import, $request->file('file'));

        $failures = $import->failures();
        $errors   = $import->errors();

        if ($failures->count() > 0 || $errors->count() > 0) {
            return back()->with('warning', "Import selesai dengan {$failures->count()} baris gagal. Pastikan kolom NIS dan Kelas sudah benar.");
        }

        return back()->with('success', 'Data siswa berhasil diimport.');
    }
}