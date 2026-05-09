<?php

namespace App\Exports;

use App\Models\AbsensiGerbang;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Database\Eloquent\Builder;

class AbsensiGerbangReportExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithTitle,
    ShouldAutoSize,
    WithStyles,
    WithColumnFormatting
{
    protected array $filters;
    protected int $rowNumber = 0;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    // ─── Query ───────────────────────────────────────────────────────────────

    public function query(): Builder
    {
        $query = AbsensiGerbang::query()
            ->with([
                'siswa:id,nis,nama_lengkap,kelas_id',
                'siswa.kelas:id,nama_kelas',
                'sesiGerbang:id,nama,tanggal',
                'inputOleh:id,name',
            ])
            ->orderByDesc('tanggal_scan')
            ->orderByDesc('waktu_scan');

        $this->applyFilters($query);

        return $query;
    }

    // ─── Headings ────────────────────────────────────────────────────────────

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Waktu Scan',
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Tipe',
            'Status',
            'Kode Scan / RFID',
            'Sesi Gerbang',
            'Input Manual',
            'Dicatat Oleh',
            'Keterangan',
        ];
    }

    // ─── Row mapping ─────────────────────────────────────────────────────────

    public function map($row): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $row->tanggal_scan
                ? \Carbon\Carbon::parse($row->tanggal_scan)->format('d/m/Y')
                : '-',
            $row->waktu_scan
                ? \Carbon\Carbon::parse($row->waktu_scan)->format('H:i:s')
                : '-',
            $row->siswa?->nis         ?? '-',
            $row->siswa?->nama_lengkap ?? 'Tidak Dikenal',
            $row->siswa?->kelas?->nama_kelas ?? '-',
            ucfirst($row->tipe   ?? '-'),
            ucfirst($row->status ?? '-'),
            $row->kode_scan ?? '-',
            $row->sesiGerbang?->nama  ?? '-',
            $row->is_manual ? 'Ya' : 'Tidak',
            $row->inputOleh?->name    ?? '-',
            $row->keterangan          ?? '',
        ];
    }

    // ─── Sheet title ─────────────────────────────────────────────────────────

    public function title(): string
    {
        return 'Absensi Gerbang';
    }

    // ─── Column format ───────────────────────────────────────────────────────

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_NUMBER,   // No urut — angka bukan teks
        ];
    }

    // ─── Styles ──────────────────────────────────────────────────────────────

    public function styles(Worksheet $sheet): array
    {
        return [
            // Baris heading (baris 1) — bold, background biru gelap, teks putih
            1 => [
                'font'    => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'    => [
                    'fillType'   => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF1E3A5F'],
                ],
                'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    // ─── Private: apply filters ──────────────────────────────────────────────

    private function applyFilters(Builder $q): void
    {
        $r = $this->filters;

        if (! empty($r['tanggal_dari']))
            $q->whereDate('tanggal_scan', '>=', $r['tanggal_dari']);

        if (! empty($r['tanggal_sampai']))
            $q->whereDate('tanggal_scan', '<=', $r['tanggal_sampai']);

        if (! empty($r['tipe']))
            $q->where('tipe', $r['tipe']);

        if (! empty($r['status']))
            $q->where('status', $r['status']);

        if (! empty($r['sesi_gerbang_id']))
            $q->where('sesi_gerbang_id', $r['sesi_gerbang_id']);

        if (! empty($r['kelas_id'])) {
            $q->whereHas('siswa', fn ($sq) => $sq->where('kelas_id', $r['kelas_id']));
        }

        if (! empty($r['search'])) {
            $s = $r['search'];
            $q->where(function ($q2) use ($s) {
                $q2->where('kode_scan', 'like', "%{$s}%")
                   ->orWhereHas('siswa', fn ($sq) =>
                       $sq->where('nama_lengkap', 'like', "%{$s}%")
                          ->orWhere('nis', 'like', "%{$s}%")
                   );
            });
        }
    }
}