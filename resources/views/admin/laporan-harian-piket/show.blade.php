<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}
    .btn-pdf{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-pdf:hover{background:#fee2e2;filter:none}

    /* Info grid */
    .info-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(185px,1fr));gap:12px;margin-bottom:16px}
    .info-item{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px 16px}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:5px}
    .info-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text)}
    .info-val.muted{font-weight:500;color:var(--text2);font-size:13px}

    /* Two-col layout */
    .two-col{display:grid;grid-template-columns:1fr 1fr;gap:16px}

    /* Panel */
    .panel{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .panel-header{display:flex;align-items:center;justify-content:space-between;padding:13px 20px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .panel-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:7px}
    .panel-badge{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;padding:2px 10px;border-radius:99px}
    .panel-body{padding:20px}
    .panel-text{font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text2);line-height:1.75;white-space:pre-wrap;min-height:52px}
    .panel-text.empty{color:var(--text3);font-style:italic}

    /* Rekap 4 kotak */
    .rekap-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:10px}
    .rekap-box{border-radius:var(--radius-sm);padding:16px 12px;text-align:center}
    .rekap-box.hadir{background:#f0fdf4;border:1px solid #bbf7d0}
    .rekap-box.izin {background:#eff6ff;border:1px solid #bfdbfe}
    .rekap-box.sakit{background:#fdf4ff;border:1px solid #e9d5ff}
    .rekap-box.alfa {background:#fff0f0;border:1px solid #fecaca}
    .rekap-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;letter-spacing:.04em;text-transform:uppercase;margin-bottom:6px}
    .rekap-box.hadir .rekap-label{color:#15803d}
    .rekap-box.izin  .rekap-label{color:#1d4ed8}
    .rekap-box.sakit .rekap-label{color:#7c3aed}
    .rekap-box.alfa  .rekap-label{color:#dc2626}
    .rekap-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:28px;font-weight:800;line-height:1}
    .rekap-box.hadir .rekap-val{color:#15803d}
    .rekap-box.izin  .rekap-val{color:#1d4ed8}
    .rekap-box.sakit .rekap-val{color:#7c3aed}
    .rekap-box.alfa  .rekap-val{color:#dc2626}

    /* Log piket */
    .log-row{display:flex;gap:12px;flex-wrap:wrap}
    .log-box{flex:1;min-width:120px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px 16px;text-align:center}
    .log-box-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:6px}
    .log-box-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}

    /* Badge */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-hadir{background:#dcfce7;color:#15803d}
    .badge-telat{background:#fef9c3;color:#a16207}
    .badge-izin {background:#dbeafe;color:#1d4ed8}
    .badge-sakit{background:#f3e8ff;color:#7c3aed}
    .badge-alfa {background:#fee2e2;color:#dc2626}
    .badge-selesai  {background:#dcfce7;color:#15803d}
    .badge-diproses {background:#fef9c3;color:#a16207}
    .badge-pending  {background:var(--surface3);color:var(--text3)}
    .badge-checkout-warn{background:#fef9c3;color:#a16207;border:1px solid #fde68a}
    .badge-izin-keluar-approved{background:#dcfce7;color:#15803d}
    .badge-izin-keluar-kembali {background:#dbeafe;color:#1d4ed8}
    .badge-izin-keluar-ditolak {background:#fee2e2;color:#dc2626}
    .badge-izin-keluar-pending  {background:var(--surface3);color:var(--text3)}

    /* Mini table */
    .mini-table-wrap{overflow-x:auto}
    table.mini{width:100%;border-collapse:collapse;font-size:13px}
    table.mini thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    table.mini thead th{padding:9px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    table.mini tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    table.mini tbody tr:last-child{border-bottom:none}
    table.mini tbody tr:hover{background:#fafbff}
    table.mini td{padding:9px 14px;color:var(--text);vertical-align:middle}
    table.mini td.muted{color:var(--text3);font-size:12.5px}
    table.mini td.center{text-align:center}

    /* Scroll body */
    .scroll-body{max-height:380px;overflow-y:auto}

    /* Empty inline */
    .empty-inline{padding:24px;text-align:center;font-size:13px;color:var(--text3)}

    /* Kejadian khusus */
    .kejadian-box{background:#fffbeb;border:1px solid #fde68a;border-radius:var(--radius-sm);padding:14px 16px}
    .kejadian-text{font-family:'DM Sans',sans-serif;font-size:14px;color:#92400e;line-height:1.75;white-space:pre-wrap}

    /* Izin keluar ringkasan stats */
    .izin-stats{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;margin-bottom:14px}
    .izin-stat-box{border-radius:var(--radius-sm);padding:10px 12px;text-align:center}
    .izin-stat-box.total   {background:var(--surface2);border:1px solid var(--border)}
    .izin-stat-box.approved{background:#f0fdf4;border:1px solid #bbf7d0}
    .izin-stat-box.kembali {background:#eff6ff;border:1px solid #bfdbfe}
    .izin-stat-box.ditolak {background:#fff0f0;border:1px solid #fecaca}
    .izin-stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:.04em;text-transform:uppercase;margin-bottom:4px}
    .izin-stat-box.total    .izin-stat-label{color:var(--text3)}
    .izin-stat-box.approved .izin-stat-label{color:#15803d}
    .izin-stat-box.kembali  .izin-stat-label{color:#1d4ed8}
    .izin-stat-box.ditolak  .izin-stat-label{color:#dc2626}
    .izin-stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;line-height:1}
    .izin-stat-box.total    .izin-stat-val{color:var(--text2)}
    .izin-stat-box.approved .izin-stat-val{color:#15803d}
    .izin-stat-box.kembali  .izin-stat-val{color:#1d4ed8}
    .izin-stat-box.ditolak  .izin-stat-val{color:#dc2626}

    @media(max-width:768px){
        .two-col{grid-template-columns:1fr}
        .rekap-grid{grid-template-columns:repeat(2,1fr)}
        .izin-stats{grid-template-columns:repeat(2,1fr)}
        .page{padding:16px}
        .header-actions{width:100%}
    }
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Laporan Harian Piket</h1>
            {{-- tanggal sudah Carbon (cast 'date'), tidak perlu parse() --}}
            <p class="page-sub">
                {{ $laporanHarianPiket->tanggal->translatedFormat('l, d F Y') }}
                &mdash; {{ $laporanHarianPiket->dibuatOleh?->name ?? '—' }}
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.laporan-harian-piket.index') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.laporan-harian-piket.export-pdf', [
                    'dibuat_oleh'    => $laporanHarianPiket->dibuat_oleh,
                    'tanggal_dari'   => $laporanHarianPiket->tanggal->toDateString(),
                    'tanggal_sampai' => $laporanHarianPiket->tanggal->toDateString(),
                ]) }}" class="btn btn-pdf" target="_blank">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Export PDF
            </a>
            <form action="{{ route('admin.laporan-harian-piket.destroy', $laporanHarianPiket) }}"
                  method="POST" id="delForm" style="display:inline">
                @csrf
                @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Info Grid --}}
    <div class="info-grid">
        <div class="info-item">
            <p class="info-label">Guru Piket</p>
            <p class="info-val">{{ $laporanHarianPiket->dibuatOleh?->name ?? '—' }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">Email</p>
            <p class="info-val muted">{{ $laporanHarianPiket->dibuatOleh?->email ?? '—' }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">Tanggal Laporan</p>
            <p class="info-val">{{ $laporanHarianPiket->tanggal->translatedFormat('d F Y') }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">Laporan Dibuat</p>
            {{-- created_at sudah Carbon (default Laravel), tidak perlu parse() --}}
            <p class="info-val muted">{{ $laporanHarianPiket->created_at->format('d/m/Y H:i') }}</p>
        </div>
        <div class="info-item">
            <p class="info-label">Total Pelanggaran</p>
            <p class="info-val" style="color:#dc2626">{{ $pelanggaranHariItu->count() }}</p>
        </div>
        @if($logPiket)
        <div class="info-item">
            <p class="info-label">Shift</p>
            <p class="info-val">{{ $logPiket->shift ? ucfirst($logPiket->shift) : '—' }}</p>
        </div>
        @endif
    </div>

    {{-- Log Piket --}}
    @if($logPiket)
    <div class="panel">
        <div class="panel-header">
            <p class="panel-title">
                <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Log Piket Hari Ini
            </p>
        </div>
        <div class="panel-body">
            <div class="log-row">
                <div class="log-box">
                    <p class="log-box-label">Check-In</p>
                    {{-- masuk_pada di-cast datetime (Carbon) di model LogPiket --}}
                    <p class="log-box-val" style="color:#15803d">
                        {{ $logPiket->masuk_pada ? $logPiket->masuk_pada->format('H:i') : '—' }}
                    </p>
                </div>
                <div class="log-box">
                    <p class="log-box-label">Check-Out</p>
                    {{-- keluar_pada di-cast datetime (Carbon) di model LogPiket --}}
                    @if($logPiket->keluar_pada)
                        <p class="log-box-val" style="color:#1d4ed8">
                            {{ $logPiket->keluar_pada->format('H:i') }}
                        </p>
                    @else
                        <p class="log-box-val" style="font-size:13px">
                            <span class="badge badge-checkout-warn">Belum checkout</span>
                        </p>
                    @endif
                </div>
                <div class="log-box">
                    <p class="log-box-label">Shift</p>
                    <p class="log-box-val">{{ $logPiket->shift ? ucfirst($logPiket->shift) : '—' }}</p>
                </div>
                {{-- Gunakan accessor durasi_format dari model LogPiket jika tersedia --}}
                @if($logPiket->durasi_format)
                <div class="log-box">
                    <p class="log-box-label">Durasi</p>
                    <p class="log-box-val" style="color:#7c3aed">{{ $logPiket->durasi_format }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- Two Column --}}
    <div class="two-col">

        {{-- KIRI: Isi Laporan --}}
        <div>

            {{-- Catatan Umum --}}
            <div class="panel">
                <div class="panel-header">
                    <p class="panel-title">
                        <svg width="14" height="14" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                        Catatan Umum
                    </p>
                </div>
                <div class="panel-body">
                    @if($laporanHarianPiket->catatan_umum)
                        <p class="panel-text">{{ $laporanHarianPiket->catatan_umum }}</p>
                    @else
                        <p class="panel-text empty">Tidak ada catatan umum</p>
                    @endif
                </div>
            </div>

            {{-- Kejadian Khusus --}}
            <div class="panel">
                <div class="panel-header">
                    <p class="panel-title">
                        <svg width="14" height="14" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Kejadian Khusus
                    </p>
                </div>
                <div class="panel-body">
                    @if($laporanHarianPiket->kejadian_khusus)
                        <div class="kejadian-box">
                            <p class="kejadian-text">{{ $laporanHarianPiket->kejadian_khusus }}</p>
                        </div>
                    @else
                        <p class="panel-text empty">Tidak ada kejadian khusus</p>
                    @endif
                </div>
            </div>

            {{--
                FIX: tindak_lanjut tidak ada di $fillable model, jadi blok ini
                hanya ditampilkan jika properti memang terisi (tidak null/empty).
                Menggunakan isset() + truthy check agar aman meski kolom tidak ada.
            --}}
            @if(!empty($laporanHarianPiket->tindak_lanjut))
            <div class="panel">
                <div class="panel-header">
                    <p class="panel-title">
                        <svg width="14" height="14" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        Tindak Lanjut
                    </p>
                </div>
                <div class="panel-body">
                    <p class="panel-text">{{ $laporanHarianPiket->tindak_lanjut }}</p>
                </div>
            </div>
            @endif

            {{-- Pelanggaran --}}
            <div class="panel">
                <div class="panel-header">
                    <p class="panel-title">
                        <svg width="14" height="14" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                        Pelanggaran Dicatat
                    </p>
                    <span class="panel-badge" style="background:#fee2e2;color:#dc2626">
                        {{ $pelanggaranHariItu->count() }}
                    </span>
                </div>
                <div class="mini-table-wrap">
                    <table class="mini">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Kelas</th>
                                <th>Kategori</th>
                                <th class="center">Poin</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pelanggaranHariItu as $p)
                            @php
                                $statusClass = match($p->status ?? '') {
                                    'selesai'  => 'badge-selesai',
                                    'diproses' => 'badge-diproses',
                                    default    => 'badge-pending',
                                };
                            @endphp
                            <tr>
                                <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">
                                    {{ $p->siswa?->nama_lengkap ?? '—' }}
                                </td>
                                <td class="muted">{{ $p->siswa?->kelas?->nama_kelas ?? '—' }}</td>
                                <td>{{ $p->kategori?->nama ?? '—' }}</td>
                                <td class="center">
                                    <span style="background:#fee2e2;color:#dc2626;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;padding:2px 8px;border-radius:99px">
                                        {{ $p->poin }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge {{ $statusClass }}">
                                        {{ ucfirst($p->status ?? 'pending') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="empty-inline">
                                    Tidak ada pelanggaran yang dicatat
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- KANAN: Rekap, Absensi & Izin Keluar --}}
        <div>

            {{-- Rekap Snapshot --}}
            <div class="panel">
                <div class="panel-header">
                    <p class="panel-title">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        Rekap Absensi Guru (Snapshot)
                    </p>
                </div>
                <div class="panel-body">
                    <p style="font-size:12px;color:var(--text3);margin-bottom:14px">
                        Data rekap saat laporan disimpan oleh guru piket.
                    </p>
                    @php
                        $r     = $rekapAbsensi;
                        $total = ($r['hadir'] ?? 0) + ($r['izin'] ?? 0)
                               + ($r['sakit'] ?? 0) + ($r['alfa']  ?? 0);
                    @endphp
                    @if(!empty($r))
                    <div class="rekap-grid">
                        <div class="rekap-box hadir">
                            <p class="rekap-label">Hadir</p>
                            <p class="rekap-val">{{ $r['hadir'] ?? 0 }}</p>
                        </div>
                        <div class="rekap-box izin">
                            <p class="rekap-label">Izin</p>
                            <p class="rekap-val">{{ $r['izin'] ?? 0 }}</p>
                        </div>
                        <div class="rekap-box sakit">
                            <p class="rekap-label">Sakit</p>
                            <p class="rekap-val">{{ $r['sakit'] ?? 0 }}</p>
                        </div>
                        <div class="rekap-box alfa">
                            <p class="rekap-label">Alfa</p>
                            <p class="rekap-val">{{ $r['alfa'] ?? 0 }}</p>
                        </div>
                    </div>
                    <p style="text-align:center;font-size:12px;color:var(--text3);margin-top:12px">
                        Total tercatat: <strong>{{ $total }}</strong> guru
                    </p>
                    @else
                        <p class="panel-text empty">Rekap absensi tidak tersedia</p>
                    @endif
                </div>
            </div>

            {{-- Absensi Aktual Guru --}}
            <div class="panel">
                <div class="panel-header">
                    <p class="panel-title">
                        <svg width="14" height="14" fill="none" stroke="var(--text3)" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Absensi Aktual Guru
                    </p>
                    <span class="panel-badge" style="background:var(--surface3);color:var(--text3)">
                        {{ $absensiHariItu->count() }} tercatat
                    </span>
                </div>
                <div class="scroll-body">
                    <table class="mini">
                        <thead>
                            <tr>
                                <th>Nama Guru</th>
                                <th class="center">Jam Masuk</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($absensiHariItu as $ab)
                            @php
                                $absensiStatusClass = match($ab->status ?? '') {
                                    'hadir'  => 'badge-hadir',
                                    'telat'  => 'badge-telat',
                                    'izin'   => 'badge-izin',
                                    'sakit'  => 'badge-sakit',
                                    default  => 'badge-alfa',
                                };
                                $absensiDotColor = match($ab->status ?? '') {
                                    'hadir','telat' => '#15803d',
                                    'izin'          => '#1d4ed8',
                                    'sakit'         => '#7c3aed',
                                    default         => '#dc2626',
                                };
                            @endphp
                            <tr>
                                <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px">
                                    {{--
                                        FIX: nama kolom nama guru disesuaikan dengan relasi
                                        yang ada di model AbsensiGuru. Jika relasi adalah
                                        'guru' dengan kolom 'name' (dari tabel users), gunakan
                                        $ab->guru?->name. Jika model Guru punya 'nama_lengkap',
                                        gunakan $ab->guru?->nama_lengkap.
                                        Sesuaikan dengan model AbsensiGuru Anda.
                                    --}}
                                    {{ $ab->guru?->nama_lengkap ?? $ab->guru?->name ?? '—' }}
                                </td>
                                <td class="muted center">
                                    {{ $ab->jam_masuk ?? '—' }}
                                </td>
                                <td>
                                    <span class="badge {{ $absensiStatusClass }}">
                                        <span class="badge-dot" style="background:{{ $absensiDotColor }}"></span>
                                        {{ ucfirst($ab->status ?? 'alfa') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="empty-inline">Tidak ada data absensi</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Izin Keluar Siswa --}}
            <div class="panel">
                <div class="panel-header">
                    <p class="panel-title">
                        <svg width="14" height="14" fill="none" stroke="#1d4ed8" stroke-width="2" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                        Izin Keluar Siswa
                    </p>
                    <span class="panel-badge" style="background:#dbeafe;color:#1d4ed8">
                        {{ $ringkasanIzin['total'] }} izin
                    </span>
                </div>
                <div class="panel-body" style="padding-bottom:0">
                    <div class="izin-stats">
                        <div class="izin-stat-box total">
                            <p class="izin-stat-label">Total</p>
                            <p class="izin-stat-val">{{ $ringkasanIzin['total'] }}</p>
                        </div>
                        <div class="izin-stat-box approved">
                            <p class="izin-stat-label">Disetujui</p>
                            <p class="izin-stat-val">{{ $ringkasanIzin['disetujui'] }}</p>
                        </div>
                        <div class="izin-stat-box kembali">
                            <p class="izin-stat-label">Sudah Kembali</p>
                            <p class="izin-stat-val">{{ $ringkasanIzin['sudah_kembali'] }}</p>
                        </div>
                        <div class="izin-stat-box ditolak">
                            <p class="izin-stat-label">Ditolak</p>
                            <p class="izin-stat-val">{{ $ringkasanIzin['ditolak'] }}</p>
                        </div>
                    </div>
                </div>
                <div class="scroll-body">
                    <table class="mini">
                        <thead>
                            <tr>
                                <th>Siswa</th>
                                <th>Kelas</th>
                                <th class="center">Jam Keluar</th>
                                <th class="center">Jam Kembali</th>
                                <th>Keperluan</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($izinKeluarHariItu as $iz)
                            @php
                                $izinStatusClass = match($iz->status ?? '') {
                                    \App\Models\IzinKeluarSiswa::STATUS_DISETUJUI      => 'badge-izin-keluar-approved',
                                    \App\Models\IzinKeluarSiswa::STATUS_SUDAH_KEMBALI  => 'badge-izin-keluar-kembali',
                                    \App\Models\IzinKeluarSiswa::STATUS_DITOLAK        => 'badge-izin-keluar-ditolak',
                                    default                                            => 'badge-izin-keluar-pending',
                                };
                                $izinStatusLabel = match($iz->status ?? '') {
                                    \App\Models\IzinKeluarSiswa::STATUS_DISETUJUI      => 'Disetujui',
                                    \App\Models\IzinKeluarSiswa::STATUS_SUDAH_KEMBALI  => 'Sudah Kembali',
                                    \App\Models\IzinKeluarSiswa::STATUS_DITOLAK        => 'Ditolak',
                                    default                                            => 'Menunggu',
                                };
                            @endphp
                            <tr>
                                <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px">
                                    {{ $iz->siswa?->nama_lengkap ?? '—' }}
                                </td>
                                <td class="muted">{{ $iz->siswa?->kelas?->nama_kelas ?? '—' }}</td>
                                <td class="center muted">{{ $iz->jam_keluar ?? '—' }}</td>
                                <td class="center muted">{{ $iz->jam_kembali ?? '—' }}</td>
                                <td style="font-size:12.5px;max-width:130px">
                                    <p style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                                        {{ $iz->keperluan ?? '—' }}
                                    </p>
                                </td>
                                <td>
                                    <span class="badge {{ $izinStatusClass }}">{{ $izinStatusLabel }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="empty-inline">
                                    Tidak ada izin keluar siswa pada hari ini
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>{{-- end kanan --}}
    </div>{{-- end two-col --}}
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({
        icon: 'success', title: 'Berhasil!',
        text: @json(session('success')),
        timer: 2800, showConfirmButton: false,
        toast: true, position: 'top-end'
    });
    @endif
    @if(session('error'))
    Swal.fire({
        icon: 'error', title: 'Gagal!',
        text: @json(session('error')),
        confirmButtonColor: '#1f63db'
    });
    @endif

    function confirmDelete() {
        Swal.fire({
            title: 'Hapus Laporan?',
            html: `Laporan tanggal <strong>{{ $laporanHarianPiket->tanggal->format('d M Y') }}</strong> akan dihapus permanen.`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) document.getElementById('delForm').submit(); });
    }
</script>
</x-app-layout>