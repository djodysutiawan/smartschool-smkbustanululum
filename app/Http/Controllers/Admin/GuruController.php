<?php

namespace App\Http\Controllers\Admin;

use App\Exports\GuruExport;
use App\Http\Controllers\Controller;
use App\Imports\GuruImport;
use App\Models\Guru;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;

class GuruController extends Controller
{
    private function validasiPesan(): array
    {
        return [
            'required'             => ':attribute wajib diisi.',
            'required_if'          => ':attribute wajib diisi.',
            'string'               => ':attribute harus berupa teks.',
            'max'                  => ':attribute tidak boleh lebih dari :max karakter.',
            'min'                  => ':attribute minimal :min karakter.',
            'email'                => ':attribute harus berupa alamat email yang valid.',
            'unique'               => ':attribute sudah digunakan, gunakan yang lain.',
            'exists'               => ':attribute yang dipilih tidak valid.',
            'in'                   => ':attribute yang dipilih tidak valid.',
            'nullable'             => ':attribute boleh kosong.',
            'date'                 => ':attribute harus berupa tanggal yang valid.',
            'integer'              => ':attribute harus berupa angka.',
            'image'                => ':attribute harus berupa gambar (JPG/PNG).',
            'mimes'                => ':attribute harus berformat: :values.',
            'boolean'              => ':attribute tidak valid.',
            'nip.unique'           => 'NIP sudah digunakan oleh guru lain.',
            'email.unique'         => 'Email sudah digunakan.',
            'user_email.unique'    => 'Email akun sudah terdaftar di sistem.',
            'user_email.required_if' => 'Email akun wajib diisi jika membuat akun baru.',
            'user_password.required_if' => 'Kata sandi wajib diisi jika membuat akun baru.',
            'pengguna_id.required_if' => 'Akun pengguna wajib dipilih jika tidak membuat akun baru.',
        ];
    }

    public function index(Request $request)
    {
        $query = Guru::with('pengguna')->withCount(['kelasWali', 'jadwalPelajaran']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('status_kepegawaian')) {
            $query->where('status_kepegawaian', $request->status_kepegawaian);
        }
        if ($request->filled('adalah_guru_piket')) {
            $query->where('adalah_guru_piket', $request->boolean('adalah_guru_piket'));
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('nama_lengkap', 'like', "%{$s}%")
                                      ->orWhere('nip', 'like', "%{$s}%")
                                      ->orWhere('email', 'like', "%{$s}%"));
        }

        $guru  = $query->orderBy('nama_lengkap')->paginate(20)->withQueryString();
        $stats = [
            'total'  => Guru::count(),
            'aktif'  => Guru::aktif()->count(),
            'piket'  => Guru::piket()->count(),
            'pns'    => Guru::where('status_kepegawaian', 'pns')->count(),
        ];

        return view('admin.guru.index', compact('guru', 'stats'));
    }

    public function create()
    {
        $availableUsers = User::where('role', 'guru')
            ->whereDoesntHave('guru')
            ->orderBy('name')
            ->get();

        return view('admin.guru.create', compact('availableUsers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'buat_akun_baru'      => ['boolean'],
            'user_name'           => ['required_if:buat_akun_baru,1', 'nullable', 'string', 'max:255'],
            'user_email'          => ['required_if:buat_akun_baru,1', 'nullable', 'email', 'unique:users,email'],
            'user_password'       => ['required_if:buat_akun_baru,1', 'nullable', 'string', 'min:8'],
            'pengguna_id'         => ['nullable', Rule::requiredIf(fn() => !$request->boolean('buat_akun_baru') && $request->filled('pengguna_id')), 'exists:users,id'],
            'nip'                 => ['nullable', 'string', 'max:30', 'unique:guru,nip'],
            'nama_lengkap'        => ['required', 'string', 'max:150'],
            'jenis_kelamin'       => ['required', 'in:L,P'],
            'tempat_lahir'        => ['nullable', 'string', 'max:100'],
            'tanggal_lahir'       => ['nullable', 'date'],
            'alamat'              => ['nullable', 'string'],
            'no_hp'               => ['nullable', 'string', 'max:20'],
            'email'               => ['nullable', 'email', 'max:100'],
            'foto'                => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'pendidikan_terakhir' => ['nullable', 'string', 'max:20'],
            'jurusan_pendidikan'  => ['nullable', 'string', 'max:100'],
            'universitas'         => ['nullable', 'string', 'max:150'],
            'tahun_lulus'         => ['nullable', 'integer', 'min:1980', 'max:' . date('Y')],
            'status_kepegawaian'  => ['required', 'in:pns,p3k,honorer,gtty'],
            'tanggal_masuk'       => ['nullable', 'date'],
            'adalah_guru_piket'   => ['boolean'],
            'status'              => ['required', 'in:aktif,tidak_aktif,cuti'],
        ], $this->validasiPesan());

        DB::transaction(function () use ($request, $validated) {
            if ($request->boolean('buat_akun_baru')) {
                $user = User::create([
                    'name'      => $validated['user_name'],
                    'email'     => $validated['user_email'],
                    'password'  => Hash::make($validated['user_password']),
                    'role'      => 'guru',
                    'is_active' => true,
                ]);
                $user->assignRole('guru');
                $validated['pengguna_id'] = $user->id;
            }

            if ($request->hasFile('foto')) {
                $validated['foto'] = $request->file('foto')->store('guru/foto', 'public');
            }

            unset(
                $validated['buat_akun_baru'],
                $validated['user_name'],
                $validated['user_email'],
                $validated['user_password']
            );

            Guru::create($validated);
        });

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil ditambahkan.');
    }

    public function show(Guru $guru)
    {
        $guru->load([
            'pengguna',
            'kelasWali.tahunAjaran',
            'ketersediaan' => fn($q) => $q->orderBy('hari')->orderBy('jam_mulai'),
            'jadwalPelajaran' => fn($q) => $q->aktif()->with(['kelas', 'mataPelajaran']),
        ]);

        $stats = [
            'total_kelas_wali'   => $guru->kelasWali()->count(),
            'total_jadwal'       => $guru->jadwalPelajaran()->aktif()->count(),
            'total_ketersediaan' => $guru->ketersediaan()->tersedia()->count(),
        ];

        return view('admin.guru.show', compact('guru', 'stats'));
    }

    public function edit(Guru $guru)
    {
        $guru->load('pengguna');
        return view('admin.guru.edit', compact('guru'));
    }

    public function update(Request $request, Guru $guru)
    {
        $validated = $request->validate([
            'nip'                 => ['nullable', 'string', 'max:30', Rule::unique('guru', 'nip')->ignore($guru->id)],
            'nama_lengkap'        => ['required', 'string', 'max:150'],
            'jenis_kelamin'       => ['required', 'in:L,P'],
            'tempat_lahir'        => ['nullable', 'string', 'max:100'],
            'tanggal_lahir'       => ['nullable', 'date'],
            'alamat'              => ['nullable', 'string'],
            'no_hp'               => ['nullable', 'string', 'max:20'],
            'email'               => ['nullable', 'email', 'max:100'],
            'foto'                => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'pendidikan_terakhir' => ['nullable', 'string', 'max:20'],
            'jurusan_pendidikan'  => ['nullable', 'string', 'max:100'],
            'universitas'         => ['nullable', 'string', 'max:150'],
            'tahun_lulus'         => ['nullable', 'integer', 'min:1980', 'max:' . date('Y')],
            'status_kepegawaian'  => ['required', 'in:pns,p3k,honorer,gtty'],
            'tanggal_masuk'       => ['nullable', 'date'],
            'adalah_guru_piket'   => ['boolean'],
            'status'              => ['required', 'in:aktif,tidak_aktif,cuti'],
        ], $this->validasiPesan());

        if ($request->hasFile('foto')) {
            if ($guru->foto) {
                Storage::disk('public')->delete($guru->foto);
            }
            $validated['foto'] = $request->file('foto')->store('guru/foto', 'public');
        }

        $guru->update($validated);

        return redirect()->route('admin.guru.show', $guru)
            ->with('success', 'Data guru berhasil diperbarui.');
    }

    public function destroy(Guru $guru)
    {
        if ($guru->jadwalPelajaran()->aktif()->exists()) {
            return back()->with('error', 'Guru masih memiliki jadwal pelajaran aktif dan tidak dapat dihapus.');
        }

        if ($guru->foto) {
            Storage::disk('public')->delete($guru->foto);
        }

        $guru->delete();

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru berhasil dihapus.');
    }

    public function exportPdf(Request $request)
    {
        $query = Guru::with('pengguna')->withCount('jadwalPelajaran');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('status_kepegawaian')) {
            $query->where('status_kepegawaian', $request->status_kepegawaian);
        }
        if ($request->filled('adalah_guru_piket')) {
            $query->where('adalah_guru_piket', $request->boolean('adalah_guru_piket'));
        }
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(fn($q) => $q->where('nama_lengkap', 'like', "%{$s}%")
                                      ->orWhere('nip', 'like', "%{$s}%")
                                      ->orWhere('email', 'like', "%{$s}%"));
        }

        $guru = $query->orderBy('nama_lengkap')->get();

        $filterParts = [];
        if ($request->filled('status')) {
            $filterParts[] = 'Status: ' . ucfirst(str_replace('_', ' ', $request->status));
        }
        if ($request->filled('status_kepegawaian')) {
            $filterParts[] = 'Kepegawaian: ' . strtoupper($request->status_kepegawaian);
        }
        if ($request->filled('search')) {
            $filterParts[] = 'Cari: ' . $request->search;
        }
        $filterLabel = $filterParts ? implode(', ', $filterParts) : 'Semua Data';

        $pdf = Pdf::loadView('admin.guru.pdf', compact('guru', 'filterLabel'))
                  ->setPaper('a4', 'landscape');

        return $pdf->download('data-guru-' . now()->format('Ymd-His') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $filters  = $request->only(['status', 'status_kepegawaian', 'adalah_guru_piket', 'search']);
        $filename = 'data-guru-' . now()->format('Ymd-His') . '.xlsx';

        return Excel::download(new GuruExport($filters), $filename);
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

        $import = new GuruImport();
        Excel::import($import, $request->file('file'));

        $failures = $import->failures();
        $errors   = $import->errors();

        if ($failures->count() > 0 || $errors->count() > 0) {
            return back()->with('warning', "Import selesai dengan {$failures->count()} baris gagal divalidasi. Periksa kembali data Anda.");
        }

        return back()->with('success', 'Data guru berhasil diimport.');
    }
}