<?php

namespace App\Exports;

use App\Models\PengumpulanTugas;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PengumpulanTugasExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, WithColumnWidths
{
    protected array $filters;
    protected int $rowNumber = 0;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = PengumpulanTugas::with(['tugas.mataPelajaran', 'siswa.kelas']);

        if (!empty($this->filters['tugas_id'])) {
            $query->where('tugas_id', $this->filters['tugas_id']);
        }

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (!empty($this->filters['search'])) {
            $keyword = $this->filters['search'];
            $query->whereHas('siswa', fn ($q) =>
                $q->where('nama_lengkap', 'like', "%{$keyword}%")
            );
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'Kelas',
            'NIS',
            'Judul Tugas',
            'Mata Pelajaran',
            'Status',
            'Nilai',
            'Umpan Balik',
            'Dikumpulkan Pada',
            'Dinilai Pada',
        ];
    }

    public function map($row): array
    {
        $this->rowNumber++;

        $statusLabel = [
            'belum_dikumpulkan' => 'Belum Dikumpulkan',
            'dikumpulkan'       => 'Dikumpulkan',
            'terlambat'         => 'Terlambat',
            'sudah_dinilai'     => 'Sudah Dinilai',
        ];

        return [
            $this->rowNumber,
            $row->siswa->nama_lengkap ?? '-',
            $row->siswa->kelas->nama_kelas ?? '-',
            $row->siswa->nis ?? '-',
            $row->tugas->judul ?? '-',
            $row->tugas->mataPelajaran->nama_mapel ?? '-',
            $statusLabel[$row->status] ?? $row->status,
            $row->nilai ?? '-',
            $row->umpan_balik ?? '-',
            $row->dikumpulkan_pada
                ? $row->dikumpulkan_pada->format('d/m/Y H:i')
                : ($row->created_at ? $row->created_at->format('d/m/Y H:i') : '-'),
            $row->dinilai_pada ? $row->dinilai_pada->format('d/m/Y H:i') : '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1F63DB']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 28,
            'C' => 15,
            'D' => 14,
            'E' => 35,
            'F' => 22,
            'G' => 20,
            'H' => 8,
            'I' => 40,
            'J' => 20,
            'K' => 20,
        ];
    }

    public function title(): string
    {
        return 'Pengumpulan Tugas';
    }
}