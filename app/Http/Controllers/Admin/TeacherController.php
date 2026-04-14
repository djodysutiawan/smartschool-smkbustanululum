<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
// use App\Models\Classes;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class TeacherController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Teacher::with(['user', 'classes']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
                  ->orWhere('nip', 'like', "%{$request->search}%");
            });
        }

        $query->when($request->filled('status'),
            fn ($q) => $q->where('status', $request->status)
        );

        $query->when($request->filled('jenis_kelamin'),
            fn ($q) => $q->where('jenis_kelamin', $request->jenis_kelamin)
        );

        return view('admin.teachers.index', [
            'teachers' => $query->latest()->paginate(10)->withQueryString(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.teachers.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            // Akun
            'name'           => 'required|string|max:100',
            'email'          => 'required|email|unique:users,email',
            'password'       => 'required|min:8',
            // Identitas
            'nip'            => 'required|unique:teachers,nip',
            'nama_lengkap'   => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:L,P',
            'tempat_lahir'   => 'nullable|string|max:100',
            'tanggal_lahir'  => 'nullable|date',
            'agama'          => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'alamat'         => 'nullable|string|max:500',
            'no_hp'          => 'nullable|string|max:20',
            'status'         => 'nullable|in:aktif,tidak_aktif',
            // Foto
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
                'role'     => 'guru',
            ]);

            Teacher::create([
                'user_id'        => $user->id,
                'nip'            => $request->nip,
                'nama_lengkap'   => $request->nama_lengkap,
                'jenis_kelamin'  => $request->jenis_kelamin,
                'tempat_lahir'   => $request->tempat_lahir,
                'tanggal_lahir'  => $request->tanggal_lahir,
                'agama'          => $request->agama,
                'alamat'         => $request->alamat,
                'no_hp'          => $request->no_hp,
                'email'          => $request->email,
                'status'         => $request->status ?? 'aktif',
                'foto'           => $request->hasFile('foto')
                                        ? $this->uploadFoto($request->file('foto'))
                                        : null,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.teachers.index')
                ->with('success', 'Data guru berhasil ditambahkan.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $teacher = Teacher::with(['user', 'classes'])->findOrFail($id);

        return view('admin.teachers.show', compact('teacher'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);

        return view('admin.teachers.edit', compact('teacher'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);

        $request->validate([
            // Akun
            'name'           => 'required|string|max:100',
            'email'          => "required|email|unique:users,email,{$teacher->user_id}",
            // Identitas
            'nip'            => "required|unique:teachers,nip,{$id}",
            'nama_lengkap'   => 'required|string|max:255',
            'jenis_kelamin'  => 'required|in:L,P',
            'tempat_lahir'   => 'nullable|string|max:100',
            'tanggal_lahir'  => 'nullable|date',
            'agama'          => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'alamat'         => 'nullable|string|max:500',
            'no_hp'          => 'nullable|string|max:20',
            'status'         => 'nullable|in:aktif,tidak_aktif',
            // Foto
            'foto'           => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        DB::beginTransaction();

        try {
            $teacher->user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            if ($request->hasFile('foto')) {
                if ($teacher->foto) {
                    Storage::disk('public')->delete($teacher->foto);
                }
                $teacher->foto = $this->uploadFoto($request->file('foto'));
            }

            $teacher->update([
                'nip'            => $request->nip,
                'nama_lengkap'   => $request->nama_lengkap,
                'jenis_kelamin'  => $request->jenis_kelamin,
                'tempat_lahir'   => $request->tempat_lahir,
                'tanggal_lahir'  => $request->tanggal_lahir,
                'agama'          => $request->agama,
                'alamat'         => $request->alamat,
                'no_hp'          => $request->no_hp,
                'email'          => $request->email,
                'status'         => $request->status,
                'foto'           => $teacher->foto,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.teachers.index')
                ->with('success', 'Data guru berhasil diupdate.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);

        if ($teacher->foto) {
            Storage::disk('public')->delete($teacher->foto);
        }

        $teacher->delete();
        $teacher->user?->delete();

        return back()->with('success', 'Data guru berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | BULK DELETE
    |--------------------------------------------------------------------------
    */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'exists:teachers,id',
        ]);

        $teachers = Teacher::with('user')->whereIn('id', $request->ids)->get();

        foreach ($teachers as $teacher) {
            if ($teacher->foto) {
                Storage::disk('public')->delete($teacher->foto);
            }
            $teacher->delete();
            $teacher->user?->delete();
        }

        return back()->with('success', count($request->ids) . ' data guru berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | PRIVATE HELPER — Upload & resize foto
    |--------------------------------------------------------------------------
    */
    private function uploadFoto(UploadedFile $file): string
    {
        $rawData = file_get_contents($file->getPathname());

        set_error_handler(function () {}, E_WARNING);
        $source = imagecreatefromstring($rawData);
        restore_error_handler();

        if (!$source) {
            throw new \RuntimeException('File gambar tidak valid atau format tidak didukung.');
        }

        $srcW = imagesx($source);
        $srcH = imagesy($source);
        $size = min($srcW, $srcH);
        $srcX = (int) (($srcW - $size) / 2);
        $srcY = (int) (($srcH - $size) / 2);

        $canvas = imagecreatetruecolor(300, 300);
        imagecopyresampled($canvas, $source, 0, 0, $srcX, $srcY, 300, 300, $size, $size);

        $filename = 'teachers/' . uniqid() . '.jpg';
        $tmpPath  = sys_get_temp_dir() . '/' . uniqid() . '.jpg';

        imagejpeg($canvas, $tmpPath, 75);
        imagedestroy($source);
        imagedestroy($canvas);

        Storage::disk('public')->put($filename, file_get_contents($tmpPath));
        @unlink($tmpPath);

        return $filename;
    }
}