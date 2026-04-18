<?php

namespace App\Exports;

use App\Models\Tugas;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TugasExport implements FromQuery, WithHeadings, WithMapping, WithStyles
{
    public function __construct(private array $filters = []) {}

    public function query()
    {
        $query = Tugas::with(['guru', 'mataPelajaran', 'kelas', 'tahunAjaran']);

        if (!empty($this->filters['guru_id'])) {
            $query->where('guru_id', $this->filters['guru_id']);
        }
        if (!empty($this->filters['kelas_id'])) {
            $query->where('kelas_id', $this->filters['kelas_id']);
        }
        if (!empty($this->filters['mata_pelajaran_id'])) {
            $query->where('mata_pelajaran_id', $this->filters['mata_pelajaran_id']);
        }

        return $query->latest();
    }

    public function headings(): array
    {
        return [
            'No', 'Judul', 'Guru', 'Mata Pelajaran', 'Kelas',
            'Tahun Ajaran', 'Jenis Pengumpulan', 'Batas Waktu',
            'Nilai Maksimal', 'Status', 'Dibuat',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->judul,
            $row->guru->nama_lengkap    ?? '-',
            $row->mataPelajaran->nama_mapel ?? '-',
            $row->kelas->nama_kelas     ?? '-',
            $row->tahunAjaran->tahun    ?? '-',
            ucfirst($row->jenis_pengumpulan),
            $row->batas_waktu ? \Carbon\Carbon::parse($row->batas_waktu)->format('d/m/Y H:i') : '-',
            $row->nilai_maksimal ?? '-',
            $row->dipublikasikan ? 'Dipublikasikan' : 'Draft',
            $row->created_at->format('d/m/Y'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}