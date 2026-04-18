<?php

namespace App\Exports;
 
use App\Models\Gedung;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
 
class GedungExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Gedung::withCount('ruang')->orderBy('kode_gedung')->get();
    }
 
    public function headings(): array
    {
        return ['ID', 'Kode Gedung', 'Nama Gedung', 'Jumlah Lantai', 'Jumlah Ruang', 'Status', 'Deskripsi'];
    }
 
    public function map($row): array
    {
        return [
            $row->id,
            $row->kode_gedung,
            $row->nama_gedung,
            $row->jumlah_lantai,
            $row->ruang_count,
            $row->is_active ? 'Aktif' : 'Tidak Aktif',
            $row->deskripsi,
        ];
    }
 
    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}