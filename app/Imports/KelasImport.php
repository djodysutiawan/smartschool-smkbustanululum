<?php

namespace App\Imports;
 
use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Ruang;
use App\Models\TahunAjaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
 
class KelasImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnError
{
    use SkipsErrors;
 
    public function model(array $row)
    {
        $tahunAjaran = TahunAjaran::where('tahun', $row['tahun_ajaran'])->first();
        $ruang       = Ruang::where('kode_ruang', $row['ruang'] ?? null)->first();
 
        return new Kelas([
            'kode_kelas'      => strtoupper($row['kode_kelas']),
            'nama_kelas'      => $row['nama_kelas'],
            'tingkat'         => strtoupper($row['tingkat']),
            'jurusan'         => $row['jurusan'] ?? null,
            'tahun_ajaran_id' => $tahunAjaran?->id,
            'ruang_id'        => $ruang?->id,
            'kapasitas_maks'  => (int) ($row['kapasitas'] ?? 36),
            'status'          => strtolower($row['status'] ?? 'aktif'),
        ]);
    }
 
    public function rules(): array
    {
        return [
            'kode_kelas'  => ['required', 'unique:kelas,kode_kelas'],
            'nama_kelas'  => ['required'],
            'tingkat'     => ['required', 'in:X,XI,XII'],
            'tahun_ajaran' => ['required'],
        ];
    }
 
    public function customValidationMessages(): array
    {
        return [
            'kode_kelas.required'   => 'Kolom kode kelas wajib diisi.',
            'kode_kelas.unique'     => 'Kode kelas sudah terdaftar.',
            'nama_kelas.required'   => 'Kolom nama kelas wajib diisi.',
            'tingkat.required'      => 'Kolom tingkat wajib diisi.',
            'tingkat.in'            => 'Tingkat harus berupa X, XI, atau XII.',
            'tahun_ajaran.required' => 'Kolom tahun ajaran wajib diisi.',
        ];
    }
}