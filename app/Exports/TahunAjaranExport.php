<?php
namespace App\Exports;
 
use App\Models\TahunAjaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
 
class TahunAjaranExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return TahunAjaran::orderByDesc('id')->get();
    }
 
    public function headings(): array
    {
        return ['ID', 'Tahun', 'Semester', 'Tanggal Mulai', 'Tanggal Selesai', 'Status', 'Keterangan'];
    }
 
    public function map($row): array
    {
        return [
            $row->id,
            $row->tahun,
            ucfirst($row->semester),
            $row->tanggal_mulai?->format('d/m/Y'),
            $row->tanggal_selesai?->format('d/m/Y'),
            $row->status === 'aktif' ? 'Aktif' : 'Tidak Aktif',
            $row->keterangan,
        ];
    }
 
    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}