<?php

namespace App\Exports;

use App\Models\Ujian;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UjianExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(private array $filters = []) {}

    public function query()
    {
        $query = Ujian::with(['guru', 'mataPelajaran', 'kelas', 'tahunAjaran']);

        if (!empty($this->filters['tahun_ajaran_id'])) {
            $query->where('tahun_ajaran_id', $this->filters['tahun_ajaran_id']);
        }
        if (!empty($this->filters['kelas_id'])) {
            $query->where('kelas_id', $this->filters['kelas_id']);
        }
        if (!empty($this->filters['guru_id'])) {
            $query->where('guru_id', $this->filters['guru_id']);
        }

        return $query->orderByDesc('tanggal');
    }

    public function headings(): array
    {
        return [
            'No',
            'Judul',
            'Jenis',
            'Guru',
            'Mata Pelajaran',
            'Kelas',
            'Tahun Ajaran',
            'Tanggal',
            'Jam Mulai',
            'Durasi (Menit)',
            'Nilai KKM',
            'Total Soal',
            'Acak Soal',
            'Status',
        ];
    }

    public function map($ujian): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $ujian->judul,
            strtoupper(str_replace('_', ' ', $ujian->jenis)),
            $ujian->guru->nama_lengkap ?? '-',
            $ujian->mataPelajaran->nama_mapel ?? '-',
            $ujian->kelas->nama_kelas ?? '-',
            $ujian->tahunAjaran->tahun ?? '-',
            $ujian->tanggal?->format('d/m/Y') ?? '-',
            $ujian->jam_mulai ?? '-',
            $ujian->durasi_menit,
            $ujian->nilai_kkm,
            $ujian->total_soal,
            $ujian->acak_soal ? 'Ya' : 'Tidak',
            $ujian->is_active ? 'Aktif' : 'Nonaktif',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true], 'fill' => ['fillType' => 'solid', 'startColor' => ['rgb' => '4472C4']], 'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']]],
        ];
    }

    public function title(): string
    {
        return 'Data Ujian';
    }
}