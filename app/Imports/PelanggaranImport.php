<?php

namespace App\Imports;

use App\Models\Pelanggaran;
use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PelanggaranImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnError
{
    use SkipsErrors;

    public function model(array $row): ?Pelanggaran
    {
        // Resolve NIS → siswa_id
        $siswa = Siswa::where('nis', $row['nis'])->first();

        if (!$siswa) {
            // NIS tidak ditemukan — skip baris ini
            return null;
        }

        return new Pelanggaran([
            'siswa_id'                => $siswa->id,
            'kategori_pelanggaran_id' => $row['kategori_pelanggaran_id'],
            'poin'                    => $row['poin'],
            'deskripsi'               => $row['deskripsi'],
            'tanggal'                 => \Carbon\Carbon::parse($row['tanggal'])->format('Y-m-d'),
            'tindakan'                => $row['tindakan'] ?? null,
            'status'                  => $row['status'] ?? 'pending',
            'dicatat_oleh'            => Auth::id(),
        ]);
    }

    public function rules(): array
    {
        return [
            'tanggal'                 => ['required', 'date'],
            'nis'                     => ['required', 'string'],
            'kategori_pelanggaran_id' => ['required', 'integer', 'exists:kategori_pelanggaran,id'],
            'poin'                    => ['required', 'integer', 'min:1', 'max:100'],
            'deskripsi'               => ['required', 'string'],
            'tindakan'                => ['nullable', 'string'],
            'status'                  => ['nullable', Rule::in(['pending', 'diproses', 'selesai', 'banding'])],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'tanggal.required'                 => 'Kolom tanggal wajib diisi.',
            'tanggal.date'                     => 'Format tanggal tidak valid (gunakan YYYY-MM-DD).',
            'nis.required'                     => 'Kolom nis wajib diisi.',
            'kategori_pelanggaran_id.required' => 'Kolom kategori_pelanggaran_id wajib diisi.',
            'kategori_pelanggaran_id.exists'   => 'ID kategori pelanggaran tidak ditemukan.',
            'poin.required'                    => 'Kolom poin wajib diisi.',
            'poin.min'                         => 'Poin minimal 1.',
            'poin.max'                         => 'Poin maksimal 100.',
            'deskripsi.required'               => 'Kolom deskripsi wajib diisi.',
            'status.in'                        => 'Status harus: pending, diproses, selesai, atau banding.',
        ];
    }
}