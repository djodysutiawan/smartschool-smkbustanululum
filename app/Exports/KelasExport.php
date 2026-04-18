<?php 

namespace App\Exports;
 
use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
 
class KelasExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function __construct(private array $filters = []) {}
 
    public function query()
    {
        $query = Kelas::with(['waliKelas', 'ruang', 'tahunAjaran'])->withCount('siswa');
 
        if (!empty($this->filters['tahun_ajaran_id'])) {
            $query->where('tahun_ajaran_id', $this->filters['tahun_ajaran_id']);
        }
 
        if (!empty($this->filters['tingkat'])) {
            $query->where('tingkat', $this->filters['tingkat']);
        }
 
        return $query->orderBy('tingkat')->orderBy('nama_kelas');
    }
 
    public function headings(): array
    {
        return [
            'ID', 'Kode Kelas', 'Nama Kelas', 'Tingkat', 'Jurusan',
            'Wali Kelas', 'Ruang', 'Tahun Ajaran', 'Kapasitas', 'Jumlah Siswa', 'Status',
        ];
    }
 
    public function map($row): array
    {
        return [
            $row->id,
            $row->kode_kelas,
            $row->nama_kelas,
            $row->tingkat,
            $row->jurusan,
            $row->waliKelas?->nama_lengkap,
            $row->ruang?->kode_ruang,
            $row->tahunAjaran?->label,
            $row->kapasitas_maks,
            $row->siswa_count,
            ucfirst($row->status),
        ];
    }
 
    public function styles(Worksheet $sheet): array
    {
        return [1 => ['font' => ['bold' => true]]];
    }
}