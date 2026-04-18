<?php

namespace App\Exports;

use App\Models\Absensi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AbsensiExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected array $filters;
    protected int $rowNumber = 0;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Absensi::with(['siswa.kelas', 'dicatatOleh'])->orderByDesc('tanggal');

        if (!empty($this->filters['tanggal_dari'])) {
            $query->whereDate('tanggal', '>=', $this->filters['tanggal_dari']);
        }
        if (!empty($this->filters['tanggal_sampai'])) {
            $query->whereDate('tanggal', '<=', $this->filters['tanggal_sampai']);
        }
        if (!empty($this->filters['kelas_id'])) {
            $query->where('kelas_id', $this->filters['kelas_id']);
        }
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (!empty($this->filters['metode'])) {
            $query->where('metode', $this->filters['metode']);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Status',
            'Metode',
            'Jam Masuk',
            'Jam Keluar',
            'Dicatat Oleh',
            'Keterangan',
        ];
    }

    public function map($row): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y'),
            $row->siswa?->nis ?? '-',
            $row->siswa?->nama_lengkap ?? '-',
            $row->siswa?->kelas?->nama_kelas ?? '-',
            strtoupper($row->status),
            $row->metode ?? '-',
            $row->jam_masuk ?? '-',
            $row->jam_keluar ?? '-',
            $row->dicatatOleh?->name ?? '-',
            $row->keterangan ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF4472C4']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function title(): string
    {
        return 'Laporan Absensi';
    }
}