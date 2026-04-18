<?php

namespace App\Exports;
 
use App\Models\KetersediaanGuru;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
 
class KetersediaanGuruExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function __construct(private ?int $guruId = null) {}
 
    public function query()
    {
        $query = KetersediaanGuru::with('guru');
 
        if ($this->guruId) {
            $query->where('guru_id', $this->guruId);
        }
 
        return $query
            ->orderBy('guru_id')
            ->orderByRaw("FIELD(hari,'senin','selasa','rabu','kamis','jumat','sabtu')")
            ->orderBy('jam_mulai');
    }
 
    public function headings(): array
    {
        return ['ID', 'Nama Guru', 'Hari', 'Jam Mulai', 'Jam Selesai', 'Tersedia'];
    }
 
    public function map($row): array
    {
        return [
            $row->id,
            $row->guru?->nama_lengkap,
            ucfirst($row->hari),
            $row->jam_mulai,
            $row->jam_selesai,
            $row->tersedia ? 'Ya' : 'Tidak',
        ];
    }
 
    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}