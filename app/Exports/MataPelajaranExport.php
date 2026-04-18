<?php

namespace App\Exports;
 
use App\Models\MataPelajaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
 
class MataPelajaranExport implements FromCollection, WithHeadings, WithMapping, WithStyles
{
    public function collection()
    {
        return MataPelajaran::withCount('jadwalPelajaran')->orderBy('nama_mapel')->get();
    }
 
    public function headings(): array
    {
        return [
            'ID', 'Kode Mapel', 'Nama Mata Pelajaran', 'Kelompok',
            'Jam/Minggu', 'Durasi/Sesi (mnt)', 'Perlu Lab', 'Total Jadwal', 'Status',
        ];
    }
 
    public function map($row): array
    {
        return [
            $row->id,
            $row->kode_mapel,
            $row->nama_mapel,
            ucfirst(str_replace('_', ' ', $row->kelompok ?? '-')),
            $row->jam_per_minggu,
            $row->durasi_per_sesi,
            $row->perlu_lab ? 'Ya' : 'Tidak',
            $row->jadwal_pelajaran_count,
            $row->is_active ? 'Aktif' : 'Tidak Aktif',
        ];
    }
 
    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}