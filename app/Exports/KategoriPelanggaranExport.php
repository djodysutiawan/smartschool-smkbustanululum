<?php

namespace App\Exports;

use App\Models\KategoriPelanggaran;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class KategoriPelanggaranExport implements
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
        $query = KategoriPelanggaran::withCount('pelanggaran');

        if (!empty($this->filters['search'])) {
            $query->where('nama', 'like', '%' . $this->filters['search'] . '%');
        }
        if (!empty($this->filters['tingkat'])) {
            $query->where('tingkat', $this->filters['tingkat']);
        }
        if (isset($this->filters['is_active']) && $this->filters['is_active'] !== '') {
            $query->where('is_active', filter_var($this->filters['is_active'], FILTER_VALIDATE_BOOLEAN));
        }

        return $query->orderBy('tingkat')->orderBy('nama');
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Kategori',
            'Deskripsi',
            'Tingkat',
            'Poin Default',
            'Batas Poin',
            'Warna',
            'Status',
            'Total Kasus',
            'Dibuat Pada',
        ];
    }

    public function map($row): array
    {
        $this->no++;

        return [
            $this->no,
            $row->nama,
            $row->deskripsi ?? '-',
            ucfirst($row->tingkat),
            $row->poin_default,
            $row->batas_poin ?? '-',
            $row->warna ?? '-',
            $row->is_active ? 'Aktif' : 'Nonaktif',
            $row->pelanggaran_count,
            $row->created_at->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            // Header row styling
            1 => [
                'font' => [
                    'bold'  => true,
                    'color' => ['argb' => 'FFFFFFFF'],
                    'size'  => 11,
                ],
                'fill' => [
                    'fillType'   => Fill::FILL_SOLID,
                    'startColor' => ['argb' => 'FF1F63DB'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color'       => ['argb' => 'FFBFDBFE'],
                    ],
                ],
            ],
        ];
    }

    public function title(): string
    {
        return 'Kategori Pelanggaran';
    }
}