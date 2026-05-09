<?php

namespace App\Exports;

use App\Models\AbsensiGerbang;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Export log scan absensi gerbang (per tanggal).
 */
class AbsensiGerbangExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    public function __construct(private array $filters = []) {}

    public function query()
    {
        $tanggal = $this->filters['tanggal'] ?? now()->toDateString();

        $query = AbsensiGerbang::with(['siswa.kelas', 'sesiGerbang', 'inputOleh:id,name'])
            ->where('tanggal_scan', $tanggal)
            ->whereIn('status', ['normal', 'manual', 'koreksi']);

        if (! empty($this->filters['tipe']))     $query->where('tipe', $this->filters['tipe']);
        if (! empty($this->filters['kelas_id'])) {
            $query->whereHas('siswa', fn ($q) => $q->where('kelas_id', $this->filters['kelas_id']));
        }

        return $query->orderBy('tipe')->orderBy('waktu_scan');
    }

    public function headings(): array
    {
        return [
            'No',
            'Waktu Scan',
            'Tipe',
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Status Scan',
            'Input Oleh',
            'Catatan',
        ];
    }

    private int $row = 1;

    public function map($scan): array
    {
        return [
            $this->row++,
            $scan->waktu_scan->format('H:i:s'),
            $scan->label_tipe,
            $scan->siswa?->nis ?? '-',
            $scan->siswa?->nama_lengkap ?? 'Tidak Dikenal',
            $scan->siswa?->kelas?->nama_kelas ?? '-',
            $scan->label_status,
            $scan->inputOleh?->name ?? 'Alat Scanner',
            $scan->catatan ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Log Scan ' . ($this->filters['tanggal'] ?? now()->toDateString());
    }
}