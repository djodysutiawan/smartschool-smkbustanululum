<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root{
        --brand:#0f766e;--brand-50:#f0fdfa;--brand-100:#ccfbf1;--brand-200:#99f6e4;--brand-600:#0d9488;--brand-700:#0f766e;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:12px;--radius-sm:8px;
        --masuk:#dcfce7;--masuk-text:#15803d;--masuk-border:#bbf7d0;
        --pulang:#dbeafe;--pulang-text:#1d4ed8;--pulang-border:#bfdbfe;
        --belum:#f1f5f9;--belum-text:#94a3b8;--belum-border:#e2e8f0;
    }
    *{box-sizing:border-box}
    .page{padding:28px 28px 60px;max-width:1200px;margin:0 auto}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:13px;color:var(--text3);margin-top:3px;font-family:'DM Sans',sans-serif}

    /* Anak selector */
    .anak-selector{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:24px}
    .anak-chip{display:inline-flex;align-items:center;gap:8px;padding:8px 16px;border-radius:99px;border:1.5px solid var(--border);background:var(--surface);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);text-decoration:none;transition:all .15s}
    .anak-chip:hover{border-color:var(--brand-600);color:var(--brand-700)}
    .anak-chip.active{background:var(--brand-700);border-color:var(--brand-700);color:#fff}
    .anak-avatar{width:24px;height:24px;border-radius:50%;background:var(--brand-100);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:var(--brand-700)}
    .anak-chip.active .anak-avatar{background:rgba(255,255,255,.25);color:#fff}

    /* Hero date card */
    .hero-date{background:linear-gradient(135deg,var(--brand-700) 0%,#0d9488 100%);border-radius:var(--radius);padding:24px 28px;color:#fff;position:relative;overflow:hidden;margin-bottom:20px}
    .hero-date-deco{position:absolute;right:-30px;bottom:-30px;width:140px;height:140px;border-radius:50%;background:rgba(255,255,255,.07)}
    .hero-date-deco2{position:absolute;right:60px;bottom:-50px;width:100px;height:100px;border-radius:50%;background:rgba(255,255,255,.05)}
    .hd-top{display:flex;align-items:center;gap:10px;margin-bottom:4px}
    .hd-badge{background:rgba(255,255,255,.2);border-radius:99px;padding:3px 10px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.05em;text-transform:uppercase}
    .hd-hari{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;font-weight:800;line-height:1.1}
    .hd-tanggal{font-family:'DM Sans',sans-serif;font-size:14px;opacity:.8;margin-top:4px}
    .hd-anak{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;opacity:.7;margin-top:10px;display:flex;align-items:center;gap:6px}

    /* Scan cards grid */
    .scan-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px}

    .scan-card{border-radius:var(--radius);border:2px solid var(--border);background:var(--surface);padding:24px;display:flex;flex-direction:column;align-items:center;text-align:center;gap:12px;position:relative;overflow:hidden;transition:transform .15s,box-shadow .15s}
    .scan-card:hover{transform:translateY(-2px);box-shadow:0 8px 24px rgba(0,0,0,.06)}

    .scan-card.sudah-masuk{border-color:var(--masuk-border);background:linear-gradient(145deg,#fff 60%,#f0fdf4)}
    .scan-card.sudah-pulang{border-color:var(--pulang-border);background:linear-gradient(145deg,#fff 60%,#eff6ff)}
    .scan-card.belum{border-style:dashed;border-color:var(--belum-border);background:var(--surface2)}

    .scan-icon-wrap{width:72px;height:72px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:28px}
    .scan-card.sudah-masuk .scan-icon-wrap{background:var(--masuk)}
    .scan-card.sudah-pulang .scan-icon-wrap{background:var(--pulang)}
    .scan-card.belum .scan-icon-wrap{background:var(--belum)}

    .scan-type-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.07em;color:var(--text3)}
    .scan-status-text{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800}
    .scan-card.sudah-masuk .scan-status-text{color:var(--masuk-text)}
    .scan-card.sudah-pulang .scan-status-text{color:var(--pulang-text)}
    .scan-card.belum .scan-status-text{color:var(--belum-text)}

    .scan-time{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text2)}
    .scan-time strong{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);display:block;line-height:1.1;margin-top:2px}
    .scan-sesi{font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text3);margin-top:2px}
    .scan-method-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;background:var(--surface3);color:var(--text2)}

    /* Detail card */
    .section-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .section-header{padding:13px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .section-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .detail-row{display:flex;align-items:flex-start;justify-content:space-between;padding:12px 20px;border-bottom:1px solid var(--border)}
    .detail-row:last-child{border-bottom:none}
    .dr-label{font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text3)}
    .dr-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text);text-align:right}

    /* Timeline */
    .timeline{padding:20px;display:flex;flex-direction:column;gap:0}
    .tl-item{display:flex;gap:16px;position:relative}
    .tl-item:not(:last-child)::before{content:'';position:absolute;left:17px;top:36px;width:2px;bottom:-8px;background:var(--border)}
    .tl-dot{width:36px;height:36px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;position:relative;z-index:1}
    .tl-dot.masuk{background:var(--masuk);border:2px solid var(--masuk-border)}
    .tl-dot.pulang{background:var(--pulang);border:2px solid var(--pulang-border)}
    .tl-content{padding-bottom:20px;flex:1}
    .tl-time{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .tl-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text);margin-top:2px}
    .tl-sub{font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text3);margin-top:2px}
    .tl-status-chip{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;margin-top:4px}
    .chip-normal{background:#dcfce7;color:#15803d}
    .chip-manual{background:#fef3c7;color:#b45309}
    .chip-koreksi{background:#ede9fe;color:#7c3aed}

    /* Empty */
    .empty-box{background:var(--surface2);border:1.5px dashed var(--border2);border-radius:var(--radius);padding:48px 20px;text-align:center;margin-bottom:16px}
    .empty-icon{font-size:40px;margin-bottom:12px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:4px}
    .empty-sub{font-size:13px;color:var(--text3);font-family:'DM Sans',sans-serif;line-height:1.6}

    /* Quick nav */
    .quick-nav{display:flex;gap:10px;flex-wrap:wrap;margin-top:8px}
    .qn-btn{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;text-decoration:none;transition:filter .15s}
    .qn-btn:hover{filter:brightness(.93)}
    .qn-primary{background:var(--brand-700);color:#fff}
    .qn-outline{background:var(--surface);color:var(--text2);border:1.5px solid var(--border)}
    .qn-outline:hover{background:var(--surface2);filter:none}

    @media(max-width:640px){.page{padding:16px}.scan-grid{grid-template-columns:1fr}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Status Gerbang Hari Ini</h1>
            <p class="page-sub">Pantau scan masuk & pulang anak di gerbang sekolah</p>
        </div>
        <a href="{{ route('ortu.kehadiran-gerbang.riwayat', ['siswa_id' => $anak->id]) }}"
           style="display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);background:var(--surface2);color:var(--text2);border:1.5px solid var(--border);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;text-decoration:none">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            Riwayat Gerbang
        </a>
    </div>

    {{-- Selector anak --}}
    @if($anakList->count() > 1)
    <div class="anak-selector">
        @foreach($anakList as $a)
        <a href="{{ route('ortu.kehadiran-gerbang.status-hari-ini', ['siswa_id' => $a->id]) }}"
           class="anak-chip {{ $anak->id === $a->id ? 'active' : '' }}">
            <div class="anak-avatar">{{ strtoupper(substr($a->nama_lengkap, 0, 1)) }}</div>
            {{ $a->nama_lengkap }}
        </a>
        @endforeach
    </div>
    @endif

    {{-- Hero tanggal --}}
    <div class="hero-date">
        <div class="hero-date-deco"></div>
        <div class="hero-date-deco2"></div>
        <div class="hd-top">
            <span class="hd-badge">Live</span>
        </div>
        <p class="hd-hari">{{ now()->translatedFormat('l') }}</p>
        <p class="hd-tanggal">{{ now()->translatedFormat('d F Y') }}</p>
        <p class="hd-anak">
            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            {{ $anak->nama_lengkap }}
            @if($anak->kelas)
                &mdash; Kelas {{ $anak->kelas->nama_kelas ?? $anak->kelas->nama }}
            @endif
        </p>
    </div>

    {{-- Scan cards --}}
    <div class="scan-grid">
        {{-- Scan Masuk --}}
        @if($scanMasuk)
        <div class="scan-card sudah-masuk">
            <div class="scan-icon-wrap">🟢</div>
            <div class="scan-type-label">Scan Masuk</div>
            <div class="scan-status-text">Sudah Masuk</div>
            <div class="scan-time">
                Pukul
                <strong>{{ $scanMasuk->waktu_scan->format('H:i') }}</strong>
                <span>WIB</span>
            </div>
            @if($scanMasuk->sesiGerbang)
                <div class="scan-sesi">Sesi: {{ $scanMasuk->sesiGerbang->nama ?? 'Sesi Gerbang' }}</div>
            @endif
            @if($scanMasuk->is_manual)
                <span class="scan-method-badge">📝 Input Manual</span>
            @elseif($scanMasuk->status === 'koreksi')
                <span class="scan-method-badge">✏️ Dikoreksi</span>
            @else
                <span class="scan-method-badge">📡 Scan Barcode</span>
            @endif
        </div>
        @else
        <div class="scan-card belum">
            <div class="scan-icon-wrap">⏳</div>
            <div class="scan-type-label">Scan Masuk</div>
            <div class="scan-status-text">Belum Masuk</div>
            <p style="font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text3);line-height:1.5">
                {{ $anak->nama_lengkap }} belum melakukan<br>scan masuk hari ini.
            </p>
        </div>
        @endif

        {{-- Scan Pulang --}}
        @if($scanPulang)
        <div class="scan-card sudah-pulang">
            <div class="scan-icon-wrap">🔵</div>
            <div class="scan-type-label">Scan Pulang</div>
            <div class="scan-status-text">Sudah Pulang</div>
            <div class="scan-time">
                Pukul
                <strong>{{ $scanPulang->waktu_scan->format('H:i') }}</strong>
                <span>WIB</span>
            </div>
            @if($scanPulang->sesiGerbang)
                <div class="scan-sesi">Sesi: {{ $scanPulang->sesiGerbang->nama ?? 'Sesi Gerbang' }}</div>
            @endif
            @if($scanPulang->is_manual)
                <span class="scan-method-badge">📝 Input Manual</span>
            @elseif($scanPulang->status === 'koreksi')
                <span class="scan-method-badge">✏️ Dikoreksi</span>
            @else
                <span class="scan-method-badge">📡 Scan Barcode</span>
            @endif
        </div>
        @else
        <div class="scan-card belum">
            <div class="scan-icon-wrap">⏳</div>
            <div class="scan-type-label">Scan Pulang</div>
            <div class="scan-status-text">Belum Pulang</div>
            <p style="font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text3);line-height:1.5">
                @if($scanMasuk)
                    {{ $anak->nama_lengkap }} masih<br>berada di sekolah.
                @else
                    {{ $anak->nama_lengkap }} belum melakukan<br>scan pulang hari ini.
                @endif
            </p>
        </div>
        @endif
    </div>

    {{-- Timeline semua scan hari ini --}}
    @if($scanHariIni->isNotEmpty())
    <div class="section-card">
        <div class="section-header">
            <svg width="14" height="14" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            <span class="section-title">Log Scan Hari Ini ({{ $scanHariIni->count() }} catatan)</span>
        </div>
        <div class="timeline">
            @foreach($scanHariIni as $scan)
            <div class="tl-item">
                <div class="tl-dot {{ $scan->tipe }}">
                    {{ $scan->tipe === 'masuk' ? '🟢' : '🔵' }}
                </div>
                <div class="tl-content">
                    <div class="tl-time">{{ $scan->waktu_scan->format('H:i:s') }}</div>
                    <div class="tl-title">
                        {{ $scan->tipe === 'masuk' ? 'Scan Masuk' : 'Scan Pulang' }}
                        @if($scan->sesiGerbang)
                            &mdash; {{ $scan->sesiGerbang->nama ?? 'Sesi Gerbang' }}
                        @endif
                    </div>
                    @if($scan->catatan)
                        <div class="tl-sub">{{ $scan->catatan }}</div>
                    @endif
                    <span class="tl-status-chip chip-{{ $scan->status }}">
                        {{ $scan->label_status }}
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="empty-box">
        <div class="empty-icon">🏫</div>
        <p class="empty-title">Belum ada scan gerbang hari ini</p>
        <p class="empty-sub">
            Scan masuk/pulang {{ $anak->nama_lengkap }} pada<br>
            {{ now()->translatedFormat('l, d F Y') }} belum tercatat di sistem.
        </p>
    </div>
    @endif

    {{-- Quick navigation --}}
    <div class="quick-nav">
        <a href="{{ route('ortu.kehadiran-gerbang.riwayat', ['siswa_id' => $anak->id]) }}" class="qn-btn qn-primary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            Riwayat Gerbang
        </a>
        <a href="{{ route('ortu.kehadiran-gerbang.rekap', ['siswa_id' => $anak->id]) }}" class="qn-btn qn-outline">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Rekap Bulanan
        </a>
    </div>
</div>
</x-app-layout>