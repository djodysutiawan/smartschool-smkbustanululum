<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Classes;
use App\Models\AcademicYear;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Exports\StudentsExport;
use Maatwebsite\Excel\Facades\Excel;

class StudentController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Student::with(['class', 'academicYear', 'user']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_lengkap', 'like', "%{$request->search}%")
                  ->orWhere('nis',  'like', "%{$request->search}%")
                  ->orWhere('nisn', 'like', "%{$request->search}%");
            });
        }

        $query->when($request->class_id,
            fn ($q) => $q->where('class_id', $request->class_id)
        );

        $query->when($request->academic_year_id,
            fn ($q) => $q->where('academic_year_id', $request->academic_year_id)
        );

        $query->when($request->status,
            fn ($q) => $q->where('status', $request->status)
        );

        return view('admin.students.index', [
            'students' => $query->latest()->paginate(10)->withQueryString(),
            'classes'  => Classes::all(),
            'years'    => AcademicYear::all(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.students.create', [
            'classes' => Classes::all(),
            'years'   => AcademicYear::all(),
        ]);
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
            'name'              => 'required|string|max:100',
            'email'             => 'required|email|unique:users,email',
            'password'          => 'required|min:8',
            // Identitas
            'nis'               => 'required|unique:students,nis',
            'nisn'              => 'required|digits:10|unique:students,nisn',
            'nama_lengkap'      => 'required|string|max:255',
            'jenis_kelamin'     => 'required|in:L,P',
            'tempat_lahir'      => 'nullable|string|max:100',
            'tanggal_lahir'     => 'nullable|date',
            'agama'             => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'alamat'            => 'nullable|string|max:500',
            'no_hp'             => 'nullable|string|max:20',
            // Akademik
            'class_id'          => 'nullable|exists:classes,id',
            'academic_year_id'  => 'nullable|exists:academic_years,id',
            'status'            => 'nullable|in:aktif,lulus,pindah',
            // Orang tua – ayah
            'nama_ayah'         => 'nullable|string|max:255',
            'pekerjaan_ayah'    => 'nullable|string|max:100',
            'no_hp_ayah'        => 'nullable|string|max:20',
            // Orang tua – ibu
            'nama_ibu'          => 'nullable|string|max:255',
            'pekerjaan_ibu'     => 'nullable|string|max:100',
            'no_hp_ibu'         => 'nullable|string|max:20',
            // Wali
            'nama_wali'         => 'nullable|string|max:255',
            'pekerjaan_wali'    => 'nullable|string|max:100',
            'no_hp_wali'        => 'nullable|string|max:20',
            // Foto
            'foto'              => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        DB::beginTransaction();

        try {
            $user = User::create([
                'name'     => $request->name,
                'email'    => $request->email,
                'password' => bcrypt($request->password),
                'role'     => 'siswa',
            ]);

            Student::create([
                'user_id'          => $user->id,
                // Identitas
                'nis'              => $request->nis,
                'nisn'             => $request->nisn,
                'nama_lengkap'     => $request->nama_lengkap,
                'jenis_kelamin'    => $request->jenis_kelamin,
                'tempat_lahir'     => $request->tempat_lahir,
                'tanggal_lahir'    => $request->tanggal_lahir,
                'agama'            => $request->agama,
                'alamat'           => $request->alamat,
                'no_hp'            => $request->no_hp,
                'email'            => $request->email,
                // Akademik
                'class_id'         => $request->class_id,
                'academic_year_id' => $request->academic_year_id,
                'status'           => $request->status ?? 'aktif',
                // Orang tua
                'nama_ayah'        => $request->nama_ayah,
                'pekerjaan_ayah'   => $request->pekerjaan_ayah,
                'no_hp_ayah'       => $request->no_hp_ayah,
                'nama_ibu'         => $request->nama_ibu,
                'pekerjaan_ibu'    => $request->pekerjaan_ibu,
                'no_hp_ibu'        => $request->no_hp_ibu,
                'nama_wali'        => $request->nama_wali,
                'pekerjaan_wali'   => $request->pekerjaan_wali,
                'no_hp_wali'       => $request->no_hp_wali,
                // Foto
                'foto'             => $request->hasFile('foto')
                                        ? $this->uploadFoto($request->file('foto'))
                                        : null,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.students.index')
                ->with('success', 'Data siswa berhasil ditambahkan.');

        } catch (\Throwable $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $student = Student::with('user')->findOrFail($id);

        return view('admin.students.edit', [
            'student' => $student,
            'classes' => Classes::all(),
            'years'   => AcademicYear::all(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $student = Student::with('user')->findOrFail($id);

        $request->validate([
            // Akun
            'name'              => 'required|string|max:100',
            'email'             => "required|email|unique:users,email,{$student->user_id}",
            // Identitas
            'nis'               => "required|unique:students,nis,{$id}",
            'nisn'              => "required|digits:10|unique:students,nisn,{$id}",
            'nama_lengkap'      => 'required|string|max:255',
            'jenis_kelamin'     => 'required|in:L,P',
            'tempat_lahir'      => 'nullable|string|max:100',
            'tanggal_lahir'     => 'nullable|date',
            'agama'             => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'alamat'            => 'nullable|string|max:500',
            'no_hp'             => 'nullable|string|max:20',
            // Akademik
            'class_id'          => 'nullable|exists:classes,id',
            'academic_year_id'  => 'nullable|exists:academic_years,id',
            'status'            => 'nullable|in:aktif,lulus,pindah',
            // Orang tua – ayah
            'nama_ayah'         => 'nullable|string|max:255',
            'pekerjaan_ayah'    => 'nullable|string|max:100',
            'no_hp_ayah'        => 'nullable|string|max:20',
            // Orang tua – ibu
            'nama_ibu'          => 'nullable|string|max:255',
            'pekerjaan_ibu'     => 'nullable|string|max:100',
            'no_hp_ibu'         => 'nullable|string|max:20',
            // Wali
            'nama_wali'         => 'nullable|string|max:255',
            'pekerjaan_wali'    => 'nullable|string|max:100',
            'no_hp_wali'        => 'nullable|string|max:20',
            // Foto
            'foto'              => 'nullable|image|mimes:jpg,jpeg,png|max:5120',
        ]);

        DB::beginTransaction();

        try {
            $student->user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            if ($request->hasFile('foto')) {
                if ($student->foto) {
                    Storage::disk('public')->delete($student->foto);
                }
                $student->foto = $this->uploadFoto($request->file('foto'));
            }

            $student->update([
                // Identitas
                'nis'              => $request->nis,
                'nisn'             => $request->nisn,
                'nama_lengkap'     => $request->nama_lengkap,
                'jenis_kelamin'    => $request->jenis_kelamin,
                'tempat_lahir'     => $request->tempat_lahir,
                'tanggal_lahir'    => $request->tanggal_lahir,
                'agama'            => $request->agama,
                'alamat'           => $request->alamat,
                'no_hp'            => $request->no_hp,
                'email'            => $request->email,
                // Akademik
                'class_id'         => $request->class_id,
                'academic_year_id' => $request->academic_year_id,
                'status'           => $request->status,
                // Orang tua
                'nama_ayah'        => $request->nama_ayah,
                'pekerjaan_ayah'   => $request->pekerjaan_ayah,
                'no_hp_ayah'       => $request->no_hp_ayah,
                'nama_ibu'         => $request->nama_ibu,
                'pekerjaan_ibu'    => $request->pekerjaan_ibu,
                'no_hp_ibu'        => $request->no_hp_ibu,
                'nama_wali'        => $request->nama_wali,
                'pekerjaan_wali'   => $request->pekerjaan_wali,
                'no_hp_wali'       => $request->no_hp_wali,
                // Foto
                'foto'             => $student->foto,
            ]);

            DB::commit();

            return redirect()
                ->route('admin.students.index')
                ->with('success', 'Data siswa berhasil diupdate.');

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
        $student = Student::with('user')->findOrFail($id);

        if ($student->foto) {
            Storage::disk('public')->delete($student->foto);
        }

        $student->delete();
        $student->user?->delete();

        return back()->with('success', 'Data siswa berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $student = Student::with(['user', 'class', 'academicYear'])->findOrFail($id);

        return view('admin.students.show', compact('student'));
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
            'ids.*' => 'exists:students,id',
        ]);

        $students = Student::with('user')->whereIn('id', $request->ids)->get();

        foreach ($students as $student) {
            if ($student->foto) {
                Storage::disk('public')->delete($student->foto);
            }
            $student->delete();
            $student->user?->delete();
        }

        return back()->with('success', count($request->ids) . ' data siswa berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | EXPORT EXCEL
    |--------------------------------------------------------------------------
    */
    public function export()
    {
        return Excel::download(new StudentsExport, 'students.xlsx');
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
            throw new \RuntimeException(
                'File gambar tidak valid atau format tidak didukung.'
            );
        }

        $srcW = imagesx($source);
        $srcH = imagesy($source);

        $size = min($srcW, $srcH);
        $srcX = (int) (($srcW - $size) / 2);
        $srcY = (int) (($srcH - $size) / 2);

        $canvas = imagecreatetruecolor(300, 300);
        imagecopyresampled($canvas, $source, 0, 0, $srcX, $srcY, 300, 300, $size, $size);

        $filename = 'students/' . uniqid() . '.jpg';
        $tmpPath  = sys_get_temp_dir() . '/' . uniqid() . '.jpg';

        imagejpeg($canvas, $tmpPath, 75);
        imagedestroy($source);
        imagedestroy($canvas);

        Storage::disk('public')->put($filename, file_get_contents($tmpPath));
        @unlink($tmpPath);

        return $filename;
    }
}