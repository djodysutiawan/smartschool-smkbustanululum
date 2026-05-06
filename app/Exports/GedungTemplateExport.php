<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class GedungTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    /**
     * Baris contoh data — hapus baris ini saat mengisi template.
     */
    public function array(): array
    {
        return [
            ['GDG-A', 'Gedung A', 3, 'Gedung utama sekolah', 1],
            ['GDG-B', 'Gedung B', 2, 'Gedung laboratorium', 1],
        ];
    }

    public function headings(): array
    {
        return [
            'kode_gedung',   // maks 10 karakter, unik
            'nama_gedung',   // maks 100 karakter
            'jumlah_lantai', // angka 1–20
            'deskripsi',     // opsional
            'is_active',     // 1 = aktif, 0 = nonaktif
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 30,
            'C' => 16,
            'D' => 40,
            'E' => 12,
        ];
    }
}