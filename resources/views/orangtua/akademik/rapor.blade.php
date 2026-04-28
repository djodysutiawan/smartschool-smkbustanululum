<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:ital,wght@0,400;0,500;0,600;1,400&display=swap');
    :root {
        --brand:#2563eb;--brand-50:#eff6ff;--brand-100:#dbeafe;--brand-700:#1d4ed8;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --green:#15803d;--green-bg:#f0fdf4;--green-border:#bbf7d0;
        --red:#dc2626;--red-bg:#fef2f2;
        --yellow:#a16207;--yellow-bg:#fefce8;
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
    /* ── Filter ── */
    .filter-bar{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;display:flex;align-items:center;gap:10px;margin-bottom:20px;flex-wrap:wrap}
    .filter-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .filter-select{padding:7px 12px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s;min-width:180px}
    .filter-select:focus{border-color:var(--brand)}
    .btn-filter{padding:7px 18px;border-radius:var(--radius-sm);background:var(--brand);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;border:none;cursor:pointer;transition:filter .15s}
    .btn-filter:hover{filter:brightness(.92)}
    /* ── Hero rapor ── */
    .rapor-hero{background:linear-gradient(135deg,#1e40af 0%,#2563eb 50%,#3b82f6 100%);border-radius:var(--radius);padding:28px 32px;margin-bottom:20px;display:flex;align-items:center;gap:24px;flex-wrap:wrap}
    .rh-score-wrap{text-align:center;background:rgba(255,255,255,.15);border-radius:12px;padding:16px 28px;flex-shrink:0}
    .rh-score-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:rgba(255,255,255,.75);text-transform:uppercase;letter-spacing:.08em;margin-bottom:4px}
    .rh-score{font-family:'Plus Jakarta Sans',sans-serif;font-size:52px;font-weight:800;color:#fff;line-height:1}
    .rh-predikat{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:rgba(255,255,255,.85);margin-top:4px}
    .rh-info{flex:1}
    .rh-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:#fff;margin-bottom:6px}
    .rh-sub{font-family:'DM Sans',sans-serif;font-size:13.5px;color:rgba(255,255,255,.8);line-height:1.6}
    .rh-stats{display:flex;gap:16px;margin-top:14px;flex-wrap:wrap}
    .rh-stat-item{background:rgba(255,255,255,.15);border-radius:8px;padding:8px 16px;text-align:center}
    .rh-stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:#fff}
    .rh-stat-lbl{font-family:'DM Sans',sans-serif;font-size:11px;color:rgba(255,255,255,.75)}
    /* ── Sebaran predikat ── */
    .sebaran-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:10px;margin-bottom:20px}
    .sebaran-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px;text-align:center}
    .sb-predikat{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;font-weight:800}
    .sb-count{font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text3);margin-top:4px}
    .p-a .sb-predikat{color:var(--green)}
    .p-b .sb-predikat{color:#0369a1}
    .p-c .sb-predikat{color:var(--yellow)}
    .p-d .sb-predikat{color:#c2410c}
    .p-e .sb-predikat{color:var(--red)}
    /* ── Tabel rapor ── */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:20px}
    .table-hdr{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .table-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse}
    thead th{padding:11px 16px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;background:var(--surface2);border-bottom:1px solid var(--border);white-space:nowrap}
    th.center,td.center{text-align:center}
    tbody tr{border-bottom:1px solid var(--surface3);transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:var(--brand-50)}
    td{padding:13px 16px;font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);vertical-align:middle}
    .mapel-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .mapel-guru{font-size:12px;color:var(--text3);margin-top:2px}
    .nilai-cell{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--text)}
    .nilai-na{color:var(--text3);font-weight:400}
    .na-wrap{display:flex;align-items:center;gap:8px;justify-content:center}
    .na-score{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:800}
    .na-a{color:var(--green)}.na-b{color:#0369a1}.na-c{color:var(--yellow)}.na-d{color:#c2410c}.na-e{color:var(--red)}
    .predikat-badge{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800}
    .pb-a{background:var(--green-bg);color:var(--green)}
    .pb-b{background:#e0f2fe;color:#0369a1}
    .pb-c{background:var(--yellow-bg);color:var(--yellow)}
    .pb-d{background:#ffedd5;color:#c2410c}
    .pb-e{background:var(--red-bg);color:var(--red)}
    .catatan-cell{font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text3);font-style:italic;max-width:200px}
    /* ── Highlight mapel ── */
    .highlight-row{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:20px}
    .highlight-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;display:flex;align-items:center;gap:14px}
    .hc-icon{width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .hc-g{background:var(--green-bg)}.hc-r{background:var(--red-bg)}
    .hc-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .hc-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text);margin-top:2px}
    .hc-score{font-size:13px;color:var(--text3);font-weight:600;margin-top:1px}
    @media(max-width:768px){.sebaran-grid{grid-template-columns:repeat(5,1fr)}.highlight-row{grid-template-columns:1fr}.rapor-hero{flex-direction:column}.page{padding:16px}}
</style>

<div class="page">
    <nav class="bc">
        <a href="{{ route('ortu.dashboard') }}">Dashboard</a>
        <span class="bc-sep">›</span>
        <span class="bc-cur">Rekap / Rapor</span>
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
            <a href="{{ route('ortu.akademik.rapor', ['siswa_id' => $a->id, 'tahun_ajaran_id' => $tahunAjaranId]) }}"
               class="anak-btn {{ $a->id === $anak->id ? 'active' : '' }}">{{ $a->nama_lengkap }}</a>
            @endforeach
        </div>
        @endif
    </div>

    {{-- ── Filter tahun ajaran ── --}}
    <form method="GET" action="{{ route('ortu.akademik.rapor') }}">
        <input type="hidden" name="siswa_id" value="{{ $anak->id }}">
        <div class="filter-bar">
            <span class="filter-label">Tahun Ajaran</span>
            <select name="tahun_ajaran_id" class="filter-select">
                <option value="">Semua</option>
                @foreach($tahunList as $ta)
                <option value="{{ $ta->id }}" {{ $ta->id == $tahunAjaranId ? 'selected' : '' }}>
                    {{ $ta->label ?? ($ta->tahun . ' — ' . ucfirst($ta->semester)) }}
                </option>
                @endforeach
            </select>
            <button type="submit" class="btn-filter">Tampilkan</button>
        </div>
    </form>

    @if($raporData->isEmpty())
    <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:80px 20px;text-align:center">
        <svg width="48" height="48" fill="none" stroke="#cbd5e1" stroke-width="1.4" viewBox="0 0 24 24" style="margin:0 auto 16px;display:block"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:16px;color:var(--text);margin-bottom:6px">Belum ada data rapor</p>
        <p style="font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text3)">Guru belum menginput nilai untuk periode yang dipilih.</p>
    </div>
    @else

    {{-- ── Hero ── --}}
    @php
        $overallPredikat = match(true) {
            ($rataRata ?? 0) >= 90 => 'A',
            ($rataRata ?? 0) >= 80 => 'B',
            ($rataRata ?? 0) >= 70 => 'C',
            ($rataRata ?? 0) >= 60 => 'D',
            default => 'E',
        };
    @endphp
    <div class="rapor-hero">
        <div class="rh-score-wrap">
            <p class="rh-score-label">Rata-rata</p>
            <p class="rh-score">{{ $rataRata ? number_format($rataRata, 1) : '—' }}</p>
            <p class="rh-predikat">Predikat {{ $overallPredikat }}</p>
        </div>
        <div class="rh-info">
            <p class="rh-title">Laporan Akademik — {{ $anak->nama_lengkap }}</p>
            <p class="rh-sub">
                Kelas {{ $anak->kelas->nama_kelas ?? '—' }} ·
                {{ $tahunAjaran ? ($tahunAjaran->label ?? $tahunAjaran->tahun) : 'Semua Tahun Ajaran' }}
            </p>
            <div class="rh-stats">
                <div class="rh-stat-item">
                    <p class="rh-stat-val">{{ $raporData->count() }}</p>
                    <p class="rh-stat-lbl">Mata Pelajaran</p>
                </div>
                <div class="rh-stat-item">
                    <p class="rh-stat-val">{{ $raporData->where('predikat','A')->count() + $raporData->where('predikat','B')->count() }}</p>
                    <p class="rh-stat-lbl">Nilai A & B</p>
                </div>
                @if($nilaiTertinggi)
                <div class="rh-stat-item">
                    <p class="rh-stat-val">{{ number_format($nilaiTertinggi['nilai_akhir'],1) }}</p>
                    <p class="rh-stat-lbl">Nilai Tertinggi</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Sebaran Predikat ── --}}
    <div class="sebaran-grid">
        @foreach(['A','B','C','D','E'] as $p)
        @php $cls = ['A'=>'p-a','B'=>'p-b','C'=>'p-c','D'=>'p-d','E'=>'p-e'][$p] @endphp
        <div class="sebaran-card {{ $cls }}">
            <p class="sb-predikat">{{ $p }}</p>
            <p class="sb-count">{{ $sebaranPredikat[$p] ?? 0 }} mapel</p>
        </div>
        @endforeach
    </div>

    {{-- ── Highlight Tertinggi / Terendah ── --}}
    @if($nilaiTertinggi || $nilaiTerendah)
    <div class="highlight-row">
        @if($nilaiTertinggi)
        <div class="highlight-card">
            <div class="hc-icon hc-g">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"/><polyline points="17 6 23 6 23 12"/></svg>
            </div>
            <div>
                <p class="hc-label">Nilai Tertinggi</p>
                <p class="hc-val">{{ $nilaiTertinggi['mapel']->nama_mapel ?? '—' }}</p>
                <p class="hc-score">{{ number_format($nilaiTertinggi['nilai_akhir'],1) }} · Predikat {{ $nilaiTertinggi['predikat'] }}</p>
            </div>
        </div>
        @endif
        @if($nilaiTerendah)
        <div class="highlight-card">
            <div class="hc-icon hc-r">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><polyline points="23 18 13.5 8.5 8.5 13.5 1 6"/><polyline points="17 18 23 18 23 12"/></svg>
            </div>
            <div>
                <p class="hc-label">Perlu Perhatian</p>
                <p class="hc-val">{{ $nilaiTerendah['mapel']->nama_mapel ?? '—' }}</p>
                <p class="hc-score">{{ number_format($nilaiTerendah['nilai_akhir'],1) }} · Predikat {{ $nilaiTerendah['predikat'] }}</p>
            </div>
        </div>
        @endif
    </div>
    @endif

    {{-- ── Tabel Rapor ── --}}
    <div class="table-card">
        <div class="table-hdr">
            <span class="table-title">Rekap Nilai Seluruh Mata Pelajaran</span>
            <span style="font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text3)">{{ $raporData->count() }} mata pelajaran</span>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mata Pelajaran</th>
                        <th class="center">Tugas<br><span style="font-weight:400;font-size:10px;text-transform:none">(20%)</span></th>
                        <th class="center">Harian<br><span style="font-weight:400;font-size:10px;text-transform:none">(30%)</span></th>
                        <th class="center">UTS<br><span style="font-weight:400;font-size:10px;text-transform:none">(20%)</span></th>
                        <th class="center">UAS<br><span style="font-weight:400;font-size:10px;text-transform:none">(30%)</span></th>
                        <th class="center">Nilai Akhir</th>
                        <th class="center">P</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($raporData as $idx => $r)
                    @php
                        $naClass = match($r['predikat'] ?? '') { 'A'=>'na-a','B'=>'na-b','C'=>'na-c','D'=>'na-d','E'=>'na-e', default=>'' };
                        $pbClass = match($r['predikat'] ?? '') { 'A'=>'pb-a','B'=>'pb-b','C'=>'pb-c','D'=>'pb-d','E'=>'pb-e', default=>'' };
                    @endphp
                    <tr>
                        <td style="color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700">{{ $idx + 1 }}</td>
                        <td>
                            <p class="mapel-name">{{ $r['mapel']->nama_mapel ?? '—' }}</p>
                            <p class="mapel-guru">{{ $r['guru']->nama_lengkap ?? '—' }}</p>
                        </td>
                        <td class="center"><span class="nilai-cell {{ is_null($r['nilai_tugas']) ? 'nilai-na' : '' }}">{{ $r['nilai_tugas'] !== null ? number_format($r['nilai_tugas'],0) : '—' }}</span></td>
                        <td class="center"><span class="nilai-cell {{ is_null($r['nilai_harian']) ? 'nilai-na' : '' }}">{{ $r['nilai_harian'] !== null ? number_format($r['nilai_harian'],0) : '—' }}</span></td>
                        <td class="center"><span class="nilai-cell {{ is_null($r['nilai_uts']) ? 'nilai-na' : '' }}">{{ $r['nilai_uts'] !== null ? number_format($r['nilai_uts'],0) : '—' }}</span></td>
                        <td class="center"><span class="nilai-cell {{ is_null($r['nilai_uas']) ? 'nilai-na' : '' }}">{{ $r['nilai_uas'] !== null ? number_format($r['nilai_uas'],0) : '—' }}</span></td>
                        <td class="center">
                            <div class="na-wrap">
                                <span class="na-score {{ $naClass }}">{{ number_format($r['nilai_akhir'],1) }}</span>
                            </div>
                        </td>
                        <td class="center">
                            <span class="predikat-badge {{ $pbClass }}">{{ $r['predikat'] ?? '—' }}</span>
                        </td>
                        <td><span class="catatan-cell">{{ $r['catatan'] ?? '—' }}</span></td>
                    </tr>
                    @endforeach
                    {{-- Baris rata-rata ── --}}
                    @php
                        $naClassOverall = match($overallPredikat) { 'A'=>'na-a','B'=>'na-b','C'=>'na-c','D'=>'na-d','E'=>'na-e', default=>'' };
                        $pbOverall      = match($overallPredikat) { 'A'=>'pb-a','B'=>'pb-b','C'=>'pb-c','D'=>'pb-d','E'=>'pb-e', default=>'' };
                    @endphp
                    <tr style="background:var(--surface2);border-top:2px solid var(--border)">
                        <td colspan="6" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);text-align:right;text-transform:uppercase;letter-spacing:.04em;padding-right:16px">
                            Rata-rata Keseluruhan
                        </td>
                        <td class="center">
                            <div class="na-wrap">
                                <span class="na-score {{ $naClassOverall }}" style="font-size:18px">
                                    {{ $rataRata ? number_format($rataRata,1) : '—' }}
                                </span>
                            </div>
                        </td>
                        <td class="center">
                            <span class="predikat-badge {{ $pbOverall }}">{{ $overallPredikat }}</span>
                        </td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
</x-app-layout>