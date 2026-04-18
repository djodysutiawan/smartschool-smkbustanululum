<?php

namespace App\Imports;
 
use App\Models\TahunAjaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
 
class TahunAjaranImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;
 
    public function model(array $row)
    {
        return new TahunAjaran([
            'tahun'           => $row['tahun'],
            'semester'        => strtolower($row['semester']),
            'tanggal_mulai'   => \Carbon\Carbon::createFromFormat('d/m/Y', $row['tanggal_mulai'])->format('Y-m-d'),
            'tanggal_selesai' => \Carbon\Carbon::createFromFormat('d/m/Y', $row['tanggal_selesai'])->format('Y-m-d'),
            'status'          => strtolower($row['status']) === 'aktif' ? 'aktif' : 'tidak_aktif',
            'keterangan'      => $row['keterangan'] ?? null,
        ]);
    }
 
    public function rules(): array
    {
        return [
            'tahun'           => ['required', 'string'],
            'semester'        => ['required'],
            'tanggal_mulai'   => ['required'],
            'tanggal_selesai' => ['required'],
        ];
    }
 
    public function customValidationMessages(): array
    {
        return [
            'tahun.required'           => 'Kolom tahun wajib diisi.',
            'semester.required'        => 'Kolom semester wajib diisi.',
            'tanggal_mulai.required'   => 'Kolom tanggal mulai wajib diisi.',
            'tanggal_selesai.required' => 'Kolom tanggal selesai wajib diisi.',
        ];
    }
}