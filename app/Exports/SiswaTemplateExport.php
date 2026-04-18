<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SiswaTemplateExport implements FromArray, WithHeadings, WithStyles, ShouldAutoSize, WithTitle, WithEvents
{
    public function array(): array
    {
        return [
            [
                '2024001',          // nis *
                '0012345678',       // nisn
                'Ahmad Fauzi',      // nama_lengkap *
                'Laki-laki',        // jenis_kelamin
                'Bandung',          // tempat_lahir
                '15/06/2008',       // tanggal_lahir
                'Islam',            // agama
                '08111234567',      // no_hp
                '',                 // email
                'Jl. Sudirman No.5',// alamat
                'X IPA 1',          // kelas * (harus sesuai nama_kelas di database)
                '2024/2025',        // tahun_ajaran
                'Aktif',            // status
                '15/07/2024',       // tanggal_masuk
                'Fauzi Senior',     // nama_ayah
                'Wiraswasta',       // pekerjaan_ayah
                '08222222222',      // no_hp_ayah
                'Siti Aminah',      // nama_ibu
                'Ibu Rumah Tangga', // pekerjaan_ibu
                '08333333333',      // no_hp_ibu
                '',                 // nama_wali
                '',                 // hubungan_wali
                '',                 // no_hp_wali
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'nis *',
            'nisn',
            'nama_lengkap *',
            'jenis_kelamin',
            'tempat_lahir',
            'tanggal_lahir',
            'agama',
            'no_hp',
            'email',
            'alamat',
            'kelas *',
            'tahun_ajaran',
            'status',
            'tanggal_masuk',
            'nama_ayah',
            'pekerjaan_ayah',
            'no_hp_ayah',
            'nama_ibu',
            'pekerjaan_ibu',
            'no_hp_ibu',
            'nama_wali',
            'hubungan_wali',
            'no_hp_wali',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1F63DB']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            2 => [
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFDCFCE7']],
            ],
        ];
    }

    public function title(): string { return 'Template Import Siswa'; }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $sheet->getRowDimension(1)->setRowHeight(20);
                $sheet->freezePane('A2');
            },
        ];
    }
}