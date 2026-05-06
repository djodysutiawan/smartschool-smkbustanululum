<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class MataPelajaranTemplateExport implements
    FromArray,
    WithHeadings,
    WithStyles,
    WithColumnWidths,
    WithTitle
{
    public function title(): string
    {
        return 'Template Mata Pelajaran';
    }

    public function headings(): array
    {
        return [
            'nama_mapel',
            'kode_mapel',
            'kelompok',
            'scope',
            'jam_per_minggu',
            'durasi_per_sesi',
            'perlu_lab',
            'keterangan',
            'is_active',
        ];
    }

    /**
     * Satu baris contoh agar pengguna tahu format yang diharapkan.
     */
    public function array(): array
    {
        return [
            [
                'Matematika',       // nama_mapel
                'MTK-01',           // kode_mapel
                'normatif',         // kelompok: normatif|adaptif|produktif|muatan_lokal|pengembangan_diri
                'umum',             // scope: umum|jurusan
                4,                  // jam_per_minggu (1–20)
                45,                 // durasi_per_sesi dalam menit (30–180)
                0,                  // perlu_lab: 1=Ya, 0=Tidak
                'Contoh keterangan',// keterangan (opsional)
                1,                  // is_active: 1=Aktif, 0=Nonaktif
            ],
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        // Header row styling
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1F63DB'],
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            // Baris contoh — warna latar lebih terang
            2 => [
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'EEF6FF'],
                ],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30, // nama_mapel
            'B' => 15, // kode_mapel
            'C' => 20, // kelompok
            'D' => 12, // scope
            'E' => 16, // jam_per_minggu
            'F' => 18, // durasi_per_sesi
            'G' => 12, // perlu_lab
            'H' => 35, // keterangan
            'I' => 12, // is_active
        ];
    }
}