<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\TahunAjaran;

class MateriTemplateExport implements FromArray, WithHeadings, WithStyles, WithTitle, WithColumnWidths, WithEvents
{
    public function array(): array
    {
        return [
            [
                '',         // guru_id
                '',         // mata_pelajaran_id
                '',         // kelas_id
                '',         // tahun_ajaran_id
                'Contoh Judul Materi',
                'Deskripsi singkat materi ini.',
                'teks',     // jenis: file|video|link|teks
                '',         // url_eksternal
                1,          // urutan
                1,          // dipublikasikan: 1 atau 0
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'guru_id*',
            'mata_pelajaran_id*',
            'kelas_id*',
            'tahun_ajaran_id*',
            'judul*',
            'deskripsi',
            'jenis* (file|video|link|teks)',
            'url_eksternal',
            'urutan',
            'dipublikasikan (1/0)',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 22,
            'C' => 15,
            'D' => 18,
            'E' => 35,
            'F' => 40,
            'G' => 28,
            'H' => 35,
            'I' => 12,
            'J' => 22,
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1B4332']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'wrapText' => true],
            ],
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // Baris panduan referensi ID di sheet ke-2
                $sheet->getParent()->createSheet()->setTitle('Referensi');
                $refSheet = $sheet->getParent()->getSheetByName('Referensi');

                // Header referensi
                $refSheet->setCellValue('A1', 'REFERENSI DATA UNTUK IMPORT MATERI');
                $refSheet->mergeCells('A1:H1');
                $refSheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 13, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1B4332']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Guru
                $refSheet->setCellValue('A3', 'ID Guru');
                $refSheet->setCellValue('B3', 'Nama Guru');
                $refSheet->getStyle('A3:B3')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF2D6A4F']],
                ]);
                $row = 4;
                foreach (Guru::aktif()->orderBy('nama_lengkap')->get() as $guru) {
                    $refSheet->setCellValue('A' . $row, $guru->id);
                    $refSheet->setCellValue('B' . $row, $guru->nama_lengkap);
                    $row++;
                }

                // Mata Pelajaran
                $refSheet->setCellValue('D3', 'ID Mapel');
                $refSheet->setCellValue('E3', 'Nama Mapel');
                $refSheet->getStyle('D3:E3')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF2D6A4F']],
                ]);
                $row = 4;
                foreach (MataPelajaran::aktif()->orderBy('nama_mapel')->get() as $mapel) {
                    $refSheet->setCellValue('D' . $row, $mapel->id);
                    $refSheet->setCellValue('E' . $row, $mapel->nama_mapel);
                    $row++;
                }

                // Kelas
                $refSheet->setCellValue('G3', 'ID Kelas');
                $refSheet->setCellValue('H3', 'Nama Kelas');
                $refSheet->getStyle('G3:H3')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF2D6A4F']],
                ]);
                $row = 4;
                foreach (Kelas::aktif()->orderBy('nama_kelas')->get() as $kelas) {
                    $refSheet->setCellValue('G' . $row, $kelas->id);
                    $refSheet->setCellValue('H' . $row, $kelas->nama_kelas);
                    $row++;
                }

                // Tahun Ajaran
                $refSheet->setCellValue('J3', 'ID Tahun Ajaran');
                $refSheet->setCellValue('K3', 'Tahun');
                $refSheet->getStyle('J3:K3')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF2D6A4F']],
                ]);
                $row = 4;
                foreach (TahunAjaran::orderByDesc('tahun')->get() as $ta) {
                    $refSheet->setCellValue('J' . $row, $ta->id);
                    $refSheet->setCellValue('K' . $row, $ta->tahun);
                    $row++;
                }

                foreach (['A','B','D','E','G','H','J','K'] as $col) {
                    $refSheet->getColumnDimension($col)->setWidth(20);
                }

                // Validasi dropdown jenis di kolom G (template sheet)
                $validation = $sheet->getCell('G2')->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION);
                $validation->setAllowBlank(false);
                $validation->setShowDropDown(true);
                $validation->setFormula1('"file,video,link,teks"');
                $validation->setSqref('G2:G1000');
            },
        ];
    }

    public function title(): string
    {
        return 'Template Import Materi';
    }
}