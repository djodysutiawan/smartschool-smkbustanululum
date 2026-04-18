<?php

namespace App\Exports;

use App\Models\OrangTua;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class OrangTuaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle, WithEvents
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = OrangTua::with(['pengguna', 'siswa.kelas'])->withCount('siswa');

        if (!empty($this->filters['search'])) {
            $s = $this->filters['search'];
            $query->where(fn($q) => $q->where('nama_lengkap', 'like', "%{$s}%")
                                      ->orWhere('no_hp', 'like', "%{$s}%")
                                      ->orWhere('email', 'like', "%{$s}%"));
        }

        return $query->orderBy('nama_lengkap')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Lengkap',
            'No. HP',
            'Email',
            'Pekerjaan',
            'Alamat',
            'Jumlah Anak Terdaftar',
            'Nama Anak (Kelas)',
            'Hubungan',
            'Akun Sistem',
        ];
    }

    public function map($ot): array
    {
        static $no = 0;
        $no++;

        $anakList = $ot->siswa->map(function ($s) {
            $kelas = $s->kelas->nama_kelas ?? '-';
            $hub   = $s->pivot->hubungan ?? 'orang_tua';
            return "{$s->nama_lengkap} ({$kelas})";
        })->implode(', ');

        $hubunganList = $ot->siswa->map(function ($s) {
            return ucfirst(str_replace('_', ' ', $s->pivot->hubungan ?? 'orang_tua'));
        })->implode(', ');

        return [
            $no,
            $ot->nama_lengkap,
            $ot->no_hp,
            $ot->email ?? '-',
            $ot->pekerjaan ?? '-',
            $ot->alamat ?? '-',
            $ot->siswa_count,
            $anakList ?: '-',
            $hubunganList ?: '-',
            $ot->pengguna ? 'Terhubung' : 'Tidak Ada',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font' => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF'], 'size' => 11],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1F63DB']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            ],
        ];
    }

    public function title(): string
    {
        return 'Data Orang Tua';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                $lastCol = $sheet->getHighestColumn();

                $sheet->getStyle("A1:{$lastCol}{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FFD1D5DB'],
                        ],
                    ],
                ]);

                for ($row = 2; $row <= $lastRow; $row++) {
                    if ($row % 2 === 0) {
                        $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF8FAFC']],
                        ]);
                    }
                }

                $sheet->getRowDimension(1)->setRowHeight(22);
                $sheet->freezePane('A2');
            },
        ];
    }
}