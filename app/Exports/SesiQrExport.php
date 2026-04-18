<?php

namespace App\Exports;
 
use App\Models\SesiQr;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
 
class SesiQrExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(private array $filters = []) {}
 
    public function query()
    {
        $query = SesiQr::with(['kelas', 'mataPelajaran', 'dibuatOleh']);
 
        if (!empty($this->filters['kelas_id']))  $query->where('kelas_id', $this->filters['kelas_id']);
        if (!empty($this->filters['tanggal']))   $query->whereDate('tanggal', $this->filters['tanggal']);
        if (isset($this->filters['is_active']))  $query->where('is_active', (bool) $this->filters['is_active']);
 
        return $query->latest();
    }
 
    public function headings(): array
    {
        return [
            'No', 'Kelas', 'Mata Pelajaran', 'Tanggal',
            'Berlaku Mulai', 'Kadaluarsa', 'Radius (m)',
            'Kode QR', 'Status', 'Dibuat Oleh', 'Dibuat Pada',
        ];
    }
 
    public function map($row): array
    {
        static $no = 0;
        $no++;
 
        return [
            $no,
            $row->kelas?->nama_kelas,
            $row->mataPelajaran?->nama_mapel ?? '-',
            $row->tanggal?->format('d/m/Y'),
            $row->berlaku_mulai?->format('d/m/Y H:i'),
            $row->kadaluarsa_pada?->format('d/m/Y H:i'),
            $row->radius_meter ?? '-',
            $row->kode_qr,
            $row->is_active ? 'Aktif' : 'Nonaktif',
            $row->dibuatOleh?->name ?? '-',
            $row->created_at?->format('d/m/Y H:i'),
        ];
    }
 
    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '7C3AED']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }
 
    public function title(): string
    {
        return 'Data Sesi QR';
    }
}