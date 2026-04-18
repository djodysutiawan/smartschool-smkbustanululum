<?php

namespace App\Exports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class NilaiRaporExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(
        private ?int $kelasId,
        private ?int $tahunAjaranId
    ) {}

    public function collection()
    {
        return Nilai::with(['siswa', 'mataPelajaran'])
            ->when($this->kelasId, fn($q) => $q->where('kelas_id', $this->kelasId))
            ->when($this->tahunAjaranId, fn($q) => $q->where('tahun_ajaran_id', $this->tahunAjaranId))
            ->get()
            ->sortBy('siswa.nama_lengkap');
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'Mata Pelajaran',
            'Nilai Tugas',
            'Nilai Harian',
            'Nilai UTS',
            'Nilai UAS',
            'Nilai Akhir',
            'Predikat',
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
            $nilai->nilai_tugas ?? '-',
            $nilai->nilai_harian ?? '-',
            $nilai->nilai_uts ?? '-',
            $nilai->nilai_uas ?? '-',
            $nilai->nilai_akhir ?? '-',
            $nilai->predikat ?? '-',
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
        return 'Rapor Kelas';
    }
}