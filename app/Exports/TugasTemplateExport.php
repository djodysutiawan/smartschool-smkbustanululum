<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TugasTemplateExport implements FromArray, WithHeadings, WithStyles
{
    public function array(): array
    {
        return [
            [1, 1, 1, 1, 'Judul Tugas Contoh', 'Deskripsi tugas', 'file', '2025-12-31 23:59', 100, 0, 1],
        ];
    }

    public function headings(): array
    {
        return [
            'guru_id', 'mata_pelajaran_id', 'kelas_id', 'tahun_ajaran_id',
            'judul', 'deskripsi', 'jenis_pengumpulan (file/teks/link/foto)',
            'batas_waktu (Y-m-d H:i)', 'nilai_maksimal', 'izinkan_terlambat (0/1)',
            'dipublikasikan (0/1)',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}