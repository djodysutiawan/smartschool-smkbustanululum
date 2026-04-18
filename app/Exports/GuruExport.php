<?php

namespace App\Exports;

use App\Models\Guru;
use Illuminate\Contracts\View\View;
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

class GuruExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle, WithEvents
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Guru::with('pengguna')
            ->withCount('jadwalPelajaran');

        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (!empty($this->filters['status_kepegawaian'])) {
            $query->where('status_kepegawaian', $this->filters['status_kepegawaian']);
        }
        if (!empty($this->filters['search'])) {
            $s = $this->filters['search'];
            $query->where(fn($q) => $q->where('nama_lengkap', 'like', "%{$s}%")
                                      ->orWhere('nip', 'like', "%{$s}%")
                                      ->orWhere('email', 'like', "%{$s}%"));
        }

        return $query->orderBy('nama_lengkap')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'NIP',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'No. HP',
            'Email',
            'Alamat',
            'Pendidikan Terakhir',
            'Jurusan',
            'Universitas',
            'Tahun Lulus',
            'Status Kepegawaian',
            'Tanggal Masuk',
            'Guru Piket',
            'Status',
            'Jumlah Jadwal',
        ];
    }

    public function map($guru): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $guru->nip ?? '-',
            $guru->nama_lengkap,
            $guru->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
            $guru->tempat_lahir ?? '-',
            $guru->tanggal_lahir ? $guru->tanggal_lahir->format('d/m/Y') : '-',
            $guru->no_hp ?? '-',
            $guru->email ?? '-',
            $guru->alamat ?? '-',
            strtoupper($guru->pendidikan_terakhir ?? '-'),
            $guru->jurusan_pendidikan ?? '-',
            $guru->universitas ?? '-',
            $guru->tahun_lulus ?? '-',
            strtoupper($guru->status_kepegawaian),
            $guru->tanggal_masuk ? $guru->tanggal_masuk->format('d/m/Y') : '-',
            $guru->adalah_guru_piket ? 'Ya' : 'Tidak',
            ucfirst(str_replace('_', ' ', $guru->status)),
            $guru->jadwal_pelajaran_count,
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
        return 'Data Guru';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = $sheet->getHighestRow();
                $lastCol = $sheet->getHighestColumn();

                // Border untuk semua data
                $sheet->getStyle("A1:{$lastCol}{$lastRow}")->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => 'FFD1D5DB'],
                        ],
                    ],
                ]);

                // Alternating row color
                for ($row = 2; $row <= $lastRow; $row++) {
                    if ($row % 2 === 0) {
                        $sheet->getStyle("A{$row}:{$lastCol}{$row}")->applyFromArray([
                            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFF8FAFC']],
                        ]);
                    }
                }

                // Header row height
                $sheet->getRowDimension(1)->setRowHeight(22);

                // Freeze header
                $sheet->freezePane('A2');
            },
        ];
    }
}