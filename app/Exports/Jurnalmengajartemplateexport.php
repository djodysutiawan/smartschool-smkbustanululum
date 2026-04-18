<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JurnalMengajarTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize
{
    public function array(): array
    {
        return [
            [1, 1, 1, null, '2025-03-15', 1, 'Materi ajar contoh', 'ceramah', 30, 2, 'Catatan kelas contoh'],
        ];
    }

    public function headings(): array
    {
        return [
            'guru_id*',
            'kelas_id*',
            'mata_pelajaran_id*',
            'jadwal_pelajaran_id',
            'tanggal* (YYYY-MM-DD)',
            'pertemuan_ke',
            'materi_ajar*',
            'metode_pembelajaran (ceramah/diskusi/praktikum/demonstrasi/proyek/lainnya)',
            'jumlah_hadir',
            'jumlah_tidak_hadir',
            'catatan_kelas',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']]],
        ];
    }
}