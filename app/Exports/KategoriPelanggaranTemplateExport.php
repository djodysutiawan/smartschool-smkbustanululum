<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class KategoriPelanggaranTemplateExport implements
    FromArray,
    WithHeadings,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    public function array(): array
    {
        // Contoh data agar pengguna tahu format yang diharapkan
        return [
            [
                'Bolos Sekolah',
                'Tidak masuk tanpa keterangan',
                'sedang',
                10,
                50,
                '#f59e0b',
                1,
            ],
            [
                'Terlambat',
                'Datang terlambat lebih dari 15 menit',
                'ringan',
                5,
                30,
                '#3b82f6',
                1,
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'nama',          // required | string | max:100 | unique
            'deskripsi',     // nullable | string
            'tingkat',       // required | ringan / sedang / berat
            'poin_default',  // required | integer | min:1 | max:100
            'batas_poin',    // nullable | integer | min:1
            'warna',         // nullable | string (hex atau nama warna)
            'is_active',     // required | 1 = aktif, 0 = nonaktif
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        // Style baris heading (instruksi kolom)
        $sheet->getRowDimension(1)->setRowHeight(22);

        return [
            1 => [
                'font' => [
                    'bold'  => true,
                    'color' => ['argb' => 'FFFFFFFF'],
                    'size'  => 11,
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF1F63DB'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color'       => ['argb' => 'FFBFDBFE'],
                    ],
                ],
            ],
            // Style baris contoh data
            2 => [
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFFFFBEB'],
                ],
            ],
            3 => [
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFFFFBEB'],
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Template Import';
    }
}