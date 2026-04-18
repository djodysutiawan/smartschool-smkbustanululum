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
use PhpOffice\PhpSpreadsheet\Style\Border;

class JadwalPelajaranTemplateExport implements
    FromArray,
    WithHeadings,
    WithStyles,
    WithColumnWidths,
    WithTitle
{
    public function title(): string
    {
        return 'Template Import';
    }

    public function headings(): array
    {
        return [
            'tahun_ajaran_id',      // ID tahun ajaran (integer)
            'guru_id',              // ID guru (integer)
            'mata_pelajaran_id',    // ID mata pelajaran (integer)
            'kelas_id',             // ID kelas (integer)
            'ruang_id',             // ID ruang (integer, boleh kosong)
            'hari',                 // senin/selasa/rabu/kamis/jumat/sabtu
            'jam_mulai',            // Format: 07:00
            'jam_selesai',          // Format: 08:30
            'pertemuan_ke',         // Angka (boleh kosong)
            'sumber_jadwal',        // manual / otomatis
            'is_active',            // 1 = aktif, 0 = tidak aktif
        ];
    }

    public function array(): array
    {
        // Baris contoh data
        return [
            [1, 1, 1, 1, 1, 'senin',  '07:00', '08:30', 1, 'manual', 1],
            [1, 2, 2, 1, 2, 'selasa', '08:30', '10:00', 2, 'manual', 1],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 18, 'B' => 10, 'C' => 20, 'D' => 12,
            'E' => 12, 'F' => 12, 'G' => 12, 'H' => 14,
            'I' => 14, 'J' => 16, 'K' => 12,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        // Style header row
        $sheet->getStyle('A1:K1')->applyFromArray([
            'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 11],
            'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1f63db']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'borders'   => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'FFFFFF']]],
        ]);

        // Style data rows
        $sheet->getStyle('A2:K3')->applyFromArray([
            'fill'    => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EEF6FF']],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN, 'color' => ['rgb' => 'CBD5E1']]],
        ]);

        // Header row height
        $sheet->getRowDimension(1)->setRowHeight(22);

        // Petunjuk di bawah data (row 5 dst)
        $notes = [
            5  => '⚠ PETUNJUK PENGISIAN:',
            6  => '• tahun_ajaran_id  → lihat ID di halaman Tahun Ajaran',
            7  => '• guru_id          → lihat ID di halaman Guru',
            8  => '• mata_pelajaran_id → lihat ID di halaman Mata Pelajaran',
            9  => '• kelas_id         → lihat ID di halaman Kelas',
            10 => '• ruang_id         → lihat ID di halaman Ruang (boleh dikosongkan)',
            11 => '• hari             → isi dengan: senin / selasa / rabu / kamis / jumat / sabtu',
            12 => '• jam_mulai / jam_selesai → format HH:MM, contoh: 07:00',
            13 => '• pertemuan_ke     → angka urutan pertemuan (boleh dikosongkan)',
            14 => '• sumber_jadwal    → isi dengan: manual / otomatis',
            15 => '• is_active        → 1 = aktif, 0 = tidak aktif',
            16 => '• Hapus baris contoh (baris 2–3) sebelum mengimpor',
        ];

        foreach ($notes as $row => $text) {
            $sheet->setCellValue("A{$row}", $text);
            $sheet->getStyle("A{$row}")->applyFromArray([
                'font'  => [
                    'color' => ['rgb' => $row === 5 ? 'dc2626' : '475569'],
                    'bold'  => $row === 5,
                    'size'  => 10,
                ],
            ]);
            $sheet->mergeCells("A{$row}:K{$row}");
        }

        return [];
    }
}