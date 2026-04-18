<?php

namespace App\Exports;
 
use App\Models\RiwayatScanQr;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
 
class RiwayatScanExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(private array $filters = []) {}
 
    public function query()
    {
        $query = RiwayatScanQr::with(['sesiQr.kelas', 'sesiQr.mataPelajaran', 'siswa']);
 
        if (!empty($this->filters['sesi_qr_id']))    $query->where('sesi_qr_id', $this->filters['sesi_qr_id']);
        if (!empty($this->filters['siswa_id']))      $query->where('siswa_id', $this->filters['siswa_id']);
        if (!empty($this->filters['hasil']))         $query->where('hasil', $this->filters['hasil']);
        if (!empty($this->filters['tanggal']))       $query->whereDate('dipindai_pada', $this->filters['tanggal']);
        if (!empty($this->filters['tanggal_dari']))  $query->whereDate('dipindai_pada', '>=', $this->filters['tanggal_dari']);
        if (!empty($this->filters['tanggal_sampai'])) $query->whereDate('dipindai_pada', '<=', $this->filters['tanggal_sampai']);
 
        return $query->latest('dipindai_pada');
    }
 
    public function headings(): array
    {
        return [
            'No', 'Nama Siswa', 'NIS', 'Kelas', 'Mata Pelajaran',
            'Dipindai Pada', 'Hasil', 'Latitude', 'Longitude',
            'IP Address', 'Info Perangkat',
        ];
    }
 
    public function map($row): array
    {
        static $no = 0;
        $no++;
 
        return [
            $no,
            $row->siswa?->nama_lengkap,
            $row->siswa?->nis,
            $row->sesiQr?->kelas?->nama_kelas,
            $row->sesiQr?->mataPelajaran?->nama_mapel ?? '-',
            $row->dipindai_pada?->format('d/m/Y H:i:s'),
            strtoupper(str_replace('_', ' ', $row->hasil)),
            $row->latitude ?? '-',
            $row->longitude ?? '-',
            $row->ip_address ?? '-',
            $row->info_perangkat ?? '-',
        ];
    }
 
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0891B2']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
 
    public function title(): string
    {
        return 'Riwayat Scan QR';
    }
}