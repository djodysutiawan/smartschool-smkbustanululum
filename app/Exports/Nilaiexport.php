<?php

namespace App\Exports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NilaiExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(private array $filters = []) {}

    public function query()
    {
        $query = Nilai::with(['siswa', 'mataPelajaran', 'kelas', 'tahunAjaran']);

        if (!empty($this->filters['tahun_ajaran_id'])) {
            $query->where('tahun_ajaran_id', $this->filters['tahun_ajaran_id']);
        }
        if (!empty($this->filters['kelas_id'])) {
            $query->where('kelas_id', $this->filters['kelas_id']);
        }
        if (!empty($this->filters['mata_pelajaran_id'])) {
            $query->where('mata_pelajaran_id', $this->filters['mata_pelajaran_id']);
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'Mata Pelajaran',
            'Kelas',
            'Tahun Ajaran',
            'Nilai Tugas (20%)',
            'Nilai Harian (30%)',
            'Nilai UTS (20%)',
            'Nilai UAS (30%)',
            'Nilai Akhir',
            'Predikat',
            'Catatan',
        ];
    }

    public function map($nilai): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $nilai->siswa->nama_lengkap ?? '-',
            $nilai->mataPelajaran->nama_mapel ?? '-',
            $nilai->kelas->nama_kelas ?? '-',
            $nilai->tahunAjaran->tahun ?? '-',
            $nilai->nilai_tugas ?? '-',
            $nilai->nilai_harian ?? '-',
            $nilai->nilai_uts ?? '-',
            $nilai->nilai_uas ?? '-',
            $nilai->nilai_akhir ?? '-',
            $nilai->predikat ?? '-',
            $nilai->catatan ?? '-',
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
        return 'Data Nilai';
    }
}