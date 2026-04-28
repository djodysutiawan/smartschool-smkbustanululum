<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --brand:#2563eb;--brand-50:#eff6ff;--brand-100:#dbeafe;--brand-700:#1d4ed8;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --green:#15803d;--green-bg:#f0fdf4;--green-border:#bbf7d0;
        --red:#dc2626;--red-bg:#fef2f2;--red-border:#fecaca;
        --yellow:#a16207;--yellow-bg:#fefce8;--yellow-border:#fde68a;
        --orange:#c2410c;--orange-bg:#fff7ed;
        --radius:12px;--radius-sm:8px;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    .page{padding:28px 28px 60px;max-width:1300px;margin:0 auto}
    .bc{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .bc a{color:var(--text3);text-decoration:none}.bc a:hover{color:var(--brand)}.bc-sep{color:var(--border)}.bc-cur{color:var(--text2)}
    /* ── Anak bar ── */
    .anak-bar{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;display:flex;align-items:center;gap:12px;margin-bottom:20px;flex-wrap:wrap}
    .anak-avatar{width:42px;height:42px;border-radius:50%;background:var(--brand-100);display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:15px;color:var(--brand-700);flex-shrink:0}
    .anak-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;color:var(--text)}
    .anak-meta{font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text3)}
    .anak-switch{margin-left:auto;display:flex;gap:8px;flex-wrap:wrap}
    .anak-btn{padding:5px 14px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;border:1.5px solid var(--border);background:var(--surface2);color:var(--text2);text-decoration:none;transition:all .15s}
    .anak-btn:hover,.anak-btn.active{background:var(--brand);border-color:var(--brand);color:#fff}
    /* ── Stat strip ── */
    .stat-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;display:flex;align-items:center;gap:14px}
    .stat-ic{width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .ic-blue{background:var(--brand-50)}.ic-green{background:var(--green-bg)}.ic-yellow{background:var(--yellow-bg)}.ic-purple{background:#faf5ff}
    .stat-lbl{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:3px}
    /* ── Progress bar keseluruhan ── */
    .progress-banner{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:18px 24px;margin-bottom:20px}
    .pb-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:10px}
    .pb-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .pb-pct{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--brand)}
    .prog-bg{width:100%;height:10px;border-radius:5px;background:var(--surface3);overflow:hidden}
    .prog-fill{height:100%;border-radius:5px;background:linear-gradient(90deg,#2563eb,#3b82f6);transition:width .4s}
    /* ── Tugas list ── */
    .tugas-list{display:flex;flex-direction:column;gap:12px}
    .tugas-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;transition:box-shadow .2s}
    .tugas-card:hover{box-shadow:0 4px 16px rgba(37,99,235,.08)}
    .tugas-card-inner{padding:18px 20px;display:flex;align-items:flex-start;gap:16px}
    .tugas-status-icon{width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:2px}
    .tsi-selesai{background:var(--green-bg)}
    .tsi-terlambat{background:var(--orange-bg)}
    .tsi-belum{background:var(--surface3)}
    .tsi-dinilai{background:var(--brand-50)}
    .tugas-content{flex:1;min-width:0}
    .tugas-judul{font-family:'Plus Jakarta Sans',sans-serif;font-size:14.5px;font-weight:700;color:var(--text);margin-bottom:4px}
    .tugas-meta{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:8px}
    .tugas-mapel{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--brand);text-transform:uppercase;letter-spacing:.04em}
    .tugas-guru{font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text3)}
    .tugas-deadline{font-family:'DM Sans',sans-serif;font-size:12.5px;display:flex;align-items:center;gap:4px}
    .deadline-ok{color:var(--green)}.deadline-warn{color:var(--yellow)}.deadline-over{color:var(--red)}
    .tugas-info-row{display:flex;align-items:center;gap:10px;flex-wrap:wrap}
    .tugas-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .tb-belum{background:var(--surface3);color:var(--text3)}
    .tb-dikumpulkan{background:var(--green-bg);color:var(--green)}
    .tb-terlambat{background:var(--orange-bg);color:var(--orange)}
    .tb-dinilai{background:var(--brand-50);color:var(--brand-700)}
    .tugas-nilai{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800}
    .tn-good{color:var(--green)}.tn-mid{color:var(--yellow)}.tn-low{color:var(--red)}
    .tugas-right{flex-shrink:0;text-align:right;min-width:100px}
    .tugas-nilai-box{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:10px 16px;text-align:center}
    .tnb-score{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800}
    .tnb-label{font-family:'DM Sans',sans-serif;font-size:11px;color:var(--text3);margin-top:2px}
    .jenis-pill{display:inline-block;padding:2px 8px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700}
    .jp-file{background:#ede9fe;color:#6d28d9}
    .jp-teks{background:#dcfce7;color:#15803d}
    .jp-link{background:#dbeafe;color:#1d4ed8}
    /* ── Empty ── */
    .empty-state{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:80px 20px;text-align:center}
    /* ── Pagination ── */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;margin-top:20px;flex-wrap:wrap;gap:10px}
    .pag-info{font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;text-decoration:none;transition:all .15s}
    .pag-btn:hover{background:var(--surface2)}.pag-btn.active{background:var(--brand);border-color:var(--brand);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    @media(max-width:768px){.stat-strip{grid-template-columns:1fr 1fr}.tugas-card-inner{flex-wrap:wrap}.tugas-right{min-width:auto}.page{padding:16px}}
</style>

<div class="page">
    <nav class="bc">
        <a href="{{ route('ortu.dashboard') }}">Dashboard</a>
        <span class="bc-sep">›</span>
        <span class="bc-cur">Progress Tugas</span>
    </nav>

    {{-- ── Anak bar ── --}}
    <div class="anak-bar">
        @php $initials = collect(explode(' ', $anak->nama_lengkap))->take(2)->map(fn($w)=>strtoupper($w[0]))->join('') @endphp
        <div class="anak-avatar">{{ $initials }}</div>
        <div>
            <p class="anak-name">{{ $anak->nama_lengkap }}</p>
            <p class="anak-meta">{{ $anak->kelas->nama_kelas ?? '—' }} · NIS: {{ $anak->nis ?? '—' }}</p>
        </div>
        @if($anakList->count() > 1)
        <div class="anak-switch">
            @foreach($anakList as $a)
            <a href="{{ route('ortu.akademik.tugas', ['siswa_id' => $a->id]) }}"
               class="anak-btn {{ $a->id === $anak->id ? 'active' : '' }}">{{ $a->nama_lengkap }}</a>
            @endforeach
        </div>
        @endif
    </div>

    {{-- ── Stat strip ── --}}
    <div class="stat-strip">
        <div class="stat-card">
            <div class="stat-ic ic-blue">
                <svg width="20" height="20" fill="none" stroke="#2563eb" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
                <p class="stat-lbl">Total Tugas</p>
                <p class="stat-val">{{ $statTugas['total'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-ic ic-green">
                <svg width="20" height="20" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <div>
                <p class="stat-lbl">Sudah Dikumpulkan</p>
                <p class="stat-val" style="color:var(--green)">{{ $statTugas['dikumpulkan'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-ic ic-yellow">
                <svg width="20" height="20" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
            <div>
                <p class="stat-lbl">Sudah Dinilai</p>
                <p class="stat-val">{{ $statTugas['dinilai'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-ic ic-purple">
                <svg width="20" height="20" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            </div>
            <div>
                <p class="stat-lbl">Rata-rata Nilai</p>
                <p class="stat-val">{{ $statTugas['rata_nilai'] ?: '—' }}</p>
            </div>
        </div>
    </div>

    {{-- ── Progress keseluruhan ── --}}
    @if($statTugas['total'] > 0)
    @php $pct = round(($statTugas['dikumpulkan'] / $statTugas['total']) * 100) @endphp
    <div class="progress-banner">
        <div class="pb-header">
            <p class="pb-title">Tingkat Pengumpulan Tugas</p>
            <p class="pb-pct">{{ $pct }}%</p>
        </div>
        <div class="prog-bg">
            <div class="prog-fill" style="width:{{ $pct }}%"></div>
        </div>
        <p style="font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text3);margin-top:8px">
            {{ $statTugas['dikumpulkan'] }} dari {{ $statTugas['total'] }} tugas telah dikumpulkan
        </p>
    </div>
    @endif

    {{-- ── Daftar Tugas ── --}}
    @if($tugasAll->isEmpty())
    <div class="empty-state">
        <svg width="48" height="48" fill="none" stroke="#cbd5e1" stroke-width="1.4" viewBox="0 0 24 24" style="margin:0 auto 16px;display:block"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:16px;color:var(--text);margin-bottom:6px">Belum ada tugas</p>
        <p style="font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text3)">Tidak ada tugas yang dipublikasikan untuk kelas ini.</p>
    </div>
    @else
    <div class="tugas-list">
        @foreach($tugasAll as $t)
        @php
            $pngmpln     = $pengumpulanMap[$t->id] ?? null;
            $dikumpulkan = $pngmpln !== null && $pngmpln->dikumpulkan_pada !== null;
            $dinilai     = $pngmpln?->status === 'sudah_dinilai';
            $terlambat   = $dikumpulkan && $pngmpln->isTerlambat();
            $berakhir    = $t->isTelahBerakhir();
            $nilaiPngmpln = $pngmpln?->nilai;

            if ($dinilai)           { $statusKey = 'dinilai'; }
            elseif ($terlambat)     { $statusKey = 'terlambat'; }
            elseif ($dikumpulkan)   { $statusKey = 'dikumpulkan'; }
            else                    { $statusKey = 'belum'; }

            $iconClass  = ['dinilai'=>'tsi-dinilai','terlambat'=>'tsi-terlambat','dikumpulkan'=>'tsi-selesai','belum'=>'tsi-belum'][$statusKey];
            $badgeClass = ['dinilai'=>'tb-dinilai','terlambat'=>'tb-terlambat','dikumpulkan'=>'tb-dikumpulkan','belum'=>'tb-belum'][$statusKey];
            $badgeLabel = ['dinilai'=>'Sudah Dinilai','terlambat'=>'Terlambat','dikumpulkan'=>'Sudah Dikumpulkan','belum'=>'Belum Dikumpulkan'][$statusKey];

            $deadlineClass = $berakhir ? 'deadline-over' : (now()->diffInHours($t->batas_waktu, false) < 24 ? 'deadline-warn' : 'deadline-ok');

            $nilaiColor = $nilaiPngmpln === null ? '' : ($nilaiPngmpln >= 80 ? 'tn-good' : ($nilaiPngmpln >= 60 ? 'tn-mid' : 'tn-low'));

            $jenisLabel = ['file'=>'File','teks'=>'Teks','link'=>'Link'][$t->jenis_pengumpulan ?? ''] ?? ($t->jenis_pengumpulan ?? '-');
            $jenisClass = ['file'=>'jp-file','teks'=>'jp-teks','link'=>'jp-link'][$t->jenis_pengumpulan ?? ''] ?? '';
        @endphp
        <div class="tugas-card">
            <div class="tugas-card-inner">
                {{-- Status icon ── --}}
                <div class="tugas-status-icon {{ $iconClass }}">
                    @if($dinilai)
                    <svg width="18" height="18" fill="none" stroke="#2563eb" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/><path d="M18 2l4 4-10 10H8v-4L18 2z"/></svg>
                    @elseif($terlambat)
                    <svg width="18" height="18" fill="none" stroke="#c2410c" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    @elseif($dikumpulkan)
                    <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    @else
                    <svg width="18" height="18" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    @endif
                </div>

                {{-- Konten ── --}}
                <div class="tugas-content">
                    <p class="tugas-judul">{{ $t->judul }}</p>
                    <div class="tugas-meta">
                        <span class="tugas-mapel">{{ $t->mataPelajaran->nama_mapel ?? '—' }}</span>
                        <span class="tugas-guru">{{ $t->guru->nama_lengkap ?? '—' }}</span>
                        @if($t->jenis_pengumpulan)
                        <span class="jenis-pill {{ $jenisClass }}">{{ $jenisLabel }}</span>
                        @endif
                    </div>
                    <div class="tugas-info-row">
                        <span class="tugas-badge {{ $badgeClass }}">{{ $badgeLabel }}</span>
                        <span class="tugas-deadline {{ $deadlineClass }}">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                            Batas: {{ $t->batas_waktu->translatedFormat('d M Y, H:i') }}
                            @if($berakhir) <span style="font-weight:700">(Berakhir)</span> @endif
                        </span>
                        @if($dikumpulkan && $pngmpln->dikumpulkan_pada)
                        <span style="font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text3)">
                            Dikumpulkan: {{ $pngmpln->dikumpulkan_pada->translatedFormat('d M Y, H:i') }}
                        </span>
                        @endif
                    </div>
                    @if($pngmpln?->umpan_balik)
                    <div style="margin-top:8px;background:var(--surface2);border-radius:var(--radius-sm);padding:8px 12px;border-left:3px solid var(--brand)">
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;margin-bottom:3px">Umpan Balik Guru:</p>
                        <p style="font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2);font-style:italic">{{ $pngmpln->umpan_balik }}</p>
                    </div>
                    @endif
                </div>

                {{-- Nilai ── --}}
                <div class="tugas-right">
                    @if($nilaiPngmpln !== null)
                    <div class="tugas-nilai-box">
                        <p class="tnb-score {{ $nilaiColor }}">{{ number_format($nilaiPngmpln, 0) }}</p>
                        <p class="tnb-label">dari {{ $t->nilai_maksimal ?? 100 }}</p>
                    </div>
                    @elseif($dikumpulkan)
                    <div class="tugas-nilai-box" style="background:var(--yellow-bg);border-color:var(--yellow-border)">
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--yellow)">Menunggu</p>
                        <p class="tnb-label">penilaian</p>
                    </div>
                    @elseif($berakhir)
                    <div class="tugas-nilai-box" style="background:var(--red-bg);border-color:var(--red-border)">
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--red)">Tidak</p>
                        <p class="tnb-label">dikumpulkan</p>
                    </div>
                    @else
                    <div class="tugas-nilai-box">
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3)">Belum</p>
                        <p class="tnb-label">dinilai</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── Pagination ── --}}
    @if($tugasAll->hasPages())
    <div class="pag-wrap">
        <p class="pag-info">Menampilkan {{ $tugasAll->firstItem() }}–{{ $tugasAll->lastItem() }} dari {{ $tugasAll->total() }} tugas</p>
        <div class="pag-btns">
            @if($tugasAll->onFirstPage())
                <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
            @else
                <a href="{{ $tugasAll->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
            @endif
            @foreach($tugasAll->getUrlRange(1, $tugasAll->lastPage()) as $pg => $url)
                @if($pg == $tugasAll->currentPage())
                    <span class="pag-btn active">{{ $pg }}</span>
                @elseif($pg == 1 || $pg == $tugasAll->lastPage() || abs($pg - $tugasAll->currentPage()) <= 1)
                    <a href="{{ $url }}" class="pag-btn">{{ $pg }}</a>
                @elseif(abs($pg - $tugasAll->currentPage()) == 2)
                    <span style="color:var(--text3);padding:0 4px;display:flex;align-items:center;font-size:13px">…</span>
                @endif
            @endforeach
            @if($tugasAll->hasMorePages())
                <a href="{{ $tugasAll->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
            @else
                <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
            @endif
        </div>
    </div>
    @endif
    @endif

</div>
</x-app-layout>