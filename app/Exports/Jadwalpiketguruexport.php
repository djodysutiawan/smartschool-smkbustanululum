<?php
// ============================================================
// File: app/Exports/JadwalPiketGuruExport.php
// ============================================================

namespace App\Exports;

use App\Models\JadwalPiketGuru;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JadwalPiketGuruExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = JadwalPiketGuru::with(['guru', 'tahunAjaran'])
            ->orderByRaw("FIELD(hari, 'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai');

        if (!empty($this->filters['tahun_ajaran_id'])) {
            $query->where('tahun_ajaran_id', $this->filters['tahun_ajaran_id']);
        }
        if (!empty($this->filters['guru_id'])) {
            $query->where('guru_id', $this->filters['guru_id']);
        }
        if (!empty($this->filters['hari'])) {
            $query->where('hari', $this->filters['hari']);
        }
        if (isset($this->filters['is_active']) && $this->filters['is_active'] !== '') {
            $query->where('is_active', $this->filters['is_active']);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Guru Piket',
            'NIP',
            'Tahun Ajaran',
            'Hari',
            'Jam Mulai',
            'Jam Selesai',
            'Status',
            'Catatan',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->guru->nama_lengkap ?? '-',
            $row->guru->nip ?? '-',
            $row->tahunAjaran->tahun ?? '-',
            ucfirst($row->hari),
            \Carbon\Carbon::parse($row->jam_mulai)->format('H:i'),
            \Carbon\Carbon::parse($row->jam_selesai)->format('H:i'),
            $row->is_active ? 'Aktif' : 'Nonaktif',
            $row->catatan ?? '-',
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
            'D' => 18,
            'E' => 12,
            'F' => 12,
            'G' => 12,
            'H' => 12,
            'I' => 35,
        ];
    }
}