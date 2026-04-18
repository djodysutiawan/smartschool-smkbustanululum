<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UjianTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        return [
            ['Ujian Tengah Semester Matematika', 'uts', '1', '1', '1', '1', '2025-03-15', '08:00', '90', '75'],
        ];
    }

    public function headings(): array
    {
        return [
            'judul*',
            'jenis* (ulangan_harian/uts/uas/remedial/quiz)',
            'guru_id*',
            'mata_pelajaran_id*',
            'kelas_id*',
            'tahun_ajaran_id*',
            'tanggal* (YYYY-MM-DD)',
            'jam_mulai (HH:MM)',
            'durasi_menit*',
            'nilai_kkm',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']], 'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']]],
        ];
    }
}