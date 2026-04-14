<?php

namespace App\Exports;

use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\FromQuery;
// use Maatwebsite\Excel\Concerns\WithHeadings;
// use Maatwebsite\Excel\Concerns\WithMapping;
// use Maatwebsite\Excel\Concerns\WithStyles;
// use Maatwebsite\Excel\Concerns\WithColumnWidths;
// use Maatwebsite\Excel\Concerns\WithTitle;
// use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Carbon\Carbon;

class TeachersExport implements
    FromQuery
    // WithHeadings,
    // WithMapping,
    // WithStyles,
    // WithColumnWidths,
    // WithTitle
{
    /*
    |--------------------------------------------------------------------------
    | State — counter baris & cache total
    |--------------------------------------------------------------------------
    */
    private int $no       = 0;
    private int $total    = 0;
    private string $lastCol = 'M';

    public function __construct()
    {
        // Cache total agar tidak query ulang di styles()
        $this->total = Teacher::count();
    }

    /*
    |--------------------------------------------------------------------------
    | Query — semua guru beserta relasi user, urut nama
    |--------------------------------------------------------------------------
    */
    public function query()
    {
        return Teacher::with('user')->orderBy('nama_lengkap');
    }

    /*
    |--------------------------------------------------------------------------
    | Sheet Title
    |--------------------------------------------------------------------------
    */
    public function title(): string
    {
        return 'Data Guru';
    }

    /*
    |--------------------------------------------------------------------------
    | Headings — baris header kolom
    |--------------------------------------------------------------------------
    */
    public function headings(): array
    {
        return [
            'No',
            'NIP',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Agama',
            'Alamat',
            'No. HP',
            'Email',
            'Pendidikan Terakhir',
            'Status',
            'Nama Akun',
            'Email Akun',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Mapping — isi tiap baris data
    |--------------------------------------------------------------------------
    */
    public function map($teacher): array
    {
        $this->no++;

        return [
            $this->no,
            $teacher->nip                 ?? '-',
            $teacher->nama_lengkap        ?? '-',
            $teacher->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
            $teacher->tempat_lahir        ?? '-',
            $teacher->tanggal_lahir
                ? Carbon::parse($teacher->tanggal_lahir)->translatedFormat('d F Y')
                : '-',
            $teacher->agama               ?? '-',
            $teacher->alamat              ?? '-',
            $teacher->no_hp               ?? '-',
            $teacher->email               ?? '-',
            $teacher->pendidikan_terakhir ?? '-',
            $teacher->status
                ? ucfirst(str_replace('_', ' ', $teacher->status))
                : '-',
            $teacher->user->name          ?? '-',
            $teacher->user->email         ?? '-',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Column Widths — lebar tiap kolom (A–N)
    |--------------------------------------------------------------------------
    */
    public function columnWidths(): array
    {
        return [
            'A' => 5,    // No
            'B' => 22,   // NIP
            'C' => 30,   // Nama Lengkap
            'D' => 15,   // Jenis Kelamin
            'E' => 18,   // Tempat Lahir
            'F' => 18,   // Tanggal Lahir
            'G' => 15,   // Agama
            'H' => 35,   // Alamat
            'I' => 18,   // No. HP
            'J' => 28,   // Email
            'K' => 22,   // Pendidikan Terakhir
            'L' => 14,   // Status
            'M' => 25,   // Nama Akun
            'N' => 28,   // Email Akun
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Styles — styling header, body, zebra stripe
    |--------------------------------------------------------------------------
    */
    public function styles(Worksheet $sheet): array
    {
        $lastCol = 'N';
        $lastRow = $this->total + 1; // +1 karena heading di baris 1

        /*
         * ── Header row ─────────────────────────────────────────────────────
         */
        $sheet->getStyle("A1:{$lastCol}1")->applyFromArray([
            'font' => [
                'bold'  => true,
                'color' => ['argb' => 'FFFFFFFF'],
                'size'  => 11,
                'name'  => 'Calibri',
            ],
            'fill' => [
                'fillType'   => Fill::FILL_SOLID,
                'startColor' => ['argb' => 'FF1F63DB'],
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical'   => Alignment::VERTICAL_CENTER,
                'wrapText'   => true,
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['argb' => 'FF1750C0'],
                ],
            ],
        ]);

        // Tinggi header
        $sheet->getRowDimension(1)->setRowHeight(32);

        /*
         * ── Body rows ──────────────────────────────────────────────────────
         */
        if ($lastRow > 1) {
            $sheet->getStyle("A2:{$lastCol}{$lastRow}")->applyFromArray([
                'font' => [
                    'size' => 10,
                    'name' => 'Calibri',
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                    'wrapText' => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color'       => ['argb' => 'FFE2E8F0'],
                    ],
                ],
            ]);

            // Zebra stripe — baris genap
            for ($row = 2; $row <= $lastRow; $row++) {
                $sheet->getRowDimension($row)->setRowHeight(20);

                if ($row % 2 === 0) {
                    $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                        'fill' => [
                            'fillType'   => Fill::FILL_SOLID,
                            'startColor' => ['argb' => 'FFF1F5F9'],
                        ],
                    ]);
                }
            }

            // Center align: No, Jenis Kelamin, Tanggal Lahir, Agama, Status
            foreach (['A', 'D', 'F', 'G', 'L'] as $col) {
                $sheet->getStyle("{$col}2:{$col}{$lastRow}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        }

        /*
         * ── Freeze pane — header tetap saat scroll ─────────────────────────
         */
        $sheet->freezePane('A2');

        /*
         * ── Auto filter ────────────────────────────────────────────────────
         */
        $sheet->setAutoFilter("A1:{$lastCol}1");

        return [];
    }
}