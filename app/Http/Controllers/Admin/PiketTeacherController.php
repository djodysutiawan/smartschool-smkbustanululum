<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeacherAvailability;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PiketTeacherController extends Controller
{
    /** Hari yang valid */
    private const HARI = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];

    /**
     * GET /admin/piket-teachers
     */
    public function index(Request $request)
    {
        $query = TeacherAvailability::with('teacher:id,nama_lengkap,nip,foto,status');

        // Filter: cari nama / NIP guru
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('teacher', fn ($q) =>
                $q->where('nama_lengkap', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
            );
        }

        // Filter: hari
        if ($request->filled('hari')) {
            $query->where('hari', $request->hari);
        }

        // Filter: status guru (aktif / nonaktif)
        if ($request->filled('status')) {
            $query->whereHas('teacher', fn ($q) =>
                $q->where('status', $request->status)
            );
        }

        $piketTeachers = $query
            ->orderByRaw("FIELD(hari, 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu')")
            ->orderBy('jam_mulai')
            ->paginate(10)
            ->withQueryString();

        $teachers = Teacher::where('status', 'aktif')
                           ->orderBy('nama_lengkap')
                           ->get();

        $hariList = self::HARI;

        return view('admin.piket-teachers.index', compact(
            'piketTeachers', 'teachers', 'hariList'
        ));
    }

    /**
     * GET /admin/piket-teachers/create
     */
    public function create()
    {
        $teachers = Teacher::where('status', 'aktif')
                           ->orderBy('nama_lengkap')
                           ->get();
        $hariList = self::HARI;

        return view('admin.piket-teachers.create', compact('teachers', 'hariList'));
    }

    /**
     * POST /admin/piket-teachers
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_id'  => 'required|exists:teachers,id',
            'hari'        => ['required', Rule::in(self::HARI)],
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        // Cegah duplikasi: guru + hari yang sama
        $exists = TeacherAvailability::where('teacher_id', $request->teacher_id)
                                      ->where('hari', $request->hari)
                                      ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'teacher_id' => 'Guru ini sudah memiliki jadwal piket pada hari yang sama.',
                ]);
        }

        TeacherAvailability::create([
            'teacher_id'  => $request->teacher_id,
            'hari'        => $request->hari,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()
            ->route('admin.piket-teachers.index')
            ->with('success', 'Jadwal guru piket berhasil ditambahkan.');
    }

    /**
     * GET /admin/piket-teachers/{piketTeacher}
     */
    public function show(TeacherAvailability $piketTeacher)
    {
        $piketTeacher->load('teacher.user');

        return view('admin.piket-teachers.show', compact('piketTeacher'));
    }

    /**
     * GET /admin/piket-teachers/{piketTeacher}/edit
     */
    public function edit(TeacherAvailability $piketTeacher)
    {
        $teachers = Teacher::where('status', 'aktif')
                           ->orderBy('nama_lengkap')
                           ->get();
        $hariList = self::HARI;

        return view('admin.piket-teachers.edit', compact(
            'piketTeacher', 'teachers', 'hariList'
        ));
    }

    /**
     * PUT /admin/piket-teachers/{piketTeacher}
     */
    public function update(Request $request, TeacherAvailability $piketTeacher)
    {
        $request->validate([
            'teacher_id'  => 'required|exists:teachers,id',
            'hari'        => ['required', Rule::in(self::HARI)],
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        // Cegah duplikasi, kecuali record dirinya sendiri
        $exists = TeacherAvailability::where('teacher_id', $request->teacher_id)
                                      ->where('hari', $request->hari)
                                      ->where('id', '!=', $piketTeacher->id)
                                      ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'teacher_id' => 'Guru ini sudah memiliki jadwal piket pada hari yang sama.',
                ]);
        }

        $piketTeacher->update([
            'teacher_id'  => $request->teacher_id,
            'hari'        => $request->hari,
            'jam_mulai'   => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()
            ->route('admin.piket-teachers.index')
            ->with('success', 'Jadwal guru piket berhasil diperbarui.');
    }

    /**
     * DELETE /admin/piket-teachers/{piketTeacher}
     */
    public function destroy(TeacherAvailability $piketTeacher)
    {
        $piketTeacher->delete();

        return redirect()
            ->route('admin.piket-teachers.index')
            ->with('success', 'Jadwal guru piket berhasil dihapus.');
    }

    /**
     * DELETE /admin/piket-teachers/bulk/delete
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array|min:1',
            'ids.*' => 'exists:teacher_availability,id',
        ]);

        DB::transaction(function () use ($request) {
            TeacherAvailability::whereIn('id', $request->ids)->delete();
        });

        return redirect()
            ->route('admin.piket-teachers.index')
            ->with('success', count($request->ids) . ' jadwal guru piket berhasil dihapus.');
    }
}