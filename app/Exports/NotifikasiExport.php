<?php

namespace App\Exports;

use App\Models\Notifikasi;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class NotifikasiExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    public function __construct(private array $filters = []) {}

    public function query()
    {
        $query = Notifikasi::with('pengguna')->latest();

        if (!empty($this->filters['pengguna_id'])) {
            $query->where('pengguna_id', $this->filters['pengguna_id']);
        }

        if (!empty($this->filters['jenis'])) {
            $query->where('jenis', $this->filters['jenis']);
        }

        if (isset($this->filters['sudah_dibaca']) && $this->filters['sudah_dibaca'] !== '') {
            $query->where('sudah_dibaca', $this->filters['sudah_dibaca'] === 'ya');
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No', 'Penerima', 'Judul', 'Pesan',
            'Jenis', 'Sudah Dibaca', 'Dibaca Pada', 'URL Tujuan', 'Dikirim Pada',
        ];
    }

    public function map($row): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $row->pengguna?->name ?? '-',
            $row->judul,
            $row->pesan,
            ucfirst($row->jenis),
            $row->sudah_dibaca ? 'Ya' : 'Belum',
            $row->dibaca_pada?->format('d/m/Y H:i') ?? '-',
            $row->url_tujuan ?? '-',
            $row->created_at?->format('d/m/Y H:i'),
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '1D4ED8']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function title(): string
    {
        return 'Data Notifikasi';
    }
}