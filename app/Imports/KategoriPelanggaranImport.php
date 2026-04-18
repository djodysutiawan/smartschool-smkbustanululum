<?php

namespace App\Imports;

use App\Models\KategoriPelanggaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Illuminate\Validation\Rule;

class KategoriPelanggaranImport implements
    ToModel,
    WithHeadingRow,
    WithValidation,
    SkipsOnError
{
    use SkipsErrors;

    public function model(array $row): ?KategoriPelanggaran
    {
        // Skip jika nama sudah ada (upsert by nama)
        $existing = KategoriPelanggaran::where('nama', $row['nama'])->first();

        if ($existing) {
            $existing->update([
                'deskripsi'    => $row['deskripsi'] ?? null,
                'tingkat'      => $row['tingkat'],
                'poin_default' => $row['poin_default'],
                'batas_poin'   => $row['batas_poin'] ?? null,
                'warna'        => $row['warna'] ?? null,
                'is_active'    => isset($row['is_active']) ? (bool) $row['is_active'] : true,
            ]);

            return null; // update, bukan insert baru
        }

        return new KategoriPelanggaran([
            'nama'         => $row['nama'],
            'deskripsi'    => $row['deskripsi'] ?? null,
            'tingkat'      => $row['tingkat'],
            'poin_default' => $row['poin_default'],
            'batas_poin'   => $row['batas_poin'] ?? null,
            'warna'        => $row['warna'] ?? null,
            'is_active'    => isset($row['is_active']) ? (bool) $row['is_active'] : true,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama'         => ['required', 'string', 'max:100'],
            'tingkat'      => ['required', Rule::in(['ringan', 'sedang', 'berat'])],
            'poin_default' => ['required', 'integer', 'min:1', 'max:100'],
            'batas_poin'   => ['nullable', 'integer', 'min:1'],
            'is_active'    => ['nullable'],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'nama.required'         => 'Kolom nama wajib diisi.',
            'nama.max'              => 'Nama kategori maksimal 100 karakter.',
            'tingkat.required'      => 'Kolom tingkat wajib diisi.',
            'tingkat.in'            => 'Tingkat harus ringan, sedang, atau berat.',
            'poin_default.required' => 'Kolom poin_default wajib diisi.',
            'poin_default.integer'  => 'Poin default harus berupa angka.',
            'poin_default.min'      => 'Poin default minimal 1.',
            'poin_default.max'      => 'Poin default maksimal 100.',
        ];
    }
}