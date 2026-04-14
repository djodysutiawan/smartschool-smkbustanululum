<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Material;
use App\Models\Teacher;
use App\Models\Subject;
use App\Models\Classes;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MaterialController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Material::with(['teacher', 'subject', 'class']);

        if ($request->filled('search')) {
            $query->where('judul', 'like', "%{$request->search}%");
        }

        $query->when($request->filled('subject_id'),
            fn ($q) => $q->where('subject_id', $request->subject_id)
        );

        $query->when($request->filled('class_id'),
            fn ($q) => $q->where('class_id', $request->class_id)
        );

        $query->when($request->filled('teacher_id'),
            fn ($q) => $q->where('teacher_id', $request->teacher_id)
        );

        $materials = $query->latest()->paginate($request->get('per_page', 10));

        return response()->json([
            'status'  => true,
            'message' => 'Data materi berhasil diambil.',
            'data'    => $materials,
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
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id'   => 'required|exists:classes,id',
            'judul'      => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
            'file'       => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,jpg,jpeg,png|max:20480',
        ]);

        $data = $request->only(['teacher_id', 'subject_id', 'class_id', 'judul', 'deskripsi']);

        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('materials', 'public');
        }

        $material = Material::create($data);
        $material->load(['teacher', 'subject', 'class']);

        return response()->json([
            'status'  => true,
            'message' => 'Materi berhasil ditambahkan.',
            'data'    => $material,
        ], 201);
    }

    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */
    public function show($id)
    {
        $material = Material::with(['teacher', 'subject', 'class'])->findOrFail($id);

        return response()->json([
            'status'  => true,
            'message' => 'Detail materi berhasil diambil.',
            'data'    => $material,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $material = Material::findOrFail($id);

        $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'subject_id' => 'required|exists:subjects,id',
            'class_id'   => 'required|exists:classes,id',
            'judul'      => 'required|string|max:255',
            'deskripsi'  => 'nullable|string',
            'file'       => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,jpg,jpeg,png|max:20480',
        ]);

        $data = $request->only(['teacher_id', 'subject_id', 'class_id', 'judul', 'deskripsi']);

        if ($request->hasFile('file')) {
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $data['file_path'] = $request->file('file')->store('materials', 'public');
        }

        $material->update($data);
        $material->load(['teacher', 'subject', 'class']);

        return response()->json([
            'status'  => true,
            'message' => 'Materi berhasil diupdate.',
            'data'    => $material,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $material = Material::findOrFail($id);

        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        return response()->json([
            'status'  => true,
            'message' => 'Materi berhasil dihapus.',
        ]);
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
            'ids.*' => 'exists:materials,id',
        ]);

        $materials = Material::whereIn('id', $request->ids)->get();

        foreach ($materials as $material) {
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            $material->delete();
        }

        return response()->json([
            'status'  => true,
            'message' => count($request->ids) . ' materi berhasil dihapus.',
        ]);
    }
}