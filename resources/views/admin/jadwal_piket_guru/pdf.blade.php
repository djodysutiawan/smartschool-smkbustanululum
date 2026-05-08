<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Jadwal Piket Guru</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 11px;
            color: #0f172a;
            background: #fff;
        }

        /* ── Header ─────────────────────────────────────────────────────────── */
        .header {
            background: #1f63db;
            color: #fff;
            padding: 18px 24px;
            margin-bottom: 20px;
        }
        .header-inner {
            display: table;
            width: 100%;
        }
        .header-left {
            display: table-cell;
            vertical-align: top;
        }
        .header-right {
            display: table-cell;
            vertical-align: top;
            text-align: right;
            white-space: nowrap;
        }
        .doc-title-main {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 2px;
        }
        .doc-subtitle {
            font-size: 11px;
            opacity: .8;
        }
        .doc-meta {
            font-size: 10px;
            opacity: .85;
            line-height: 1.6;
        }

        /* ── Body ────────────────────────────────────────────────────────────── */
        .body { padding: 0 24px 24px; }

        /* ── Stats ───────────────────────────────────────────────────────────── */
        .stats-row {
            display: table;
            width: 100%;
            margin-bottom: 18px;
            border-spacing: 10px 0;
        }
        .stat-box {
            display: table-cell;
            border: 1px solid #e2e8f0;
            border-radius: 7px;
            padding: 10px 14px;
            width: 33.333%;
        }
        .stat-label {
            font-size: 9px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: .05em;
        }
        .stat-val {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            margin-top: 3px;
            line-height: 1;
        }

        /* ── Section title ───────────────────────────────────────────────────── */
        .section-title {
            font-size: 12px;
            font-weight: 700;
            color: #1f63db;
            border-bottom: 2px solid #1f63db;
            padding-bottom: 5px;
            margin-bottom: 12px;
        }

        /* ── Table ───────────────────────────────────────────────────────────── */
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 10.5px;
        }
        thead tr {
            background: #1f63db;
            color: #fff;
        }
        thead th {
            padding: 8px 9px;
            text-align: left;
            font-weight: 700;
            font-size: 9.5px;
            text-transform: uppercase;
            letter-spacing: .04em;
        }
        thead th.center { text-align: center; }

        tbody tr { border-bottom: 1px solid #f1f5f9; }
        tbody tr:nth-child(even) { background: #f8fafc; }
        tbody tr:last-child { border-bottom: none; }

        td { padding: 7px 9px; vertical-align: middle; }
        td.center { text-align: center; }
        td.muted { color: #64748b; }
        td.no { font-weight: 700; color: #94a3b8; }
        td.guru-name { font-weight: 700; }

        /* ── Hari badges ─────────────────────────────────────────────────────── */
        .hari-badge {
            display: inline-block;
            padding: 2px 7px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 9.5px;
        }
        .hari-senin   { background: #eff6ff; color: #1d4ed8; }
        .hari-selasa  { background: #f0fdf4; color: #15803d; }
        .hari-rabu    { background: #fefce8; color: #a16207; }
        .hari-kamis   { background: #fff7ed; color: #c2410c; }
        .hari-jumat   { background: #fdf4ff; color: #7c3aed; }
        .hari-sabtu   { background: #f0f9ff; color: #0369a1; }

        /* ── Status badges ───────────────────────────────────────────────────── */
        .badge-aktif {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 99px;
            background: #dcfce7;
            color: #15803d;
            font-weight: 700;
            font-size: 9.5px;
        }
        .badge-nonaktif {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 99px;
            background: #fee2e2;
            color: #dc2626;
            font-weight: 700;
            font-size: 9.5px;
        }

        /* ── Jam cell ────────────────────────────────────────────────────────── */
        .jam-cell { white-space: nowrap; }

        /* ── Catatan cell ────────────────────────────────────────────────────── */
        .catatan-cell {
            max-width: 110px;
            color: #64748b;
            word-break: break-word;
        }

        /* ── Empty state ─────────────────────────────────────────────────────── */
        .empty-row td {
            text-align: center;
            padding: 24px;
            color: #94a3b8;
            font-style: italic;
        }

        /* ── Footer ──────────────────────────────────────────────────────────── */
        .footer {
            margin-top: 24px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            display: table;
            width: 100%;
            font-size: 9px;
            color: #94a3b8;
        }
        .footer-left  { display: table-cell; text-align: left; }
        .footer-right { display: table-cell; text-align: right; }
    </style>
</head>
<body>

    {{-- ── Header ─────────────────────────────────────────────────────────── --}}
    <div class="header">
        <div class="header-inner">
            <div class="header-left">
                <p class="doc-title-main">Jadwal Piket Guru</p>
                <p class="doc-subtitle">Daftar Jadwal Rotasi Piket Guru</p>
            </div>
            <div class="header-right">
                <div class="doc-meta">
                    <p>Dicetak: {{ now()->format('d M Y, H:i') }}</p>
                    <p>Total Data: {{ $jadwal->count() }} jadwal</p>
                </div>
            </div>
        </div>
    </div>

    <div class="body">

        {{-- ── Stats ─────────────────────────────────────────────────────────── --}}
        @php
            $totalAktif    = $jadwal->where('is_active', true)->count();
            $totalNonaktif = $jadwal->where('is_active', false)->count();
            $totalJadwal   = $jadwal->count();
        @endphp

        <table class="stats-row" style="margin-bottom:18px;border-collapse:separate;border-spacing:8px 0">
            <tr>
                <td class="stat-box">
                    <p class="stat-label">Total Jadwal</p>
                    <p class="stat-val">{{ $totalJadwal }}</p>
                </td>
                <td class="stat-box">
                    <p class="stat-label">Aktif</p>
                    <p class="stat-val" style="color:#15803d">{{ $totalAktif }}</p>
                </td>
                <td class="stat-box">
                    <p class="stat-label">Nonaktif</p>
                    <p class="stat-val" style="color:#dc2626">{{ $totalNonaktif }}</p>
                </td>
            </tr>
        </table>

        {{-- ── Table ──────────────────────────────────────────────────────────── --}}
        <p class="section-title">Daftar Jadwal Piket</p>

        <table>
            <thead>
                <tr>
                    <th style="width:30px">#</th>
                    <th style="width:60px">Hari</th>
                    <th style="width:90px">Jam Piket</th>
                    <th>Guru Piket</th>
                    <th style="width:110px">NIP</th>
                    <th style="width:90px">Tahun Ajaran</th>
                    <th class="center" style="width:60px">Status</th>
                    <th>Catatan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwal as $index => $j)
                <tr>
                    <td class="no">{{ $index + 1 }}</td>
                    <td>
                        <span class="hari-badge hari-{{ $j->hari }}">{{ ucfirst($j->hari) }}</span>
                    </td>
                    <td class="jam-cell">
                        {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}
                        –
                        {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                    </td>
                    <td class="guru-name">{{ $j->guru->nama_lengkap ?? '-' }}</td>
                    <td class="muted">{{ $j->guru->nip ?? '-' }}</td>
                    <td>{{ $j->tahunAjaran->tahun ?? '-' }}</td>
                    <td class="center">
                        @if($j->is_active)
                            <span class="badge-aktif">Aktif</span>
                        @else
                            <span class="badge-nonaktif">Nonaktif</span>
                        @endif
                    </td>
                    <td class="catatan-cell">{{ $j->catatan ?: '-' }}</td>
                </tr>
                @empty
                <tr class="empty-row">
                    <td colspan="8">Tidak ada data jadwal piket</td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- ── Footer ─────────────────────────────────────────────────────────── --}}
        <div class="footer">
            <span class="footer-left">Dokumen ini digenerate secara otomatis oleh sistem</span>
            <span class="footer-right">{{ now()->format('d M Y, H:i:s') }}</span>
        </div>

    </div>
</body>
</html>