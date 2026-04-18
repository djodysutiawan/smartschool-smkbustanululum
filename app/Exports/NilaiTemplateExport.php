<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NilaiTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        return [
            [1, 1, 1, 1, 1, 80, 85, 78, 82, 'Contoh catatan'],
        ];
    }

    public function headings(): array
    {
        return [
            'siswa_id*',
            'mata_pelajaran_id*',
            'guru_id*',
            'kelas_id*',
            'tahun_ajaran_id*',
            'nilai_tugas (0-100)',
            'nilai_harian (0-100)',
            'nilai_uts (0-100)',
            'nilai_uas (0-100)',
            'catatan',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']]],
        ];
    }
}