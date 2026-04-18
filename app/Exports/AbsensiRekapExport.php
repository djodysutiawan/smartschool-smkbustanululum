<?php

namespace App\Exports;
 
use App\Models\Absensi;
use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
 
class AbsensiRekapExport implements FromCollection, WithHeadings, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(
        private int    $kelasId,
        private string $tanggalDari,
        private string $tanggalSampai
    ) {}
 
    public function collection()
    {
        $absensi = Absensi::with('siswa')
            ->where('kelas_id', $this->kelasId)
            ->whereBetween('tanggal', [$this->tanggalDari, $this->tanggalSampai])
            ->get()
            ->groupBy('siswa_id');
 
        $rows = collect();
        $no   = 1;
 
        foreach ($absensi as $siswaId => $records) {
            $siswa  = $records->first()->siswa;
            $rows->push([
                'No'      => $no++,
                'Nama'    => $siswa?->nama_lengkap,
                'NIS'     => $siswa?->nis,
                'Hadir'   => $records->whereIn('status', ['hadir', 'telat'])->count(),
                'Sakit'   => $records->where('status', 'sakit')->count(),
                'Izin'    => $records->where('status', 'izin')->count(),
                'Alfa'    => $records->where('status', 'alfa')->count(),
                'Total'   => $records->count(),
            ]);
        }
 
        return $rows;
    }
 
    public function headings(): array
    {
        return ['No', 'Nama Siswa', 'NIS', 'Hadir', 'Sakit', 'Izin', 'Alfa', 'Total Pertemuan'];
    }
 
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '059669']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
 
    public function title(): string
    {
        return 'Rekap Absensi';
    }
}
 