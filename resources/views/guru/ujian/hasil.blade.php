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

    /* ── Layout ────────────────────────────────────────────────────────────── */
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap}

    /* ── Breadcrumb ────────────────────────────────────────────────────────── */
    .breadcrumb{display:flex;align-items:center;gap:6px;margin-bottom:20px;font-size:12.5px;color:var(--text3);flex-wrap:wrap}
    .breadcrumb a{color:var(--text3);text-decoration:none;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;transition:color .15s}
    .breadcrumb a:hover{color:var(--text)}
    .breadcrumb-current{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text2)}

    /* ── Buttons ───────────────────────────────────────────────────────────── */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    /* ── Stats strip ───────────────────────────────────────────────────────── */
    .stats-strip{display:grid;grid-template-columns:repeat(6,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px;text-align:center;transition:box-shadow .2s}
    .stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:4px}
    .stat-val.green{color:#15803d}
    .stat-val.red{color:#dc2626}
    .stat-val.blue{color:var(--brand-600)}
    /* FIX: Tambah sub-label untuk konteks nilai persen lulus */
    .stat-sub{font-size:11px;color:var(--text3);margin-top:2px}

    /* ── Table ─────────────────────────────────────────────────────────────── */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:8px}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13.5px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    thead th.right{text-align:right}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:10px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    td.right{text-align:right}
    td.muted{color:var(--text3)}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)}

    /* ── Rank medals ───────────────────────────────────────────────────────── */
    .rank-medal{width:24px;height:24px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:800}
    /* FIX: rank-3 warna cokelat/bronze yang lebih sesuai (sebelumnya #7c2d12 di latar #fff0f0 terlalu kontras) */
    .rank-1{background:#fef3c7;color:#92400e}   /* emas */
    .rank-2{background:#f1f5f9;color:#475569}   /* perak */
    .rank-3{background:#fde8cc;color:#9a4c1e}   /* perunggu */

    /* ── Badges ────────────────────────────────────────────────────────────── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-lulus       { background:#dcfce7; color:#15803d; }
    .badge-lulus       .badge-dot { background:#15803d; }
    .badge-tidak-lulus { background:#fee2e2; color:#dc2626; }
    .badge-tidak-lulus .badge-dot { background:#dc2626; }

    /* ── Nilai bar ─────────────────────────────────────────────────────────── */
    .nilai-bar-wrap{display:flex;align-items:center;gap:8px;justify-content:flex-end}
    .nilai-bar{height:6px;border-radius:99px;background:var(--surface3);width:120px;flex-shrink:0;overflow:hidden}
    .nilai-bar-fill{height:100%;border-radius:99px;transition:width .3s}
    .nilai-bar-fill.lulus      { background:#15803d; }
    .nilai-bar-fill.tidak-lulus{ background:#dc2626; }
    .nilai-text{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:14px;min-width:36px;text-align:right}
    .nilai-text.lulus      { color:#15803d; }
    .nilai-text.tidak-lulus{ color:#dc2626; }

    /* ── KKM indicator ─────────────────────────────────────────────────────── */
    .kkm-badge{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:5px;background:#fef3c7;color:#92400e;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;margin-left:8px;vertical-align:middle}

    /* ── Empty state ───────────────────────────────────────────────────────── */
    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    @media(max-width:900px){
        .stats-strip{grid-template-columns:repeat(3,1fr)}
        .page{padding:16px}
        .header-actions{width:100%}
        .nilai-bar{width:72px}
    }
    @media(max-width:540px){
        .stats-strip{grid-template-columns:repeat(2,1fr)}
    }
</style>

<div class="page">

    {{-- ── Breadcrumb ──────────────────────────────────────────────────────── --}}
    <div class="breadcrumb">
        <a href="{{ route('guru.ujian.index') }}">Kelola Ujian</a>
        <span>›</span>
        {{-- FIX: Escaping judul aman karena Blade {{ }} sudah auto-escape --}}
        <a href="{{ route('guru.ujian.show', $ujian->id) }}">{{ $ujian->judul }}</a>
        <span>›</span>
        <span class="breadcrumb-current">Hasil Ujian</span>
    </div>

    {{-- ── Page Header ──────────────────────────────────────────────────────── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">
                Hasil Ujian: {{ $ujian->judul }}
                @if($ujian->nilai_kkm)
                    <span class="kkm-badge">KKM {{ $ujian->nilai_kkm }}</span>
                @endif
            </h1>
            <p class="page-sub">
                {{-- FIX: Semua relasi sudah di-eager-load di controller, ?? '—' untuk guard null --}}
                {{ $ujian->mataPelajaran->nama_mapel ?? '—' }}
                &middot; {{ $ujian->kelas->nama_kelas ?? '—' }}
                {{-- FIX: $ujian->tanggal mungkin sudah Carbon (tergantung model cast),
                     pakai \Carbon\Carbon::parse() untuk memastikan tidak error
                     jika cast tidak ada. --}}
                &middot; {{ \Carbon\Carbon::parse($ujian->tanggal)->translatedFormat('d F Y') }}
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.ujian.show', $ujian->id) }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Detail Ujian
            </a>
        </div>
    </div>

    {{-- ── Stats Strip ──────────────────────────────────────────────────────── --}}
    @php
        // FIX: Hitung persentase lulus sekali di sini untuk dipakai di stats dan sub-label
        $persenLulus = $stats['total_peserta'] > 0
            ? round($stats['lulus'] / $stats['total_peserta'] * 100, 1)
            : 0;
    @endphp
    <div class="stats-strip">
        <div class="stat-card">
            <p class="stat-label">Total Peserta</p>
            <p class="stat-val">{{ $stats['total_peserta'] }}</p>
            <p class="stat-sub">siswa</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Rata-rata Nilai</p>
            {{-- FIX: Format selalu 2 desimal agar konsisten, tampil 0.00 jika belum ada peserta --}}
            <p class="stat-val">{{ number_format($stats['rata_nilai'], 2) }}</p>
            <p class="stat-sub">dari 100</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Nilai Tertinggi</p>
            <p class="stat-val green">{{ $stats['nilai_tertinggi'] ?: '—' }}</p>
            <p class="stat-sub">&nbsp;</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Nilai Terendah</p>
            <p class="stat-val red">{{ $stats['nilai_terendah'] ?: '—' }}</p>
            <p class="stat-sub">&nbsp;</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Lulus</p>
            <p class="stat-val green">{{ $stats['lulus'] }}</p>
            <p class="stat-sub">{{ $persenLulus }}% peserta</p>
        </div>
        <div class="stat-card">
            <p class="stat-label">Tidak Lulus</p>
            <p class="stat-val red">{{ $stats['tidak_lulus'] }}</p>
            <p class="stat-sub">{{ $stats['total_peserta'] > 0 ? round(100 - $persenLulus, 1) : 0 }}% peserta</p>
        </div>
    </div>

    {{-- ── Tabel Hasil ──────────────────────────────────────────────────────── --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Rekap Nilai Siswa
                <span>— {{ $sesiList->count() }} peserta, diurutkan nilai tertinggi</span>
            </p>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th class="center" style="width:52px">Rank</th>
                        <th>Nama Siswa</th>
                        <th class="center">Status</th>
                        <th class="right" style="width:220px">Nilai Akhir</th>
                        <th class="center">Selesai Pada</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sesiList as $index => $sesi)
                    @php
                        $rank        = $index + 1;
                        // FIX: Cast lulus ke bool secara eksplisit di view
                        // agar konsisten apapun tipe yang dikembalikan DB (0/1/true/false)
                        $lulus       = (bool) $sesi->lulus;
                        $nilaiAkhir  = $sesi->nilai_akhir ?? 0;
                        // FIX: Clamp nilai 0–100 agar bar width tidak overflow
                        $barWidth    = min(100, max(0, (float) $nilaiAkhir));
                        $statusClass = $lulus ? 'lulus' : 'tidak-lulus';
                    @endphp
                    <tr>
                        {{-- Rank --}}
                        <td class="center">
                            @if($rank <= 3)
                                <span class="rank-medal rank-{{ $rank }}">{{ $rank }}</span>
                            @else
                                <span class="no-col">{{ $rank }}</span>
                            @endif
                        </td>

                        {{-- Nama Siswa --}}
                        <td>
                            <div style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)">
                                {{ $sesi->siswa->nama_lengkap ?? '—' }}
                            </div>
                            <div style="font-size:12px;color:var(--text3);margin-top:1px">
                                NIS: {{ $sesi->siswa->nis ?? '—' }}
                            </div>
                        </td>

                        {{-- Status Lulus --}}
                        <td class="center">
                            @if($lulus)
                                <span class="badge badge-lulus">
                                    <span class="badge-dot"></span>Lulus
                                </span>
                            @else
                                <span class="badge badge-tidak-lulus">
                                    <span class="badge-dot"></span>Tidak Lulus
                                </span>
                            @endif
                        </td>

                        {{-- Nilai dengan bar ─ FIX: bar width di-clamp, warna dari $statusClass --}}
                        <td class="right">
                            <div class="nilai-bar-wrap">
                                <div class="nilai-bar">
                                    <div class="nilai-bar-fill {{ $statusClass }}"
                                         style="width:{{ $barWidth }}%"></div>
                                </div>
                                <span class="nilai-text {{ $statusClass }}">
                                    {{ number_format((float) $nilaiAkhir, 0) }}
                                </span>
                            </div>
                        </td>

                        {{-- Waktu Selesai --}}
                        <td class="center muted" style="font-size:12.5px;white-space:nowrap">
                            {{-- FIX: Gunakan Carbon::parse() yang aman meski field belum di-cast --}}
                            {{ $sesi->selesai_pada
                                ? \Carbon\Carbon::parse($sesi->selesai_pada)->translatedFormat('d M Y, H:i')
                                : '—' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                                        <line x1="18" y1="20" x2="18" y2="10"/>
                                        <line x1="12" y1="20" x2="12" y2="4"/>
                                        <line x1="6" y1="20" x2="6" y2="14"/>
                                    </svg>
                                </div>
                                <p class="empty-title">Belum ada siswa yang menyelesaikan ujian</p>
                                <p class="empty-sub">Hasil akan muncul setelah siswa menyelesaikan ujian</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>{{-- /page --}}
</x-app-layout>