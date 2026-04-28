<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Export Izin Keluar Siswa</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 10px;
            color: #0f172a;
            background: #fff;
        }

        /* ─── HEADER ─── */
        .header {
            border-bottom: 2.5px solid #1f63db;
            padding-bottom: 10px;
            margin-bottom: 14px;
        }
        .header-inner {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        .school-name {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: .01em;
        }
        .doc-title {
            font-size: 11px;
            font-weight: 700;
            color: #1f63db;
            margin-top: 2px;
        }
        .doc-meta {
            font-size: 8.5px;
            color: #64748b;
            margin-top: 3px;
        }
        .header-right {
            text-align: right;
            font-size: 8.5px;
            color: #64748b;
        }

        /* ─── TABLE ─── */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5px;
        }
        thead tr {
            background: #1b3a6b;
            color: #fff;
        }
        thead th {
            padding: 7px 6px;
            text-align: left;
            font-weight: 700;
            font-size: 8px;
            letter-spacing: .03em;
            text-transform: uppercase;
            white-space: nowrap;
        }
        thead th.center { text-align: center; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody tr:nth-child(odd)  { background: #fff; }
        tbody td {
            padding: 6px 6px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
            color: #1e293b;
        }
        tbody td.center { text-align: center; }
        tbody td.muted  { color: #64748b; }

        /* ─── BADGE ─── */
        .badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 99px;
            font-size: 7.5px;
            font-weight: 700;
        }
        .badge-menunggu      { background: #fefce8; color: #a16207; }
        .badge-disetujui     { background: #dcfce7; color: #15803d; }
        .badge-ditolak       { background: #fee2e2; color: #dc2626; }
        .badge-sudah_kembali { background: #eff6ff; color: #1d4ed8; }

        .badge-keperluan_keluarga { background: #fff7ed; color: #c2410c; }
        .badge-keperluan_sekolah  { background: #ecfdf5; color: #065f46; }
        .badge-berobat            { background: #fdf4ff; color: #7c3aed; }
        .badge-lainnya            { background: #f1f5f9; color: #475569; }

        /* ─── FOOTER ─── */
        .footer {
            margin-top: 14px;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
            font-size: 8px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 8px;
        }
        .summary {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 8px 14px;
            margin-bottom: 12px;
            display: flex;
            gap: 24px;
            font-size: 8.5px;
        }
        .summary-item strong {
            font-size: 13px;
            color: #0f172a;
            display: block;
            font-weight: 800;
        }
        .summary-label { color: #64748b; }

        .no-data {
            text-align: center;
            padding: 30px;
            color: #94a3b8;
            font-size: 11px;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <div class="header-inner">
            <div>
                <p class="school-name">Laporan Izin Keluar Siswa</p>
                <p class="doc-title">Rekap Data Perizinan</p>
                <p class="doc-meta">Dicetak pada: {{ now()->isoFormat('D MMMM Y, HH:mm') }} WIB</p>
            </div>
            <div class="header-right">
                <p>Total data: <strong>{{ $izins->count() }}</strong> izin</p>
            </div>
        </div>
    </div>

    {{-- Summary --}}
    @php
        $totalMenunggu     = $izins->where('status', 'menunggu')->count();
        $totalDisetujui    = $izins->where('status', 'disetujui')->count();
        $totalDitolak      = $izins->where('status', 'ditolak')->count();
        $totalSudahKembali = $izins->where('status', 'sudah_kembali')->count();
    @endphp
    <div class="summary">
        <div class="summary-item">
            <strong>{{ $izins->count() }}</strong>
            <span class="summary-label">Total Izin</span>
        </div>
        <div class="summary-item">
            <strong>{{ $totalMenunggu }}</strong>
            <span class="summary-label">Menunggu</span>
        </div>
        <div class="summary-item">
            <strong>{{ $totalDisetujui }}</strong>
            <span class="summary-label">Disetujui</span>
        </div>
        <div class="summary-item">
            <strong>{{ $totalDitolak }}</strong>
            <span class="summary-label">Ditolak</span>
        </div>
        <div class="summary-item">
            <strong>{{ $totalSudahKembali }}</strong>
            <span class="summary-label">Sudah Kembali</span>
        </div>
    </div>

    {{-- Table --}}
    @if($izins->isEmpty())
        <div class="no-data">Tidak ada data izin keluar yang ditemukan.</div>
    @else
    <table>
        <thead>
            <tr>
                <th style="width:24px">#</th>
                <th>Tanggal</th>
                <th>No. Surat</th>
                <th>Nama Siswa</th>
                <th>Kelas</th>
                <th class="center">Kategori</th>
                <th>Tujuan</th>
                <th class="center">Jam Keluar</th>
                <th class="center">Jam Kembali</th>
                <th class="center">Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($izins as $i => $izin)
            <tr>
                <td class="muted" style="font-weight:700">{{ $i + 1 }}</td>

                <td style="white-space:nowrap;font-weight:600">
                    {{ \Carbon\Carbon::parse($izin->tanggal)->format('d/m/Y') }}
                </td>

                <td class="muted" style="font-size:7.5px">
                    {{ $izin->nomor_surat ?? '—' }}
                </td>

                <td>
                    <span style="font-weight:700">{{ $izin->siswa->nama_lengkap ?? '—' }}</span>
                    @if($izin->siswa?->nis)
                        <br><span style="color:#94a3b8;font-size:7.5px">{{ $izin->siswa->nis }}</span>
                    @endif
                </td>

                <td>{{ $izin->siswa->kelas->nama_kelas ?? '—' }}</td>

                <td class="center">
                    @php
                        $kat = $izin->kategori ?? 'lainnya';
                        $allowed = ['keperluan_keluarga','keperluan_sekolah','berobat','lainnya'];
                        $bc = in_array($kat, $allowed) ? 'badge-'.$kat : 'badge-lainnya';
                    @endphp
                    <span class="badge {{ $bc }}">
                        {{ $kategoriList[$izin->kategori] ?? ucfirst($izin->kategori) }}
                    </span>
                </td>

                <td style="max-width:120px">
                    {{ \Illuminate\Support\Str::limit($izin->tujuan, 40) }}
                </td>

                <td class="center muted">
                    {{ $izin->jam_keluar ? \Carbon\Carbon::parse($izin->jam_keluar)->format('H:i') : '—' }}
                </td>

                <td class="center muted">
                    @if($izin->jam_kembali_aktual)
                        <span style="font-weight:700;color:#1d4ed8">
                            {{ \Carbon\Carbon::parse($izin->jam_kembali_aktual)->format('H:i') }}
                        </span>
                    @elseif($izin->jam_kembali)
                        {{ \Carbon\Carbon::parse($izin->jam_kembali)->format('H:i') }}
                    @else
                        —
                    @endif
                </td>

                <td class="center">
                    <span class="badge badge-{{ $izin->status }}">
                        {{ $statusList[$izin->status] ?? ucfirst($izin->status) }}
                    </span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    {{-- Footer --}}
    <div class="footer">
        <span>Dokumen ini digenerate secara otomatis oleh sistem.</span>
        <span>{{ now()->format('d/m/Y H:i') }}</span>
    </div>

</body>
</html>