<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PelanggaranTemplateExport implements
    FromArray,
    WithHeadings,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    public function array(): array
    {
        // Contoh data — hapus sebelum diisi data asli
        return [
            [
                '2026-04-18', // tanggal: format YYYY-MM-DD
                '12345',      // nis siswa (harus sudah ada di tabel siswa)
                1,            // kategori_pelanggaran_id (ID dari tabel kategori_pelanggaran)
                10,           // poin (1–100)
                'Siswa ketahuan bolos pada jam pelajaran ke-3.',
                'Dipanggil orang tua.',
                'diproses',   // status: pending / diproses / selesai / banding
            ],
            [
                '2026-04-17',
                '12346',
                2,
                5,
                'Terlambat masuk kelas 20 menit.',
                null,
                'pending',
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'tanggal',                  // required | date (YYYY-MM-DD)
            'nis',                      // required | harus cocok dengan kolom nis di tabel siswa
            'kategori_pelanggaran_id',  // required | integer (ID kategori)
            'poin',                     // required | integer | min:1 | max:100
            'deskripsi',                // required | string
            'tindakan',                 // nullable | string
            'status',                   // required | pending / diproses / selesai / banding
        ];
    }

    public function styles(Worksheet $sheet): array
    {
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
                    'startColor' => ['argb' => 'FFDC2626'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color'       => ['argb' => 'FFFECACA'],
                    ],
                ],
            ],
            2 => [
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFFFF1F2'],
                ],
            ],
            3 => [
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFFFF1F2'],
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Template Import';
    }
}