<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Classes;

use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Schedule::with(['teacher', 'subject', 'class']);

        $query->when($request->filled('class_id'),
            fn ($q) => $q->where('class_id', $request->class_id)
        );

        $query->when($request->filled('teacher_id'),
            fn ($q) => $q->where('teacher_id', $request->teacher_id)
        );

        $query->when($request->filled('hari'),
            fn ($q) => $q->where('hari', $request->hari)
        );

        return view('admin.schedules.index', [
            'schedules' => $query->orderBy('hari')->orderBy('jam_mulai')->paginate(10)->withQueryString(),
            'classes'   => Classes::all(),
            'teachers'  => Teacher::all(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.schedules.create', [
            'teachers' => Teacher::all(),
            'subjects' => Subject::all(),
            'classes'  => Classes::all(),
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
            'teacher_id'  => 'required|exists:teachers,id',
            'subject_id'  => 'required|exists:subjects,id',
            'class_id'    => 'required|exists:classes,id',
            'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        Schedule::create($request->only([
            'teacher_id', 'subject_id', 'class_id',
            'hari', 'jam_mulai', 'jam_selesai',
        ]));

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $schedule = Schedule::with(['teacher', 'subject', 'class'])->findOrFail($id);

        return view('admin.schedules.show', compact('schedule'));
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $schedule = Schedule::findOrFail($id);

        return view('admin.schedules.edit', [
            'schedule' => $schedule,
            'teachers' => Teacher::all(),
            'subjects' => Subject::all(),
            'classes'  => Classes::all(),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::findOrFail($id);

        $request->validate([
            'teacher_id'  => 'required|exists:teachers,id',
            'subject_id'  => 'required|exists:subjects,id',
            'class_id'    => 'required|exists:classes,id',
            'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
            'jam_mulai'   => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        $schedule->update($request->only([
            'teacher_id', 'subject_id', 'class_id',
            'hari', 'jam_mulai', 'jam_selesai',
        ]));

        return redirect()
            ->route('admin.schedules.index')
            ->with('success', 'Jadwal berhasil diupdate.');
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        Schedule::findOrFail($id)->delete();

        return back()->with('success', 'Jadwal berhasil dihapus.');
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
            'ids.*' => 'exists:schedules,id',
        ]);

        Schedule::whereIn('id', $request->ids)->delete();

        return back()->with('success', count($request->ids) . ' jadwal berhasil dihapus.');
    }
}