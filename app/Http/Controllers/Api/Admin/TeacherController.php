<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

use App\Exports\TeachersExport;
use Maatwebsite\Excel\Facades\Excel;

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

        return response()->json([
            'success' => true,
            'data'    => $query->latest()->paginate(10)->withQueryString(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'          => 'required|string|max:100',
                'email'         => 'required|email|unique:users,email',
                'password'      => 'required|min:8',
                'nip'           => 'required|unique:teachers,nip',
                'nama_lengkap'  => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:L,P',
                'tempat_lahir'  => 'nullable|string|max:100',
                'tanggal_lahir' => 'nullable|date',
                'agama'         => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
                'alamat'        => 'nullable|string|max:500',
                'no_hp'         => 'nullable|string|max:20',
                'status'        => 'nullable|in:aktif,tidak_aktif',
                'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
                'role'     => 'guru',
            ]);

            $teacher = Teacher::create([
                'user_id'       => $user->id,
                'nip'           => $request->nip,
                'nama_lengkap'  => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama'         => $request->agama,
                'alamat'        => $request->alamat,
                'no_hp'         => $request->no_hp,
                'email'         => $request->email,
                'status'        => $request->status ?? 'aktif',
                'foto'          => $request->hasFile('foto')
                                    ? $this->uploadFoto($request->file('foto'))
                                    : null,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data guru berhasil ditambahkan.',
                'data'    => $teacher->load(['user', 'classes']),
            ], 201);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $teacher = Teacher::with(['user', 'classes'])->find($id);

        if (! $teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Guru tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $teacher,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $teacher = Teacher::with('user')->find($id);

        if (! $teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Guru tidak ditemukan.',
            ], 404);
        }

        try {
            $request->validate([
                'name'          => 'sometimes|string|max:100',
                'email'         => "sometimes|email|unique:users,email,{$teacher->user_id}",
                'password'      => 'sometimes|min:8',
                'nip'           => "required|unique:teachers,nip,{$id}",
                'nama_lengkap'  => 'required|string|max:255',
                'jenis_kelamin' => 'required|in:L,P',
                'tempat_lahir'  => 'nullable|string|max:100',
                'tanggal_lahir' => 'nullable|date',
                'agama'         => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
                'alamat'        => 'nullable|string|max:500',
                'no_hp'         => 'nullable|string|max:20',
                'status'        => 'nullable|in:aktif,tidak_aktif',
                'foto'          => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        DB::beginTransaction();

        try {
            $userPayload = [];
            if ($request->filled('name'))     $userPayload['name']     = $request->name;
            if ($request->filled('email'))    $userPayload['email']    = $request->email;
            if ($request->filled('password')) $userPayload['password'] = bcrypt($request->password);

            if (! empty($userPayload)) {
                $teacher->user->update($userPayload);
            }

            if ($request->hasFile('foto')) {
                if ($teacher->foto) {
                    Storage::disk('public')->delete($teacher->foto);
                }
                $teacher->foto = $this->uploadFoto($request->file('foto'));
            }

            $teacher->update([
                'nip'           => $request->nip,
                'nama_lengkap'  => $request->nama_lengkap,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir'  => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'agama'         => $request->agama,
                'alamat'        => $request->alamat,
                'no_hp'         => $request->no_hp,
                'email'         => $request->filled('email') ? $request->email : $teacher->email,
                'status'        => $request->status,
                'foto'          => $teacher->foto,
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data guru berhasil diupdate.',
                'data'    => $teacher->fresh(['user', 'classes']),
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupdate data: ' . $e->getMessage(),
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $teacher = Teacher::with('user')->find($id);

        if (! $teacher) {
            return response()->json([
                'success' => false,
                'message' => 'Guru tidak ditemukan.',
            ], 404);
        }

        if ($teacher->foto) {
            Storage::disk('public')->delete($teacher->foto);
        }

        $teacher->delete();
        $teacher->user?->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data guru berhasil dihapus.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | BULK DELETE
    |--------------------------------------------------------------------------
    */
    public function bulkDelete(Request $request)
    {
        try {
            $request->validate([
                'ids'   => 'required|array',
                'ids.*' => 'exists:teachers,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $teachers = Teacher::with('user')->whereIn('id', $request->ids)->get();

        foreach ($teachers as $teacher) {
            if ($teacher->foto) {
                Storage::disk('public')->delete($teacher->foto);
            }
            $teacher->delete();
            $teacher->user?->delete();
        }

        return response()->json([
            'success' => true,
            'message' => count($request->ids) . ' data guru berhasil dihapus.',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT
    |--------------------------------------------------------------------------
    */
    public function export()
    {
        return Excel::download(new TeachersExport, 'teachers.xlsx');
    }

    /*
    |--------------------------------------------------------------------------
    | STATS
    |--------------------------------------------------------------------------
    */
    public function stats()
    {
        return response()->json([
            'success' => true,
            'data'    => [
                'total'       => Teacher::count(),
                'aktif'       => Teacher::where('status', 'aktif')->count(),
                'tidak_aktif' => Teacher::where('status', 'tidak_aktif')->count(),
                'laki_laki'   => Teacher::where('jenis_kelamin', 'L')->count(),
                'perempuan'   => Teacher::where('jenis_kelamin', 'P')->count(),
            ],
        ]);
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

        if (! $source) {
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