<?php

namespace App\Exports;

use App\Models\SesiGerbang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use Illuminate\Support\Collection;
use Carbon\Carbon;

class SesiGerbangExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    WithColumnWidths,
    WithEvents
{
    protected array $filters;
    protected Collection $data;
    protected int $dataCount = 0;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    // ── Data ─────────────────────────────────────────────────────────────────

    public function collection(): Collection
    {
        $query = SesiGerbang::with(['dibukaOleh', 'ditutupOleh'])
            ->withCount([
                'absensiGerbang as jumlah_scan' => fn ($q) =>
                    $q->whereIn('status', ['normal', 'manual', 'koreksi']),
            ]);

        if (!empty($this->filters['tanggal_dari'])) {
            $query->where('tanggal', '>=', $this->filters['tanggal_dari']);
        }
        if (!empty($this->filters['tanggal_sampai'])) {
            $query->where('tanggal', '<=', $this->filters['tanggal_sampai']);
        }
        if (!empty($this->filters['tipe'])) {
            $query->where('tipe', $this->filters['tipe']);
        }
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        $this->data = $query->orderByDesc('tanggal')
                            ->orderByDesc('dibuka_pada')
                            ->get();

        $this->dataCount = $this->data->count();

        return $this->data;
    }

    // ── Headings ─────────────────────────────────────────────────────────────

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Hari',
            'Tipe Sesi',
            'Status',
            'Dibuka Pukul',
            'Ditutup Pukul',
            'Durasi (menit)',
            'Dibuka Oleh',
            'Ditutup Oleh',
            'Jumlah Scan Valid',
        ];
    }

    // ── Row mapping ───────────────────────────────────────────────────────────

    public function map($sesi): array
    {
        static $no = 0;
        $no++;

        // Hitung durasi dalam menit
        $durasi = null;
        if ($sesi->ditutup_pada) {
            $durasi = $sesi->dibuka_pada->diffInMinutes($sesi->ditutup_pada);
        }

        return [
            $no,
            Carbon::parse($sesi->tanggal)->format('d/m/Y'),
            Carbon::parse($sesi->tanggal)->isoFormat('dddd'),
            $sesi->label_tipe,
            ucfirst($sesi->status),
            $sesi->dibuka_pada->format('H:i'),
            $sesi->ditutup_pada ? $sesi->ditutup_pada->format('H:i') : '—',
            $durasi ?? ($sesi->status === 'aktif' ? 'Sedang berjalan' : '—'),
            $sesi->dibukaOleh?->name ?? '—',
            $sesi->ditutupOleh?->name ?? '—',
            $sesi->jumlah_scan,
        ];
    }

    // ── Sheet title ───────────────────────────────────────────────────────────

    public function title(): string
    {
        return 'Sesi Gerbang';
    }

    // ── Column widths ─────────────────────────────────────────────────────────

    public function columnWidths(): array
    {
        return [
            'A' =>  5,   // No
            'B' => 14,   // Tanggal
            'C' => 16,   // Hari
            'D' => 16,   // Tipe
            'E' => 12,   // Status
            'F' => 14,   // Dibuka
            'G' => 14,   // Ditutup
            'H' => 16,   // Durasi
            'I' => 22,   // Dibuka oleh
            'J' => 22,   // Ditutup oleh
            'K' => 18,   // Scan
        ];
    }

    // ── Styles ────────────────────────────────────────────────────────────────

    public function styles(Worksheet $sheet): array
    {
        // Row 1 = judul besar, row 2 = info filter, row 3 = kosong, row 4 = heading tabel
        return [
            // Judul
            1 => [
                'font' => ['bold' => true, 'size' => 13, 'color' => ['rgb' => '1F63DB']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
            ],
            // Info sub-judul
            2 => [
                'font' => ['size' => 9, 'color' => ['rgb' => '64748b']],
            ],
            // Heading tabel
            4 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 9.5],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '1F63DB'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
            ],
        ];
    }

    // ── Events (inject header rows & footer) ──────────────────────────────────

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $this->dataCount + 4; // 3 header rows + 1 heading
                $lastCol = 'K';

                // ── Geser semua data 3 baris ke bawah untuk header ─────────
                $sheet->insertNewRowBefore(1, 3);

                // ── Row 1: Judul ────────────────────────────────────────────
                $sheet->setCellValue('A1', 'Laporan Sesi Gerbang Absensi');
                $sheet->mergeCells('A1:K1');
                $sheet->getStyle('A1')->applyFromArray([
                    'font'      => ['bold' => true, 'size' => 14, 'color' => ['rgb' => '1F63DB']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
                ]);

                // ── Row 2: Info filter + cetak ──────────────────────────────
                $filterParts = [];
                if (!empty($this->filters['tanggal_dari']))
                    $filterParts[] = 'Dari: ' . Carbon::parse($this->filters['tanggal_dari'])->isoFormat('D MMM Y');
                if (!empty($this->filters['tanggal_sampai']))
                    $filterParts[] = 'Sampai: ' . Carbon::parse($this->filters['tanggal_sampai'])->isoFormat('D MMM Y');
                if (!empty($this->filters['tipe']))
                    $filterParts[] = 'Tipe: ' . ucfirst($this->filters['tipe']);
                if (!empty($this->filters['status']))
                    $filterParts[] = 'Status: ' . ucfirst($this->filters['status']);
                $filterParts[] = 'Dicetak: ' . now()->isoFormat('D MMMM Y, HH:mm');

                $sheet->setCellValue('A2', implode('   |   ', $filterParts));
                $sheet->mergeCells('A2:K2');
                $sheet->getStyle('A2')->applyFromArray([
                    'font'      => ['size' => 9, 'color' => ['rgb' => '64748b']],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_LEFT],
                ]);

                // ── Row 3: kosong / pemisah ─────────────────────────────────
                $sheet->getRowDimension(3)->setRowHeight(6);

                // ── Heading row (row 4) ─────────────────────────────────────
                $sheet->getStyle('A4:K4')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 9.5],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1F63DB']],
                    'alignment' => [
                        'horizontal' => Alignment::HORIZONTAL_CENTER,
                        'vertical'   => Alignment::VERTICAL_CENTER,
                        'wrapText'   => true,
                    ],
                ]);
                $sheet->getRowDimension(4)->setRowHeight(24);

                // ── Data rows styling ───────────────────────────────────────
                $totalDataRow = $this->dataCount + 4;
                for ($row = 5; $row <= $totalDataRow; $row++) {
                    // Zebra stripes
                    $bgColor = ($row % 2 === 0) ? 'F8FAFC' : 'FFFFFF';
                    $sheet->getStyle("A{$row}:K{$row}")->applyFromArray([
                        'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => $bgColor]],
                        'font' => ['size' => 9.5],
                        'alignment' => ['vertical' => Alignment::VERTICAL_CENTER],
                    ]);
                    $sheet->getRowDimension($row)->setRowHeight(18);

                    // Center: No, Status, Tipe, Dibuka, Ditutup, Durasi, Scan
                    foreach (['A', 'E', 'F', 'G', 'H', 'K'] as $col) {
                        $sheet->getStyle("{$col}{$row}")->getAlignment()
                              ->setHorizontal(Alignment::HORIZONTAL_CENTER);
                    }

                    // Warnai status
                    $statusVal = $sheet->getCell("E{$row}")->getValue();
                    if ($statusVal === 'Aktif') {
                        $sheet->getStyle("E{$row}")->getFont()->getColor()->setRGB('15803d');
                        $sheet->getStyle("E{$row}")->getFont()->setBold(true);
                    } elseif ($statusVal === 'Ditutup') {
                        $sheet->getStyle("E{$row}")->getFont()->getColor()->setRGB('64748b');
                    }
                }

                // ── Border seluruh tabel ────────────────────────────────────
                $sheet->getStyle("A4:K{$totalDataRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color'       => ['rgb' => 'E2E8F0'],
                        ],
                    ],
                ]);

                // ── Summary baris di bawah tabel ────────────────────────────
                $summaryRow = $totalDataRow + 2;
                $sheet->setCellValue("A{$summaryRow}", 'RINGKASAN');
                $sheet->getStyle("A{$summaryRow}")->applyFromArray([
                    'font' => ['bold' => true, 'size' => 9.5, 'color' => ['rgb' => '475569']],
                ]);

                $summaryRow++;
                $sheet->setCellValue("A{$summaryRow}", 'Total Sesi:');
                $sheet->setCellValue("B{$summaryRow}", $this->dataCount);
                $sheet->setCellValue("C{$summaryRow}", '|  Total Scan Valid:');
                $sheet->setCellValue("D{$summaryRow}", $this->data->sum('jumlah_scan'));

                $sheet->getStyle("A{$summaryRow}:D{$summaryRow}")->applyFromArray([
                    'font' => ['size' => 9.5, 'bold' => true],
                    'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'EFF6FF']],
                ]);

                // ── Freeze header ───────────────────────────────────────────
                $sheet->freezePane('A5');

                // ── Auto-filter ─────────────────────────────────────────────
                $sheet->setAutoFilter("A4:K4");

                // ── Print settings ──────────────────────────────────────────
                $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
                $sheet->getPageSetup()->setPaperSize(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4);
                $sheet->getPageSetup()->setFitToWidth(1);
                $sheet->getPageSetup()->setFitToHeight(0);
                $sheet->getHeaderFooter()
                      ->setOddHeader('&L&B Laporan Sesi Gerbang &R&D &T');
                $sheet->getHeaderFooter()
                      ->setOddFooter('&LDicetak oleh sistem absensi &RHalaman &P dari &N');
            },
        ];
    }
}