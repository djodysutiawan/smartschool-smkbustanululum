<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=DM+Sans:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap');
    :root{
        --brand:#7c3aed;--brand-50:#faf5ff;--brand-100:#ede9fe;--brand-600:#7c3aed;--brand-700:#6d28d9;--brand-800:#5b21b6;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:14px;--radius-sm:9px;
        --shadow-sm:0 1px 3px rgba(0,0,0,.06),0 1px 2px rgba(0,0,0,.04);
        --shadow:0 4px 16px rgba(0,0,0,.07);
        --ringan-bg:#dbeafe;--ringan-text:#1d4ed8;--ringan-border:#bfdbfe;
        --sedang-bg:#fef3c7;--sedang-text:#92400e;--sedang-border:#fde68a;
        --berat-bg:#fee2e2;--berat-text:#dc2626;--berat-border:#fecaca;
        --selesai-bg:#dcfce7;--selesai-text:#15803d;--selesai-border:#bbf7d0;
        --proses-bg:#fef3c7;--proses-text:#92400e;--proses-border:#fde68a;
        --banding-bg:#ede9fe;--banding-text:#6d28d9;--banding-border:#c4b5fd;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    .page{padding:28px 28px 72px;max-width:1440px;margin:0 auto;font-family:'DM Sans',sans-serif}
    .page-header{margin-bottom:24px}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:21px;font-weight:800;color:var(--text);letter-spacing:-.02em}
    .page-sub{font-size:13px;color:var(--text3);margin-top:4px}

    .anak-selector{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:22px}
    .anak-chip{display:inline-flex;align-items:center;gap:8px;padding:8px 16px;border-radius:99px;border:1.5px solid var(--border);background:var(--surface);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);text-decoration:none;transition:all .18s;box-shadow:var(--shadow-sm)}
    .anak-chip:hover{border-color:var(--brand-600);color:var(--brand-700)}
    .anak-chip.active{background:var(--brand-700);border-color:var(--brand-700);color:#fff;box-shadow:0 4px 12px rgba(109,40,217,.35)}
    .anak-avatar{width:24px;height:24px;border-radius:50%;background:var(--brand-100);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:var(--brand-700);flex-shrink:0}
    .anak-chip.active .anak-avatar{background:rgba(255,255,255,.25);color:#fff}

    .nav-tabs{display:flex;gap:2px;background:var(--surface3);padding:4px;border-radius:10px;margin-bottom:22px;width:fit-content}
    .nav-tab{display:inline-flex;align-items:center;gap:7px;padding:8px 16px;border-radius:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);text-decoration:none;transition:all .18s}
    .nav-tab:hover{color:var(--text)}
    .nav-tab.active{background:var(--surface);color:var(--brand-700);box-shadow:var(--shadow-sm);font-weight:700}

    /* Alert banner */
    .alert-banner{border-radius:var(--radius);padding:18px 22px;margin-bottom:20px;display:flex;align-items:flex-start;gap:14px;border:1.5px solid}
    .alert-success{background:var(--selesai-bg);border-color:var(--selesai-border)}
    .alert-warning{background:var(--proses-bg);border-color:var(--proses-border)}
    .alert-danger{background:var(--berat-bg);border-color:var(--berat-border)}
    .alert-icon{font-size:22px;flex-shrink:0;line-height:1}
    .alert-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text);margin-bottom:3px}
    .alert-sub{font-size:13px;color:var(--text2);line-height:1.5}

    /* Stats bar */
    .stats-bar{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .stat-mini{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 18px;box-shadow:var(--shadow-sm)}
    .stat-mini-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:28px;font-weight:800;color:var(--text);line-height:1}
    .stat-mini-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;margin-top:4px}

    /* Cards list */
    .section-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:8px}
    .section-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text)}
    .section-sub{font-size:12.5px;color:var(--text3);margin-top:1px}
    .badge-count{display:inline-flex;align-items:center;justify-content:center;min-width:24px;height:24px;padding:0 7px;border-radius:99px;background:var(--berat-bg);color:var(--berat-text);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;border:1px solid var(--berat-border)}

    .violations-list{display:flex;flex-direction:column;gap:10px;margin-bottom:28px}
    .violation-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:18px 20px;box-shadow:var(--shadow-sm);transition:box-shadow .18s;display:flex;gap:16px;align-items:flex-start}
    .violation-card:hover{box-shadow:var(--shadow)}
    .violation-card.level-berat{border-left:4px solid var(--berat-text)}
    .violation-card.level-sedang{border-left:4px solid #f59e0b}
    .violation-card.level-ringan{border-left:4px solid var(--ringan-text)}

    .vc-icon{width:46px;height:46px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:20px;flex-shrink:0}
    .vc-body{flex:1;min-width:0}
    .vc-top{display:flex;align-items:center;gap:8px;flex-wrap:wrap;margin-bottom:6px}
    .vc-kategori{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text)}
    .vc-meta{display:flex;gap:12px;flex-wrap:wrap;align-items:center;margin-top:2px}
    .vc-date{font-size:12.5px;color:var(--text3);display:flex;align-items:center;gap:5px}
    .vc-deskripsi{font-size:13px;color:var(--text2);margin-top:8px;line-height:1.55;padding:10px 14px;background:var(--surface2);border-radius:8px;border:1px solid var(--border)}
    .vc-poin{display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:28px;padding:0 10px;border-radius:7px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:800;border:1.5px solid;flex-shrink:0}
    .poin-ringan{background:var(--ringan-bg);color:var(--ringan-text);border-color:var(--ringan-border)}
    .poin-sedang{background:var(--sedang-bg);color:var(--sedang-text);border-color:var(--sedang-border)}
    .poin-berat{background:var(--berat-bg);color:var(--berat-text);border-color:var(--berat-border)}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;border:1px solid}
    .b-ringan{background:var(--ringan-bg);color:var(--ringan-text);border-color:var(--ringan-border)}
    .b-sedang{background:var(--sedang-bg);color:var(--sedang-text);border-color:var(--sedang-border)}
    .b-berat{background:var(--berat-bg);color:var(--berat-text);border-color:var(--berat-border)}
    .b-selesai{background:var(--selesai-bg);color:var(--selesai-text);border-color:var(--selesai-border)}
    .b-banding{background:var(--banding-bg);color:var(--banding-text);border-color:var(--banding-border)}
    .b-pending,.b-diproses{background:var(--proses-bg);color:var(--proses-text);border-color:var(--proses-border)}
    .b-pulse{animation:pulse 2s cubic-bezier(.4,0,.6,1) infinite}
    @keyframes pulse{0%,100%{opacity:1}50%{opacity:.6}}

    /* Recent selesai */
    .recent-list{display:flex;flex-direction:column;gap:8px}
    .recent-item{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius-sm);padding:14px 16px;display:flex;align-items:center;gap:12px;box-shadow:var(--shadow-sm)}
    .recent-icon{width:34px;height:34px;border-radius:9px;background:var(--selesai-bg);display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}
    .recent-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .recent-sub{font-size:12px;color:var(--text3);margin-top:2px}
    .recent-check{margin-left:auto;color:var(--selesai-text);flex-shrink:0}

    /* Empty */
    .empty-state{padding:56px 24px;text-align:center}
    .empty-icon{font-size:48px;margin-bottom:14px;display:block}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:16px;color:var(--text);margin-bottom:6px}
    .empty-sub{font-size:13.5px;color:var(--text3);max-width:340px;margin:0 auto;line-height:1.6}

    .divider{border:none;border-top:1.5px solid var(--border);margin:28px 0}

    @media(max-width:900px){.stats-bar{grid-template-columns:1fr 1fr}}
    @media(max-width:600px){.stats-bar{grid-template-columns:1fr 1fr}.page{padding:16px 14px}.violation-card{flex-direction:column;gap:10px}}
</style>

<div class="page">

    <div class="page-header">
        <h1 class="page-title">Status Kedisiplinan</h1>
        <p class="page-sub">Pelanggaran aktif dan status terkini — {{ $anak->nama_lengkap }}</p>
    </div>

    {{-- Nav tabs --}}
    <div class="nav-tabs">
        <a href="{{ route('ortu.kedisiplinan.riwayat', array_filter(['siswa_id' => $anak->id])) }}" class="nav-tab">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            Riwayat
        </a>
        <a href="{{ route('ortu.kedisiplinan.total-poin', array_filter(['siswa_id' => $anak->id])) }}" class="nav-tab">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
            Total Poin
        </a>
        <a href="{{ route('ortu.kedisiplinan.status', array_filter(['siswa_id' => $anak->id])) }}" class="nav-tab active">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
            Status Aktif
        </a>
    </div>

    {{-- Selector anak --}}
    @if($anakList->count() > 1)
    <div class="anak-selector">
        @foreach($anakList as $a)
        <a href="{{ route('ortu.kedisiplinan.status', array_filter(['siswa_id' => $a->id])) }}"
           class="anak-chip {{ $anak->id === $a->id ? 'active' : '' }}">
            <div class="anak-avatar">{{ strtoupper(mb_substr($a->nama_lengkap, 0, 1)) }}</div>
            {{ $a->nama_lengkap }}
            @if($a->kelas)<span style="font-size:11px;opacity:.7">· {{ $a->kelas->nama_kelas }}</span>@endif
        </a>
        @endforeach
    </div>
    @endif

    {{-- Alert status umum --}}
    @if($pelanggaranAktif->isEmpty())
    <div class="alert-banner alert-success">
        <span class="alert-icon">✅</span>
        <div>
            <p class="alert-title">Tidak ada pelanggaran aktif</p>
            <p class="alert-sub">{{ $anak->nama_lengkap }} saat ini tidak memiliki catatan pelanggaran yang sedang diproses. Pertahankan terus perilaku positifnya!</p>
        </div>
    </div>
    @elseif($pelanggaranAktif->contains(fn($p) => $p->kategori?->tingkat === 'berat'))
    <div class="alert-banner alert-danger">
        <span class="alert-icon">⚠️</span>
        <div>
            <p class="alert-title">Terdapat pelanggaran berat yang belum selesai</p>
            <p class="alert-sub">Mohon segera menghubungi pihak sekolah untuk menindaklanjuti pelanggaran yang masih aktif dan belum diselesaikan.</p>
        </div>
    </div>
    @else
    <div class="alert-banner alert-warning">
        <span class="alert-icon">📋</span>
        <div>
            <p class="alert-title">Ada {{ $pelanggaranAktif->count() }} pelanggaran yang sedang diproses</p>
            <p class="alert-sub">Pantau perkembangan proses penanganan pelanggaran di bawah ini. Hubungi guru BK jika ada pertanyaan.</p>
        </div>
    </div>
    @endif

    {{-- Stats bar --}}
    @php
        $jmlPending  = $statsStatus[\App\Models\Pelanggaran::STATUS_PENDING]  ?? 0;
        $jmlDiproses = $statsStatus[\App\Models\Pelanggaran::STATUS_DIPROSES] ?? 0;
        $jmlBanding  = $statsStatus[\App\Models\Pelanggaran::STATUS_BANDING]  ?? 0;
        $jmlSelesai  = $statsStatus[\App\Models\Pelanggaran::STATUS_SELESAI]  ?? 0;
    @endphp
    <div class="stats-bar">
        <div class="stat-mini">
            <p class="stat-mini-val" style="color:var(--berat-text)">{{ $pelanggaranAktif->count() }}</p>
            <p class="stat-mini-label">Aktif / Diproses</p>
        </div>
        <div class="stat-mini">
            <p class="stat-mini-val" style="color:var(--brand-700)">{{ $totalPoinTahunIni }}</p>
            <p class="stat-mini-label">Poin Tahun Ini</p>
        </div>
        <div class="stat-mini">
            <p class="stat-mini-val" style="color:var(--selesai-text)">{{ $jmlSelesai }}</p>
            <p class="stat-mini-label">Selesai Tahun Ini</p>
        </div>
        <div class="stat-mini">
            <p class="stat-mini-val" style="color:var(--banding-text)">{{ $jmlBanding }}</p>
            <p class="stat-mini-label">Dalam Banding</p>
        </div>
    </div>

    {{-- Daftar pelanggaran aktif --}}
    <div class="section-header">
        <div>
            <p class="section-title">
                Pelanggaran Aktif
                @if($pelanggaranAktif->isNotEmpty())
                <span class="badge-count">{{ $pelanggaranAktif->count() }}</span>
                @endif
            </p>
            <p class="section-sub">Pending, sedang diproses, atau dalam banding</p>
        </div>
        <a href="{{ route('ortu.kedisiplinan.riwayat', array_filter(['siswa_id' => $anak->id])) }}"
           style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--brand-700);text-decoration:none;display:flex;align-items:center;gap:5px">
            Lihat Semua
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="5" y1="12" x2="19" y2="12"/><polyline points="12 5 19 12 12 19"/></svg>
        </a>
    </div>

    @if($pelanggaranAktif->isNotEmpty())
    <div class="violations-list">
        @foreach($pelanggaranAktif as $p)
        @php
            $tingkat    = $p->kategori?->tingkat ?? 'ringan';
            $poinTampil = $p->poin ?? $p->kategori?->poin_default ?? 0;
            $ikon       = match($tingkat) { 'berat'=>'🚨','sedang'=>'⚡', default=>'💬' };
            $ikonBg     = match($tingkat) { 'berat'=>'var(--berat-bg)','sedang'=>'var(--sedang-bg)', default=>'var(--ringan-bg)' };
            $statusLabel = match($p->status) {
                \App\Models\Pelanggaran::STATUS_DIPROSES => 'Diproses',
                \App\Models\Pelanggaran::STATUS_BANDING  => 'Banding',
                default                                   => 'Pending',
            };
            $statusClass = match($p->status) {
                \App\Models\Pelanggaran::STATUS_BANDING => 'b-banding',
                \App\Models\Pelanggaran::STATUS_DIPROSES => 'b-diproses',
                default => 'b-pending',
            };
        @endphp
        <div class="violation-card level-{{ $tingkat }}">
            <div class="vc-icon" style="background:{{ $ikonBg }}">{{ $ikon }}</div>
            <div class="vc-body">
                <div class="vc-top">
                    <span class="vc-kategori">{{ $p->kategori?->nama ?? 'Tidak Diketahui' }}</span>
                    <span class="badge b-{{ $tingkat }}">{{ ucfirst($tingkat) }}</span>
                    <span class="badge {{ $statusClass }} b-pulse">{{ $statusLabel }}</span>
                </div>
                <div class="vc-meta">
                    <span class="vc-date">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        {{ $p->tanggal->translatedFormat('d M Y') }}
                        <span style="opacity:.6">({{ $p->tanggal->diffForHumans() }})</span>
                    </span>
                    @if($p->dicatatOleh)
                    <span class="vc-date">
                        <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"/><path d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        {{ $p->dicatatOleh->name }}
                    </span>
                    @endif
                </div>
                @if($p->deskripsi)
                <p class="vc-deskripsi">{{ $p->deskripsi }}</p>
                @endif
            </div>
            <span class="vc-poin poin-{{ $tingkat }}">{{ $poinTampil }}</span>
        </div>
        @endforeach
    </div>
    @else
    <div class="empty-state" style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);margin-bottom:28px">
        <span class="empty-icon">🌟</span>
        <p class="empty-title">Tidak ada pelanggaran aktif</p>
        <p class="empty-sub">Semua pelanggaran sudah ditangani atau belum ada catatan baru.</p>
    </div>
    @endif

    {{-- Riwayat selesai 30 hari terakhir --}}
    @if($recentSelesai->isNotEmpty())
    <hr class="divider">
    <div class="section-header" style="margin-bottom:12px">
        <div>
            <p class="section-title">Baru Diselesaikan</p>
            <p class="section-sub">Pelanggaran yang ditangani dalam 30 hari terakhir</p>
        </div>
    </div>
    <div class="recent-list">
        @foreach($recentSelesai as $p)
        @php
            $poinTampil = $p->poin ?? $p->kategori?->poin_default ?? 0;
            $selesaiPada = $p->diselesaikan_pada ?? $p->updated_at;
        @endphp
        <div class="recent-item">
            <div class="recent-icon">✅</div>
            <div style="min-width:0;flex:1">
                <p class="recent-name">{{ $p->kategori?->nama ?? '—' }}</p>
                <p class="recent-sub">
                    {{ $p->tanggal->translatedFormat('d M Y') }}
                    @if($selesaiPada)
                        · Selesai {{ $selesaiPada->diffForHumans() }}
                    @endif
                    · {{ $poinTampil }} poin
                </p>
            </div>
            <span class="badge b-selesai recent-check">Selesai</span>
        </div>
        @endforeach
    </div>
    @endif

</div>
</x-app-layout>