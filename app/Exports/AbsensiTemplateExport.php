<?php

namespace App\Exports;
 
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
 
class AbsensiTemplateExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize, WithTitle
{
    public function collection()
    {
        // Baris contoh agar user memahami format
        return collect([
            [
                'siswa_nis'           => '12345',
                'kelas_nama'          => 'X IPA 1',
                'tanggal'             => '2025-01-15',
                'status'              => 'hadir',          // hadir|telat|izin|sakit|alfa
                'metode'              => 'manual',          // manual|qr
                'jam_masuk'           => '07:30',
                'jam_keluar'          => '15:00',
                'keterangan'          => '',
            ],
        ]);
    }
 
    public function headings(): array
    {
        return [
            'siswa_nis', 'kelas_nama', 'tanggal', 'status',
            'metode', 'jam_masuk', 'jam_keluar', 'keterangan',
        ];
    }
 
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'DC2626']],
            ],
        ];
    }
 
    public function title(): string
    {
        return 'Template Import Absensi';
    }
}