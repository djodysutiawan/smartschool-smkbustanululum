<?php

namespace App\Exports;

use App\Models\Ujian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SesiUjianExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(private Ujian $ujian) {}

    public function collection()
    {
        return $this->ujian->sesi()
            ->with('siswa')
            ->whereIn('status', ['selesai', 'habis_waktu'])
            ->orderByDesc('nilai_akhir')
            ->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Siswa',
            'Status',
            'Nilai Akhir',
            'Total Benar',
            'Total Salah',
            'Total Kosong',
            'Lulus',
            'Mulai Pada',
            'Selesai Pada',
        ];
    }

    public function map($sesi): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $sesi->siswa->nama_lengkap ?? '-',
            $sesi->status === 'habis_waktu' ? 'Habis Waktu' : 'Selesai',
            $sesi->nilai_akhir,
            $sesi->total_benar,
            $sesi->total_salah,
            $sesi->total_kosong,
            $sesi->lulus ? 'Lulus' : 'Tidak Lulus',
            $sesi->mulai_pada?->format('d/m/Y H:i') ?? '-',
            $sesi->selesai_pada?->format('d/m/Y H:i') ?? '-',
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
        return 'Hasil Ujian';
    }
}