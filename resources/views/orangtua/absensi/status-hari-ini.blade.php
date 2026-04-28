<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root{
        --brand:#0f766e;--brand-50:#f0fdfa;--brand-100:#ccfbf1;--brand-200:#99f6e4;--brand-600:#0d9488;--brand-700:#0f766e;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:12px;--radius-sm:8px;
        --hadir:#dcfce7;--hadir-text:#15803d;--hadir-border:#bbf7d0;
        --telat:#fff3cd;--telat-text:#a16207;--telat-border:#fde68a;
        --izin:#dbeafe;--izin-text:#1d4ed8;--izin-border:#bfdbfe;
        --sakit:#fce7f3;--sakit-text:#be185d;--sakit-border:#fbcfe8;
        --alfa:#fee2e2;--alfa-text:#dc2626;--alfa-border:#fecaca;
    }
    *{box-sizing:border-box}
    .page{padding:28px 28px 60px;max-width:1400px;margin:0 auto}
    .page-header{margin-bottom:24px}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:13px;color:var(--text3);margin-top:3px;font-family:'DM Sans',sans-serif}

    /* Selector anak */
    .anak-selector{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:24px}
    .anak-chip{display:inline-flex;align-items:center;gap:8px;padding:8px 16px;border-radius:99px;border:1.5px solid var(--border);background:var(--surface);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2);text-decoration:none;transition:all .15s;cursor:pointer}
    .anak-chip:hover{border-color:var(--brand-600);color:var(--brand-700)}
    .anak-chip.active{background:var(--brand-700);border-color:var(--brand-700);color:#fff}
    .anak-avatar{width:24px;height:24px;border-radius:50%;background:var(--brand-100);display:flex;align-items:center;justify-content:center;font-size:10px;font-weight:800;color:var(--brand-700)}
    .anak-chip.active .anak-avatar{background:rgba(255,255,255,.25);color:#fff}

    /* Hero card */
    .hero-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px}
    .hero-card{border-radius:var(--radius);padding:24px 28px;position:relative;overflow:hidden}
    .hero-card-hari{background:linear-gradient(135deg,var(--brand-700) 0%,#0d9488 100%);color:#fff}
    .hero-card-status{background:var(--surface);border:1px solid var(--border)}
    .hc-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;opacity:.75;letter-spacing:.07em;text-transform:uppercase;margin-bottom:8px}
    .hc-label-dark{color:var(--text3);opacity:1}
    .hc-value{font-family:'Plus Jakarta Sans',sans-serif;font-size:28px;font-weight:800;line-height:1.1}
    .hc-sub{font-size:13px;opacity:.8;margin-top:6px;font-family:'DM Sans',sans-serif}
    .hc-sub-dark{color:var(--text2);opacity:1}
    .hero-deco{position:absolute;right:-20px;bottom:-20px;width:120px;height:120px;border-radius:50%;background:rgba(255,255,255,.07)}

    /* Status badge besar */
    .status-display{display:flex;flex-direction:column;align-items:center;justify-content:center;min-height:120px;gap:10px}
    .status-icon-big{width:64px;height:64px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:26px}
    .status-label-big{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800}
    .status-time{font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text3)}

    .s-hadir .status-icon-big{background:var(--hadir)}
    .s-hadir .status-label-big{color:var(--hadir-text)}
    .s-telat .status-icon-big{background:var(--telat)}
    .s-telat .status-label-big{color:var(--telat-text)}
    .s-izin .status-icon-big{background:var(--izin)}
    .s-izin .status-label-big{color:var(--izin-text)}
    .s-sakit .status-icon-big{background:var(--sakit)}
    .s-sakit .status-label-big{color:var(--sakit-text)}
    .s-alfa .status-icon-big{background:var(--alfa)}
    .s-alfa .status-label-big{color:var(--alfa-text)}
    .s-belum .status-icon-big{background:var(--surface3)}
    .s-belum .status-label-big{color:var(--text3)}

    /* Detail card */
    .detail-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .detail-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .detail-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .detail-body{padding:0}
    .detail-row{display:flex;align-items:flex-start;justify-content:space-between;padding:13px 20px;border-bottom:1px solid var(--border)}
    .detail-row:last-child{border-bottom:none}
    .dr-label{font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text3);min-width:120px}
    .dr-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text);text-align:right}

    /* Info kosong */
    .empty-day{background:var(--surface2);border:1.5px dashed var(--border2);border-radius:var(--radius);padding:48px 20px;text-align:center}
    .empty-day-icon{font-size:40px;margin-bottom:12px}
    .empty-day-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:4px}
    .empty-day-sub{font-size:13px;color:var(--text3);font-family:'DM Sans',sans-serif}

    /* Status badge inline */
    .badge{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700}
    .b-hadir{background:var(--hadir);color:var(--hadir-text)}
    .b-telat{background:var(--telat);color:var(--telat-text)}
    .b-izin{background:var(--izin);color:var(--izin-text)}
    .b-sakit{background:var(--sakit);color:var(--sakit-text)}
    .b-alfa{background:var(--alfa);color:var(--alfa-text)}

    /* Quick nav */
    .quick-nav{display:flex;gap:10px;flex-wrap:wrap;margin-top:20px}
    .qn-btn{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;text-decoration:none;transition:filter .15s;border:none;cursor:pointer}
    .qn-btn:hover{filter:brightness(.93)}
    .qn-primary{background:var(--brand-700);color:#fff}
    .qn-outline{background:var(--surface);color:var(--text2);border:1.5px solid var(--border)}
    .qn-outline:hover{background:var(--surface2);filter:none}

    @media(max-width:640px){.page{padding:16px}.hero-grid{grid-template-columns:1fr}}
</style>

<div class="page">
    <div class="page-header">
        <h1 class="page-title">Status Kehadiran Hari Ini</h1>
        <p class="page-sub">Pantau kehadiran anak Anda secara real-time</p>
    </div>

    {{-- Selector anak jika lebih dari satu --}}
    @if($anakList->count() > 1)
    <div class="anak-selector">
        @foreach($anakList as $a)
        <a href="{{ route('ortu.absensi.status-hari-ini', ['siswa_id' => $a->id]) }}"
           class="anak-chip {{ $anak->id === $a->id ? 'active' : '' }}">
            <div class="anak-avatar">{{ strtoupper(substr($a->nama_lengkap, 0, 1)) }}</div>
            {{ $a->nama_lengkap }}
        </a>
        @endforeach
    </div>
    @endif

    @php
        $statusKey = $absensiHariIni?->status ?? 'belum';
        $statusEmoji = [
            'hadir' => '✅', 'telat' => '⏰',
            'izin'  => '📋', 'sakit' => '🤒',
            'alfa'  => '❌', 'belum' => '❓',
        ][$statusKey] ?? '❓';
        $statusLabel = [
            'hadir' => 'Hadir',   'telat' => 'Telat',
            'izin'  => 'Izin',    'sakit' => 'Sakit',
            'alfa'  => 'Alfa',    'belum' => 'Belum Tercatat',
        ][$statusKey] ?? '—';
    @endphp

    <div class="hero-grid">
        {{-- Card tanggal --}}
        <div class="hero-card hero-card-hari">
            <div class="hero-deco"></div>
            <p class="hc-label">Hari Ini</p>
            <p class="hc-value">{{ now()->translatedFormat('l') }}</p>
            <p class="hc-sub">{{ now()->translatedFormat('d F Y') }}</p>
        </div>

        {{-- Card status --}}
        <div class="hero-card hero-card-status">
            <p class="hc-label hc-label-dark">Status {{ $anak->nama_lengkap }}</p>
            <div class="status-display s-{{ $statusKey }}">
                <div class="status-icon-big">{{ $statusEmoji }}</div>
                <div class="status-label-big">{{ $statusLabel }}</div>
                @if($absensiHariIni?->jam_masuk)
                    <div class="status-time">Jam masuk: {{ \Carbon\Carbon::parse($absensiHariIni->jam_masuk)->format('H:i') }}</div>
                @endif
            </div>
        </div>
    </div>

    {{-- Detail absensi jika ada --}}
    @if($absensiHariIni)
    <div class="detail-card">
        <div class="detail-header">
            <svg width="14" height="14" fill="none" stroke="#64748b" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <span class="detail-title">Detail Absensi</span>
        </div>
        <div class="detail-body">
            <div class="detail-row">
                <span class="dr-label">Status</span>
                <span class="dr-val">
                    <span class="badge b-{{ $absensiHariIni->status }}">{{ $statusLabel }}</span>
                </span>
            </div>
            @if($absensiHariIni->jam_masuk)
            <div class="detail-row">
                <span class="dr-label">Jam Masuk</span>
                <span class="dr-val">{{ \Carbon\Carbon::parse($absensiHariIni->jam_masuk)->format('H:i') }} WIB</span>
            </div>
            @endif
            @if($absensiHariIni->jam_keluar)
            <div class="detail-row">
                <span class="dr-label">Jam Keluar</span>
                <span class="dr-val">{{ \Carbon\Carbon::parse($absensiHariIni->jam_keluar)->format('H:i') }} WIB</span>
            </div>
            @endif
            @if($absensiHariIni->metode)
            <div class="detail-row">
                <span class="dr-label">Metode</span>
                <span class="dr-val">{{ ucfirst($absensiHariIni->metode) }}</span>
            </div>
            @endif
            @if($absensiHariIni->jadwalPelajaran?->mataPelajaran)
            <div class="detail-row">
                <span class="dr-label">Mata Pelajaran</span>
                <span class="dr-val">{{ $absensiHariIni->jadwalPelajaran->mataPelajaran->nama_mapel }}</span>
            </div>
            @endif
            @if($absensiHariIni->dicatatOleh)
            <div class="detail-row">
                <span class="dr-label">Dicatat Oleh</span>
                <span class="dr-val">{{ $absensiHariIni->dicatatOleh->name }}</span>
            </div>
            @endif
            @if($absensiHariIni->keterangan)
            <div class="detail-row">
                <span class="dr-label">Keterangan</span>
                <span class="dr-val" style="max-width:260px;word-break:break-word;text-align:right">{{ $absensiHariIni->keterangan }}</span>
            </div>
            @endif
            @if($absensiHariIni->path_surat_izin)
            <div class="detail-row">
                <span class="dr-label">Surat Izin</span>
                <a href="{{ $absensiHariIni->surat_izin_url }}" target="_blank" class="dr-val" style="color:var(--brand-700);font-weight:700;text-decoration:none">
                    Lihat Surat →
                </a>
            </div>
            @endif
        </div>
    </div>
    @else
    <div class="empty-day">
        <div class="empty-day-icon">📅</div>
        <p class="empty-day-title">Belum ada data absensi hari ini</p>
        <p class="empty-day-sub">Data kehadiran {{ $anak->nama_lengkap }} pada hari {{ now()->translatedFormat('l, d F Y') }} belum tercatat.</p>
    </div>
    @endif

    <div class="quick-nav">
        <a href="{{ route('ortu.absensi.riwayat', ['siswa_id' => $anak->id]) }}" class="qn-btn qn-primary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
            Lihat Riwayat Kehadiran
        </a>
        <a href="{{ route('ortu.absensi.rekap', ['siswa_id' => $anak->id]) }}" class="qn-btn qn-outline">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Rekap Bulanan
        </a>
    </div>
</div>
</x-app-layout>