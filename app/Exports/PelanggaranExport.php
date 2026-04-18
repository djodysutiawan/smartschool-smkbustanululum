<?php

namespace App\Exports;

use App\Models\Pelanggaran;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PelanggaranExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    protected array $filters;
    protected int $no = 0;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Pelanggaran::with(['siswa.kelas', 'kategori', 'dicatatOleh']);

        if (!empty($this->filters['kategori_id'])) {
            $query->where('kategori_pelanggaran_id', $this->filters['kategori_id']);
        }
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (!empty($this->filters['kelas_id'])) {
            $query->whereHas('siswa', fn ($q) => $q->where('kelas_id', $this->filters['kelas_id']));
        }
        if (!empty($this->filters['search'])) {
            $s = $this->filters['search'];
            $query->whereHas('siswa', fn ($q) => $q
                ->where('nama_lengkap', 'like', "%{$s}%")
                ->orWhere('nis', 'like', "%{$s}%"));
        }

        return $query->latest('tanggal');
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'NIS',
            'Nama Siswa',
            'Kelas',
            'Kategori Pelanggaran',
            'Tingkat',
            'Poin',
            'Deskripsi',
            'Tindakan',
            'Status',
            'Dicatat Oleh',
            'Dibuat Pada',
        ];
    }

    public function map($row): array
    {
        $this->no++;

        return [
            $this->no,
            \Carbon\Carbon::parse($row->tanggal)->format('d/m/Y'),
            $row->siswa->nis ?? '-',
            $row->siswa->nama_lengkap ?? '-',
            $row->siswa->kelas->nama_kelas ?? '-',
            $row->kategori->nama ?? '-',
            ucfirst($row->kategori->tingkat ?? '-'),
            $row->poin,
            $row->deskripsi,
            $row->tindakan ?? '-',
            ucfirst($row->status),
            $row->dicatatOleh->name ?? '-',
            $row->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => [
                    'bold'  => true,
                    'color' => ['argb' => 'FFFFFFFF'],
                    'size'  => 11,
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FFDC2626'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color'       => ['argb' => 'FFFECACA'],
                    ],
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Data Pelanggaran';
    }
}