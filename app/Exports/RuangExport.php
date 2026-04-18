<?php

namespace App\Exports;
 
use App\Models\Ruang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
 
class RuangExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return Ruang::with('gedung')->orderBy('gedung_id')->orderBy('lantai')->orderBy('kode_ruang')->get();
    }
 
    public function headings(): array
    {
        return [
            'ID', 'Kode Gedung', 'Kode Ruang', 'Nama Ruang', 'Lantai',
            'Jenis Ruang', 'Kapasitas', 'Proyektor', 'AC', 'WiFi', 'Komputer',
            'Fasilitas Lain', 'Status', 'Keterangan',
        ];
    }
 
    public function map($row): array
    {
        return [
            $row->id,
            $row->gedung?->kode_gedung,
            $row->kode_ruang,
            $row->nama_ruang,
            $row->lantai,
            str_replace('_', ' ', ucfirst($row->jenis_ruang)),
            $row->kapasitas,
            $row->ada_proyektor ? 'Ya' : 'Tidak',
            $row->ada_ac ? 'Ya' : 'Tidak',
            $row->ada_wifi ? 'Ya' : 'Tidak',
            $row->ada_komputer ? 'Ya' : 'Tidak',
            $row->fasilitas_lain,
            ucfirst(str_replace('_', ' ', $row->status)),
            $row->keterangan,
        ];
    }
 
    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}