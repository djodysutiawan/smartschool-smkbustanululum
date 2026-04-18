<?php
// ============================================================
// File: app/Imports/LogPiketImport.php
// ============================================================

namespace App\Imports;

use App\Models\LogPiket;
use App\Models\Guru;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Illuminate\Support\Facades\Auth;

class LogPiketImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    protected array $errors = [];

    public function model(array $row): ?LogPiket
    {
        $guru = Guru::where('nama_lengkap', trim($row['guru_piket'] ?? ''))
            ->orWhere('nip', trim($row['nip'] ?? ''))
            ->first();

        if (!$guru) {
            $this->errors[] = "Guru tidak ditemukan: " . ($row['guru_piket'] ?? '-');
            return null;
        }

        $tanggal = null;
        try {
            $tanggal = \Carbon\Carbon::parse($row['tanggal'])->format('Y-m-d');
        } catch (\Exception $e) {
            $this->errors[] = "Format tanggal tidak valid untuk guru: " . ($row['guru_piket'] ?? '-');
            return null;
        }

        $shiftList = ['pagi', 'siang'];
        $shift     = strtolower(trim($row['shift'] ?? ''));
        $shift     = in_array($shift, $shiftList) ? $shift : null;

        $masukPada  = null;
        $keluarPada = null;

        if (!empty($row['jam_masuk']) && $row['jam_masuk'] !== '-') {
            try {
                $masukPada = \Carbon\Carbon::parse($tanggal . ' ' . $row['jam_masuk']);
            } catch (\Exception $e) {
                // silently skip invalid time
            }
        }

        if (!empty($row['jam_keluar']) && $row['jam_keluar'] !== '-') {
            try {
                $keluarPada = \Carbon\Carbon::parse($tanggal . ' ' . $row['jam_keluar']);
            } catch (\Exception $e) {
                // silently skip invalid time
            }
        }

        return new LogPiket([
            'pengguna_id'  => Auth::id(),
            'guru_id'      => $guru->id,
            'tanggal'      => $tanggal,
            'shift'        => $shift,
            'masuk_pada'   => $masukPada,
            'keluar_pada'  => $keluarPada,
            'catatan'      => $row['catatan'] ?? null,
        ]);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}


// ============================================================
// File: app/Exports/JadwalPiketGuruTemplateExport.php
// ============================================================

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class JadwalPiketGuruTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    public function array(): array
    {
        return [
            ['Budi Santoso', '198501012010011001', '2024/2025', 'Senin', '07:00', '12:00', 'Aktif', 'Contoh catatan'],
        ];
    }

    public function headings(): array
    {
        return ['Guru Piket', 'NIP', 'Tahun Ajaran', 'Hari', 'Jam Mulai', 'Jam Selesai', 'Status', 'Catatan'];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF1F63DB']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return ['A' => 28, 'B' => 22, 'C' => 16, 'D' => 12, 'E' => 12, 'F' => 12, 'G' => 12, 'H' => 30];
    }
}


// ============================================================
// File: app/Exports/LogPiketTemplateExport.php
// ============================================================

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LogPiketTemplateExport implements FromArray, WithHeadings, WithStyles, WithColumnWidths
{
    public function array(): array
    {
        return [
            ['Budi Santoso', '198501012010011001', '2025-01-15', 'Pagi', '07:00', '12:00', 'Contoh catatan'],
        ];
    }

    public function headings(): array
    {
        return ['Guru Piket', 'NIP', 'Tanggal', 'Shift', 'Jam Masuk', 'Jam Keluar', 'Catatan'];
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            1 => [
                'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
                'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF1F63DB']],
                'alignment' => ['horizontal' => 'center'],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return ['A' => 28, 'B' => 22, 'C' => 14, 'D' => 10, 'E' => 12, 'F' => 12, 'G' => 30];
    }
}