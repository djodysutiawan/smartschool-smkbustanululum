<?php

namespace App\Exports;
 
use App\Models\JadwalPelajaran;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
 
class JadwalPelajaranExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function __construct(private array $filters = []) {}
 
    public function query()
    {
        $query = JadwalPelajaran::with(['guru', 'mataPelajaran', 'kelas', 'ruang', 'tahunAjaran']);
 
        if (!empty($this->filters['tahun_ajaran_id'])) {
            $query->where('tahun_ajaran_id', $this->filters['tahun_ajaran_id']);
        }
 
        if (!empty($this->filters['kelas_id'])) {
            $query->where('kelas_id', $this->filters['kelas_id']);
        }
 
        if (!empty($this->filters['guru_id'])) {
            $query->where('guru_id', $this->filters['guru_id']);
        }
 
        return $query->orderBy('hari')->orderBy('jam_mulai');
    }
 
    public function headings(): array
    {
        return [
            'ID', 'Tahun Ajaran', 'Hari', 'Jam Mulai', 'Jam Selesai',
            'Kelas', 'Mata Pelajaran', 'Guru', 'Ruang', 'Sumber', 'Status',
        ];
    }
 
    public function map($row): array
    {
        return [
            $row->id,
            $row->tahunAjaran?->label,
            ucfirst($row->hari),
            $row->jam_mulai,
            $row->jam_selesai,
            $row->kelas?->nama_kelas,
            $row->mataPelajaran?->nama_mapel,
            $row->guru?->nama_lengkap,
            $row->ruang?->kode_ruang,
            ucfirst($row->sumber_jadwal),
            $row->is_active ? 'Aktif' : 'Tidak Aktif',
        ];
    }
 
    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}