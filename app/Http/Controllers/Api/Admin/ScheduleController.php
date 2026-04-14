<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Schedule;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

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

        return response()->json([
            'success' => true,
            'data'    => $query->orderBy('hari')->orderBy('jam_mulai')->paginate(10)->withQueryString(),
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
                'teacher_id'  => 'required|exists:teachers,id',
                'subject_id'  => 'required|exists:subjects,id',
                'class_id'    => 'required|exists:classes,id',
                'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
                'jam_mulai'   => 'required|date_format:H:i',
                'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $schedule = Schedule::create($request->only([
            'teacher_id', 'subject_id', 'class_id',
            'hari', 'jam_mulai', 'jam_selesai',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil ditambahkan.',
            'data'    => $schedule->load(['teacher', 'subject', 'class']),
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $schedule = Schedule::with(['teacher', 'subject', 'class'])->find($id);

        if (! $schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data'    => $schedule,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $schedule = Schedule::find($id);

        if (! $schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan.',
            ], 404);
        }

        try {
            $request->validate([
                'teacher_id'  => 'required|exists:teachers,id',
                'subject_id'  => 'required|exists:subjects,id',
                'class_id'    => 'required|exists:classes,id',
                'hari'        => 'required|in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu',
                'jam_mulai'   => 'required|date_format:H:i',
                'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        $schedule->update($request->only([
            'teacher_id', 'subject_id', 'class_id',
            'hari', 'jam_mulai', 'jam_selesai',
        ]));

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil diupdate.',
            'data'    => $schedule->fresh(['teacher', 'subject', 'class']),
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $schedule = Schedule::find($id);

        if (! $schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal tidak ditemukan.',
            ], 404);
        }

        $schedule->delete();

        return response()->json([
            'success' => true,
            'message' => 'Jadwal berhasil dihapus.',
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
                'ids.*' => 'exists:schedules,id',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal.',
                'errors'  => $e->errors(),
            ], 422);
        }

        Schedule::whereIn('id', $request->ids)->delete();

        return response()->json([
            'success' => true,
            'message' => count($request->ids) . ' jadwal berhasil dihapus.',
        ]);
    }
}