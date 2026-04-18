<?php

namespace App\Exports;

use App\Models\JurnalMengajar;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JurnalMengajarExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(private array $filters = []) {}

    public function query()
    {
        $query = JurnalMengajar::with(['guru', 'kelas', 'mataPelajaran']);

        if (!empty($this->filters['guru_id'])) {
            $query->where('guru_id', $this->filters['guru_id']);
        }
        if (!empty($this->filters['kelas_id'])) {
            $query->where('kelas_id', $this->filters['kelas_id']);
        }
        if (!empty($this->filters['tanggal_dari'])) {
            $query->whereDate('tanggal', '>=', $this->filters['tanggal_dari']);
        }
        if (!empty($this->filters['tanggal_sampai'])) {
            $query->whereDate('tanggal', '<=', $this->filters['tanggal_sampai']);
        }

        return $query->orderByDesc('tanggal');
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Guru',
            'Kelas',
            'Mata Pelajaran',
            'Pertemuan Ke',
            'Materi Ajar',
            'Metode Pembelajaran',
            'Jumlah Hadir',
            'Jumlah Tidak Hadir',
            'Persentase Kehadiran (%)',
            'Catatan Kelas',
        ];
    }

    public function map($jurnal): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $jurnal->tanggal?->format('d/m/Y') ?? '-',
            $jurnal->guru->nama_lengkap ?? '-',
            $jurnal->kelas->nama_kelas ?? '-',
            $jurnal->mataPelajaran->nama_mapel ?? '-',
            $jurnal->pertemuan_ke ?? '-',
            $jurnal->materi_ajar,
            $jurnal->metode_pembelajaran ?? '-',
            $jurnal->jumlah_hadir ?? '-',
            $jurnal->jumlah_tidak_hadir ?? '-',
            $jurnal->persentase_kehadiran !== null ? $jurnal->persentase_kehadiran . '%' : '-',
            $jurnal->catatan_kelas ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']]],
        ];
    }

    public function title(): string
    {
        return 'Jurnal Mengajar';
    }
}