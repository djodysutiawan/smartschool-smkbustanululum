<?php

namespace App\Exports;

use App\Models\RiwayatScanQr;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class RiwayatScanExport implements FromQuery, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle
{
    public function __construct(protected array $filters = []) {}

    // ── Query ─────────────────────────────────────────────────────────────────

    public function query(): Builder
    {
        $query = RiwayatScanQr::with([
            'siswa',
            'sesiQr.kelas',
            'sesiQr.mataPelajaran',
        ]);

        // Filter — nama key harus sama dengan yang dikirim controller
        if (!empty($this->filters['sesi_qr_id'])) {
            $query->where('sesi_qr_id', $this->filters['sesi_qr_id']);
        }
        if (!empty($this->filters['siswa_id'])) {
            $query->where('siswa_id', $this->filters['siswa_id']);
        }
        if (!empty($this->filters['hasil'])) {
            $query->where('hasil', $this->filters['hasil']);
        }
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (!empty($this->filters['tanggal'])) {
            $query->whereDate('dipindai_pada', $this->filters['tanggal']);
        }
        if (!empty($this->filters['tanggal_dari'])) {
            $query->whereDate('dipindai_pada', '>=', $this->filters['tanggal_dari']);
        }
        if (!empty($this->filters['tanggal_sampai'])) {
            $query->whereDate('dipindai_pada', '<=', $this->filters['tanggal_sampai']);
        }

        return $query->latest('di_scan_pada');
    }

    // ── Header kolom ─────────────────────────────────────────────────────────

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'NIS',
            'Kelas',
            'Mata Pelajaran',
            'Hasil Scan',
            'Status Teknis',
            'Keterangan',
            'Dipindai Pada',
            'IP Address',
            'Jarak (meter)',
            'Latitude',
            'Longitude',
        ];
    }

    public function map($row): array
    {
        static $i = 0;
        $i++;

        return [
            $i,
            $row->siswa->nama_lengkap ?? '-',
            $row->siswa->nis ?? '-',
            $row->sesiQr->kelas->nama_kelas ?? '-',
            $row->sesiQr->mataPelajaran->nama_mapel ?? '-',
            $row->label_hasil,               // accessor kolom hasil
            $row->label_status,              // accessor kolom status
            $row->keterangan ?? '-',
            $row->di_scan_pada?->format('d/m/Y H:i:s') ?? '-',   // kolom di_scan_pada
            $row->ip_address ?? '-',
            $row->jarak_meter !== null ? number_format($row->jarak_meter, 2) : '-',
            $row->latitude ?? '-',
            $row->longitude ?? '-',
        ];
    }

    // ── Style header ─────────────────────────────────────────────────────────

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF1A1A2E']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    // ── Judul sheet ───────────────────────────────────────────────────────────

    public function title(): string
    {
        return 'Riwayat Scan QR';
    }
}