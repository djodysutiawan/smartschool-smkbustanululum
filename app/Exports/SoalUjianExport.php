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
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class SoalUjianExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    public function __construct(protected Ujian $ujian) {}

    /*
    |--------------------------------------------------------------------------
    | Data
    |--------------------------------------------------------------------------
    */
    public function collection()
    {
        return $this->ujian
            ->soal()
            ->with('pilihan')
            ->orderBy('nomor_soal')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Headings
    |--------------------------------------------------------------------------
    */
    public function headings(): array
    {
        return [
            'No',
            'Jenis Soal',
            'Pertanyaan',
            'Bobot',
            'Pilihan A',
            'Pilihan B',
            'Pilihan C',
            'Pilihan D',
            'Pilihan E',
            'Jawaban Benar',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Row mapping
    |--------------------------------------------------------------------------
    */
    public function map($soal): array
    {
        // Buat map kode => teks dari pilihan
        $pilihanMap = $soal->pilihan->pluck('teks_pilihan', 'kode_pilihan');

        // Ambil kode pilihan yang benar
        $jawabanBenar = $soal->pilihan
            ->where('adalah_benar', true)
            ->pluck('kode_pilihan')
            ->implode(', ');

        return [
            $soal->nomor_soal,
            match ($soal->jenis_soal) {
                'pilihan_ganda' => 'Pilihan Ganda',
                'essay'         => 'Essay',
                'benar_salah'   => 'Benar / Salah',
                default         => $soal->jenis_soal,
            },
            strip_tags($soal->pertanyaan),
            $soal->bobot,
            $pilihanMap['A'] ?? '',
            $pilihanMap['B'] ?? '',
            $pilihanMap['C'] ?? '',
            $pilihanMap['D'] ?? '',
            $pilihanMap['E'] ?? '',
            $jawabanBenar,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Sheet title
    |--------------------------------------------------------------------------
    */
    public function title(): string
    {
        return 'Soal Ujian';
    }

    /*
    |--------------------------------------------------------------------------
    | Styles
    |--------------------------------------------------------------------------
    */
    public function styles(Worksheet $sheet): array
    {
        return [
            // Baris heading (baris 1) — bold + background biru
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF2563EB'],
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
}