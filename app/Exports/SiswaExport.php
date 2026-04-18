<?php

namespace App\Exports;

use App\Models\Siswa;
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

class SiswaExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, WithTitle, WithEvents
{
    protected array $filters;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Siswa::with(['kelas', 'tahunAjaran']);

        if (!empty($this->filters['kelas_id'])) {
            $query->where('kelas_id', $this->filters['kelas_id']);
        }
        if (!empty($this->filters['tahun_ajaran_id'])) {
            $query->where('tahun_ajaran_id', $this->filters['tahun_ajaran_id']);
        }
        if (!empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }
        if (!empty($this->filters['jenis_kelamin'])) {
            $query->where('jenis_kelamin', $this->filters['jenis_kelamin']);
        }
        if (!empty($this->filters['search'])) {
            $s = $this->filters['search'];
            $query->where(fn($q) => $q->where('nama_lengkap', 'like', "%{$s}%")
                                      ->orWhere('nis', 'like', "%{$s}%")
                                      ->orWhere('nisn', 'like', "%{$s}%"));
        }

        return $query->orderBy('nama_lengkap')->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'NIS',
            'NISN',
            'Nama Lengkap',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Agama',
            'No. HP',
            'Email',
            'Alamat',
            'Kelas',
            'Tahun Ajaran',
            'Status',
            'Tanggal Masuk',
            'Nama Ayah',
            'Pekerjaan Ayah',
            'No. HP Ayah',
            'Nama Ibu',
            'Pekerjaan Ibu',
            'No. HP Ibu',
            'Nama Wali',
            'Hubungan Wali',
            'No. HP Wali',
        ];
    }

    public function map($siswa): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $siswa->nis,
            $siswa->nisn ?? '-',
            $siswa->nama_lengkap,
            $siswa->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan',
            $siswa->tempat_lahir ?? '-',
            $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('d/m/Y') : '-',
            $siswa->agama ?? '-',
            $siswa->no_hp ?? '-',
            $siswa->email ?? '-',
            $siswa->alamat ?? '-',
            $siswa->kelas->nama_kelas ?? '-',
            $siswa->tahunAjaran ? $siswa->tahunAjaran->tahun . ' - ' . ucfirst($siswa->tahunAjaran->semester) : '-',
            ucfirst(str_replace('_', ' ', $siswa->status)),
            $siswa->tanggal_masuk ? $siswa->tanggal_masuk->format('d/m/Y') : '-',
            $siswa->nama_ayah ?? '-',
            $siswa->pekerjaan_ayah ?? '-',
            $siswa->no_hp_ayah ?? '-',
            $siswa->nama_ibu ?? '-',
            $siswa->pekerjaan_ibu ?? '-',
            $siswa->no_hp_ibu ?? '-',
            $siswa->nama_wali ?? '-',
            $siswa->hubungan_wali ?? '-',
            $siswa->no_hp_wali ?? '-',
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
        return 'Data Siswa';
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