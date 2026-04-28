<?php

namespace App\Exports;

use App\Models\IzinKeluarSiswa;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class IzinKeluarSiswaExport implements
    FromQuery,
    WithHeadings,
    WithMapping,
    WithStyles,
    WithTitle,
    ShouldAutoSize
{
    protected array $filters;
    protected int   $rowNumber = 0;

    public function __construct(array $filters = [])
    {
        $this->filters = $filters;
    }

    // ─── QUERY ───────────────────────────────────────────────────────────────

    public function query()
    {
        $query = IzinKeluarSiswa::with(['siswa.kelas', 'diprosesOleh', 'tahunAjaran'])
            ->orderByDesc('tanggal')
            ->orderByDesc('id');

        if (! empty($this->filters['tanggal_dari'])) {
            $query->whereDate('tanggal', '>=', $this->filters['tanggal_dari']);
        }

        if (! empty($this->filters['tanggal_sampai'])) {
            $query->whereDate('tanggal', '<=', $this->filters['tanggal_sampai']);
        }

        if (! empty($this->filters['status'])) {
            $query->where('status', $this->filters['status']);
        }

        if (! empty($this->filters['kategori'])) {
            $query->where('kategori', $this->filters['kategori']);
        }

        if (! empty($this->filters['tahun_ajaran_id'])) {
            $query->where('tahun_ajaran_id', $this->filters['tahun_ajaran_id']);
        }

        if (! empty($this->filters['kelas_id'])) {
            $query->whereHas('siswa', fn ($s) => $s->where('kelas_id', $this->filters['kelas_id']));
        }

        if (! empty($this->filters['search'])) {
            $s = $this->filters['search'];
            $query->where(fn ($q) => $q
                ->whereHas('siswa', fn ($s2) => $s2->where('nama_lengkap', 'like', "%{$s}%"))
                ->orWhere('nomor_surat', 'like', "%{$s}%")
                ->orWhere('tujuan', 'like', "%{$s}%")
            );
        }

        return $query;
    }

    // ─── HEADINGS ────────────────────────────────────────────────────────────

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'No. Surat',
            'Nama Siswa',
            'NIS',
            'Kelas',
            'Kategori',
            'Tujuan',
            'Keterangan',
            'Jam Keluar',
            'Jam Kembali (Rencana)',
            'Jam Kembali (Aktual)',
            'Status',
            'Diproses Oleh',
            'Tahun Ajaran',
        ];
    }

    // ─── MAPPING ─────────────────────────────────────────────────────────────

    public function map($izin): array
    {
        $this->rowNumber++;

        $kategoriLabel = IzinKeluarSiswa::KATEGORI_LIST[$izin->kategori] ?? ucfirst($izin->kategori);

        $statusLabel = match ($izin->status) {
            IzinKeluarSiswa::STATUS_MENUNGGU      => 'Menunggu',
            IzinKeluarSiswa::STATUS_DISETUJUI     => 'Disetujui',
            IzinKeluarSiswa::STATUS_DITOLAK       => 'Ditolak',
            IzinKeluarSiswa::STATUS_SUDAH_KEMBALI => 'Sudah Kembali',
            default                                => ucfirst($izin->status),
        };

        $tahunAjaranLabel = $izin->tahunAjaran?->label ?? '-';

        return [
            $this->rowNumber,
            $izin->tanggal
                ? \Carbon\Carbon::parse($izin->tanggal)->format('d/m/Y')
                : '-',
            $izin->nomor_surat         ?? '-',
            $izin->siswa?->nama_lengkap           ?? '-',
            $izin->siswa?->nis                    ?? '-',
            $izin->siswa?->kelas?->nama_kelas     ?? '-',
            $kategoriLabel,
            $izin->tujuan              ?? '-',
            $izin->keterangan          ?? '-',
            $izin->jam_keluar
                ? \Carbon\Carbon::parse($izin->jam_keluar)->format('H:i')
                : '-',
            $izin->jam_kembali
                ? \Carbon\Carbon::parse($izin->jam_kembali)->format('H:i')
                : '-',
            $izin->jam_kembali_aktual
                ? \Carbon\Carbon::parse($izin->jam_kembali_aktual)->format('H:i')
                : '-',
            $statusLabel,
            $izin->diprosesOleh?->name ?? '-',
            $tahunAjaranLabel,
        ];
    }

    // ─── STYLES ──────────────────────────────────────────────────────────────

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
                    'startColor' => ['argb' => 'FF1B3A6B'],
                ],
                'alignment' => [
                    'horizontal' => Alignment::HORIZONTAL_CENTER,
                    'vertical'   => Alignment::VERTICAL_CENTER,
                    'wrapText'   => true,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => Border::BORDER_THIN,
                        'color'       => ['argb' => 'FFAAAAAA'],
                    ],
                ],
            ],
        ];
    }

    // ─── TITLE ───────────────────────────────────────────────────────────────

    public function title(): string
    {
        return 'Izin Keluar Siswa';
    }
}