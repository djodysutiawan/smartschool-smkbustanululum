<?php

namespace App\Exports;

use App\Models\Materi;
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

class MateriExport implements FromQuery, WithHeadings, WithMapping, WithStyles, WithTitle, ShouldAutoSize
{
    protected array $filters;
    protected int $rowNumber = 0;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    public function query()
    {
        $query = Materi::with(['guru', 'mataPelajaran', 'kelas', 'tahunAjaran'])
            ->orderBy('urutan')
            ->latest();

        if (!empty($this->filters['guru_id'])) {
            $query->where('guru_id', $this->filters['guru_id']);
        }
        if (!empty($this->filters['kelas_id'])) {
            $query->where('kelas_id', $this->filters['kelas_id']);
        }
        if (!empty($this->filters['mata_pelajaran_id'])) {
            $query->where('mata_pelajaran_id', $this->filters['mata_pelajaran_id']);
        }
        if (isset($this->filters['dipublikasikan']) && $this->filters['dipublikasikan'] !== '') {
            $query->where('dipublikasikan', filter_var($this->filters['dipublikasikan'], FILTER_VALIDATE_BOOLEAN));
        }
        if (!empty($this->filters['search'])) {
            $query->where('judul', 'like', '%' . $this->filters['search'] . '%');
        }

        return $query;
    }

    public function headings(): array
    {
        return [
            'No',
            'Judul Materi',
            'Guru',
            'Mata Pelajaran',
            'Kelas',
            'Tahun Ajaran',
            'Jenis',
            'Urutan',
            'Status Publikasi',
            'Dipublikasikan Pada',
            'Dibuat Pada',
        ];
    }

    public function map($materi): array
    {
        $this->rowNumber++;

        return [
            $this->rowNumber,
            $materi->judul,
            $materi->guru?->nama_lengkap ?? '-',
            $materi->mataPelajaran?->nama_mapel ?? '-',
            $materi->kelas?->nama_kelas ?? '-',
            $materi->tahunAjaran?->tahun ?? '-',
            strtoupper($materi->jenis),
            $materi->urutan ?? 0,
            $materi->dipublikasikan ? 'Dipublikasikan' : 'Draft',
            $materi->dipublikasikan_pada?->format('d/m/Y H:i') ?? '-',
            $materi->created_at?->format('d/m/Y H:i') ?? '-',
        ];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF2D6A4F']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function title(): string
    {
        return 'Data Materi';
    }
}