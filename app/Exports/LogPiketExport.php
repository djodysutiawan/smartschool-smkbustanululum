<?php
// ============================================================
// File: app/Exports/LogPiketExport.php
// ============================================================

namespace App\Exports;

use App\Models\LogPiket;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LogPiketExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = LogPiket::with(['guru', 'pengguna'])
            ->orderByDesc('tanggal')
            ->orderByDesc('masuk_pada');

        if (!empty($this->filters['guru_id'])) {
            $query->where('guru_id', $this->filters['guru_id']);
        }
        if (!empty($this->filters['shift'])) {
            $query->where('shift', $this->filters['shift']);
        }
        if (!empty($this->filters['tanggal_dari'])) {
            $query->whereDate('tanggal', '>=', $this->filters['tanggal_dari']);
        }
        if (!empty($this->filters['tanggal_sampai'])) {
            $query->whereDate('tanggal', '<=', $this->filters['tanggal_sampai']);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Guru Piket',
            'NIP',
            'Tanggal',
            'Shift',
            'Jam Masuk',
            'Jam Keluar',
            'Durasi (menit)',
            'Status',
            'Catatan',
            'Dicatat Oleh',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        $durasi = null;
        if ($row->masuk_pada && $row->keluar_pada) {
            $durasi = \Carbon\Carbon::parse($row->masuk_pada)->diffInMinutes(\Carbon\Carbon::parse($row->keluar_pada));
        }

        $status = 'Belum Masuk';
        if ($row->keluar_pada) {
            $status = 'Selesai';
        } elseif ($row->masuk_pada) {
            $status = 'Bertugas';
        }

        return [
            $no,
            $row->guru->nama_lengkap ?? '-',
            $row->guru->nip ?? '-',
            \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y'),
            ucfirst($row->shift ?? '-'),
            $row->masuk_pada ? \Carbon\Carbon::parse($row->masuk_pada)->format('H:i') : '-',
            $row->keluar_pada ? \Carbon\Carbon::parse($row->keluar_pada)->format('H:i') : '-',
            $durasi ?? '-',
            $status,
            $row->catatan ?? '-',
            $row->pengguna->name ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF1F63DB']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 6,
            'B' => 28,
            'C' => 20,
            'D' => 14,
            'E' => 10,
            'F' => 12,
            'G' => 12,
            'H' => 16,
            'I' => 14,
            'J' => 35,
            'K' => 20,
        ];
    }
}