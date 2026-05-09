<?php

namespace App\Exports;

use App\Models\Siswa;
use App\Models\SesiGerbang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

/**
 * Export rekap kehadiran per siswa untuk periode tertentu.
 */
class RekapAbsensiGerbangExport implements
    FromCollection,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    private int $totalHariSekolah;

    public function __construct(private array $filters = []) {}

    public function collection()
    {
        $dari    = $this->filters['dari']    ?? now()->startOfMonth()->toDateString();
        $sampai  = $this->filters['sampai']  ?? now()->toDateString();
        $kelasId = $this->filters['kelas_id'] ?? null;
        $tipe    = $this->filters['tipe']    ?? 'masuk';

        $this->totalHariSekolah = SesiGerbang::where('tipe', $tipe)
            ->whereBetween('tanggal', [$dari, $sampai])
            ->where('status', 'ditutup')
            ->distinct('tanggal')
            ->count('tanggal');

        $query = Siswa::aktif()
            ->with('kelas')
            ->withCount([
                'absensiGerbang as hari_hadir' => fn ($q) =>
                    $q->where('tipe', $tipe)
                      ->whereBetween('tanggal_scan', [$dari, $sampai])
                      ->whereIn('status', ['normal', 'manual', 'koreksi'])
                      ->distinct('tanggal_scan'),
            ]);

        if ($kelasId) $query->where('kelas_id', $kelasId);

        return $query->orderBy('nama_lengkap')->get()->map(function ($siswa) {
            $siswa->hari_tidak_hadir = max(0, $this->totalHariSekolah - $siswa->hari_hadir);
            $siswa->persentase       = $this->totalHariSekolah > 0
                ? round(($siswa->hari_hadir / $this->totalHariSekolah) * 100, 1)
                : 0;
            return $siswa;
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Hari Sekolah',
            'Hari Hadir',
            'Hari Tidak Hadir',
            'Persentase (%)',
        ];
    }

    private int $row = 1;

    public function map($siswa): array
    {
        return [
            $this->row++,
            $siswa->nis,
            $siswa->nama_lengkap,
            $siswa->kelas?->nama_kelas ?? '-',
            $this->totalHariSekolah,
            $siswa->hari_hadir,
            $siswa->hari_tidak_hadir,
            $siswa->persentase . '%',
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
        return 'Rekap Kehadiran Gerbang';
    }
}