<?php

namespace App\Exports;

use App\Models\Pengumuman;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class PengumumanExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(private array $filters = []) {}

    public function query()
    {
        $query = Pengumuman::with('dibuatOleh')->latest();

        if (!empty($this->filters['target_role'])) {
            $query->where('target_role', $this->filters['target_role']);
        }

        if (!empty($this->filters['status_publikasi'])) {
            if ($this->filters['status_publikasi'] === 'dipublikasikan') {
                $query->whereNotNull('dipublikasikan_pada');
            } else {
                $query->whereNull('dipublikasikan_pada');
            }
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No', 'Judul', 'Target', 'Status',
            'Dipinned', 'Dibuat Oleh', 'Dipublikasikan Pada',
            'Kadaluarsa Pada', 'Dibuat Pada',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        $targetLabel = match($row->target_role) {
            'semua'      => 'Semua',
            'guru'       => 'Guru',
            'siswa'      => 'Siswa',
            'orang_tua'  => 'Orang Tua',
            'guru_piket' => 'Guru Piket',
            default      => ucfirst($row->target_role),
        };

        return [
            $no,
            $row->judul,
            $targetLabel,
            !empty($row->dipublikasikan_pada) ? 'Dipublikasikan' : 'Draft',
            $row->dipinned ? 'Ya' : 'Tidak',
            $row->dibuatOleh?->name ?? '-',
            // Safe: Carbon::parse() handle string maupun Carbon object
            !empty($row->dipublikasikan_pada)
                ? Carbon::parse($row->dipublikasikan_pada)->format('d/m/Y H:i')
                : '-',
            !empty($row->kadaluarsa_pada)
                ? Carbon::parse($row->kadaluarsa_pada)->format('d/m/Y H:i')
                : '-',
            !empty($row->created_at)
                ? Carbon::parse($row->created_at)->format('d/m/Y H:i')
                : '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '0F766E']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function title(): string
    {
        return 'Data Pengumuman';
    }
}