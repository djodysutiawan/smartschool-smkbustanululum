<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SoalUjianTemplateExport implements
    FromArray,
    WithHeadings,
    WithStyles,
    WithTitle,
    ShouldAutoSize,
    WithColumnWidths
{
    /*
    |--------------------------------------------------------------------------
    | Contoh data (1 baris) agar pengguna paham formatnya
    |--------------------------------------------------------------------------
    */
    public function array(): array
    {
        return [
            [
                1,                  // No / nomor_soal (boleh kosong, otomatis)
                'pilihan_ganda',    // jenis_soal: pilihan_ganda | essay | benar_salah
                'Ibu kota Indonesia adalah ...?',  // pertanyaan
                10,                 // bobot (1-100)
                'Jakarta',          // Pilihan A
                'Surabaya',         // Pilihan B
                'Bandung',          // Pilihan C
                'Medan',            // Pilihan D
                '',                 // Pilihan E (opsional)
                'A',                // Jawaban Benar (kode pilihan, pisah koma jika >1)
            ],
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Headings
    |--------------------------------------------------------------------------
    */
    public function headings(): array
    {
        return [
            'nomor_soal',
            'jenis_soal',
            'pertanyaan',
            'bobot',
            'pilihan_a',
            'pilihan_b',
            'pilihan_c',
            'pilihan_d',
            'pilihan_e',
            'jawaban_benar',
        ];
    }

    public function title(): string
    {
        return 'Template Soal';
    }

    public function columnWidths(): array
    {
        return [
            'C' => 50,  // kolom pertanyaan lebih lebar
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Styles
    |--------------------------------------------------------------------------
    */
    public function styles(Worksheet $sheet): array
    {
        // Wrap text pada kolom pertanyaan
        $sheet->getStyle('C')->getAlignment()->setWrapText(true);

        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF16A34A'],  // hijau
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            // Baris contoh — warna latar kuning muda
            2 => [
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFFEF9C3'],
                ],
            ],
        ];
    }
}