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
        --radius:12px;--radius-sm:8px;
    }
    *{box-sizing:border-box;margin:0;padding:0}
    .page{padding:28px 28px 60px;max-width:1300px;margin:0 auto}
    /* ── Breadcrumb ── */
    .bc{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .bc a{color:var(--text3);text-decoration:none}.bc a:hover{color:var(--brand)}.bc-sep{color:var(--border)}.bc-cur{color:var(--text2)}
    /* ── Anak switcher ── */
    .anak-bar{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;display:flex;align-items:center;gap:12px;margin-bottom:20px;flex-wrap:wrap}
    .anak-avatar{width:42px;height:42px;border-radius:50%;background:var(--brand-100);display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:15px;color:var(--brand-700);flex-shrink:0}
    .anak-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;color:var(--text)}
    .anak-meta{font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text3)}
    .anak-switch{margin-left:auto;display:flex;gap:8px;flex-wrap:wrap}
    .anak-btn{padding:5px 14px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;border:1.5px solid var(--border);background:var(--surface2);color:var(--text2);text-decoration:none;transition:all .15s}
    .anak-btn:hover,.anak-btn.active{background:var(--brand);border-color:var(--brand);color:#fff}
    /* ── Filter bar ── */
    .filter-bar{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;display:flex;align-items:center;gap:10px;margin-bottom:20px;flex-wrap:wrap}
    .filter-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;white-space:nowrap}
    .filter-select{padding:7px 12px;border:1.5px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface);outline:none;transition:border-color .15s;min-width:160px}
    .filter-select:focus{border-color:var(--brand)}
    .btn-filter{padding:7px 18px;border-radius:var(--radius-sm);background:var(--brand);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;border:none;cursor:pointer;transition:filter .15s}
    .btn-filter:hover{filter:brightness(.92)}
    .btn-reset{padding:7px 14px;border-radius:var(--radius-sm);background:var(--surface2);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;border:1.5px solid var(--border);cursor:pointer;text-decoration:none;transition:all .15s}
    .btn-reset:hover{background:var(--surface3)}
    /* ── Stat cards ── */
    .stat-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;display:flex;align-items:center;gap:14px}
    .stat-ic{width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .ic-blue{background:var(--brand-50)}.ic-green{background:var(--green-bg)}.ic-yellow{background:var(--yellow-bg)}.ic-purple{background:#faf5ff}
    .stat-lbl{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:3px}
    .stat-val .unit{font-size:12px;font-weight:600;color:var(--text3);margin-left:2px}
    /* ── Tabel ── */
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
    td{padding:12px 16px;font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);vertical-align:middle}
    .mapel-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .mapel-guru{font-size:12px;color:var(--text3);margin-top:2px}
    .nilai-chip{display:inline-flex;align-items:center;justify-content:center;min-width:50px;padding:4px 10px;border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800}
    .nc-a{background:var(--green-bg);color:var(--green)}
    .nc-b{background:#f0f9ff;color:#0369a1}
    .nc-c{background:var(--yellow-bg);color:var(--yellow)}
    .nc-d{background:#fff7ed;color:#c2410c}
    .nc-e{background:var(--red-bg);color:var(--red)}
    .nc-na{background:var(--surface3);color:var(--text3)}
    .predikat-badge{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800}
    .pb-a{background:var(--green-bg);color:var(--green)}
    .pb-b{background:#e0f2fe;color:#0369a1}
    .pb-c{background:var(--yellow-bg);color:var(--yellow)}
    .pb-d{background:#ffedd5;color:#c2410c}
    .pb-e{background:var(--red-bg);color:var(--red)}
    .empty-row td{text-align:center;padding:60px;color:var(--text3);font-family:'DM Sans',sans-serif}
    /* ── Progress bar nilai ── */
    .nilai-bar-wrap{display:flex;align-items:center;gap:8px;min-width:120px}
    .nilai-bar-bg{flex:1;height:6px;border-radius:3px;background:var(--surface3);overflow:hidden}
    .nilai-bar-fill{height:100%;border-radius:3px;transition:width .3s}
    .bar-green{background:#22c55e}
    .bar-blue{background:#3b82f6}
    .bar-yellow{background:#eab308}
    .bar-red{background:#ef4444}
    @media(max-width:768px){.stat-strip{grid-template-columns:1fr 1fr}.page{padding:16px}}
    @media(max-width:480px){.stat-strip{grid-template-columns:1fr}}
</style>

<div class="page">
    <nav class="bc">
        <a href="{{ route('ortu.dashboard') }}">Dashboard</a>
        <span class="bc-sep">›</span>
        <span class="bc-cur">Nilai per Mapel</span>
    </nav>

    {{-- ── Anak Switcher ── --}}
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
            <a href="{{ route('ortu.akademik.nilai', ['siswa_id' => $a->id, 'tahun_ajaran_id' => $tahunAjaranId]) }}"
               class="anak-btn {{ $a->id === $anak->id ? 'active' : '' }}">
                {{ $a->nama_lengkap }}
            </a>
            @endforeach
        </div>
        @endif
    </div>

    {{-- ── Filter ── --}}
    <form method="GET" action="{{ route('ortu.akademik.nilai') }}">
        <input type="hidden" name="siswa_id" value="{{ $anak->id }}">
        <div class="filter-bar">
            <span class="filter-label">Filter</span>
            <select name="tahun_ajaran_id" class="filter-select">
                <option value="">Semua Tahun Ajaran</option>
                @foreach($tahunList as $ta)
                <option value="{{ $ta->id }}" {{ $ta->id == $tahunAjaranId ? 'selected' : '' }}>
                    {{ $ta->label ?? ($ta->tahun . ' — ' . ucfirst($ta->semester)) }}
                </option>
                @endforeach
            </select>
            <select name="mapel_id" class="filter-select">
                <option value="">Semua Mata Pelajaran</option>
                @foreach($mapelList as $mp)
                <option value="{{ $mp->id }}" {{ request('mapel_id') == $mp->id ? 'selected' : '' }}>
                    {{ $mp->nama_mapel }}
                </option>
                @endforeach
            </select>
            <button type="submit" class="btn-filter">Terapkan</button>
            <a href="{{ route('ortu.akademik.nilai', ['siswa_id' => $anak->id]) }}" class="btn-reset">Reset</a>
        </div>
    </form>

    {{-- ── Stat Strip ── --}}
    <div class="stat-strip">
        <div class="stat-card">
            <div class="stat-ic ic-blue">
                <svg width="20" height="20" fill="none" stroke="#2563eb" stroke-width="1.8" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
            </div>
            <div>
                <p class="stat-lbl">Mata Pelajaran</p>
                <p class="stat-val">{{ $statsPerMapel->count() }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-ic ic-green">
                <svg width="20" height="20" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            </div>
            <div>
                <p class="stat-lbl">Rata-rata Nilai Akhir</p>
                <p class="stat-val">{{ $rataRataAkhir ? number_format($rataRataAkhir, 1) : '—' }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-ic ic-yellow">
                <svg width="20" height="20" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <div>
                <p class="stat-lbl">Nilai Tertinggi</p>
                <p class="stat-val">{{ $statsPerMapel->max('nilai_akhir') ?: '—' }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-ic ic-purple">
                <svg width="20" height="20" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-lbl">Tahun Ajaran</p>
                <p class="stat-val" style="font-size:13px;line-height:1.3;margin-top:4px">
                    {{ $tahunAjaran ? ($tahunAjaran->label ?? $tahunAjaran->tahun) : 'Semua' }}
                </p>
            </div>
        </div>
    </div>

    {{-- ── Tabel Nilai ── --}}
    <div class="table-card">
        <div class="table-hdr">
            <span class="table-title">Rincian Nilai per Mata Pelajaran</span>
            <span style="font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text3)">
                {{ $nilaiList->count() }} catatan nilai
            </span>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mata Pelajaran</th>
                        <th class="center">Tugas</th>
                        <th class="center">Harian</th>
                        <th class="center">UTS</th>
                        <th class="center">UAS</th>
                        <th class="center">Nilai Akhir</th>
                        <th class="center">Predikat</th>
                        <th>Progress</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilaiList as $idx => $n)
                    @php
                        $na  = (float)($n->nilai_akhir ?? 0);
                        $pc  = $na; // 0-100
                        $barColor = $na >= 80 ? 'bar-green' : ($na >= 70 ? 'bar-blue' : ($na >= 60 ? 'bar-yellow' : 'bar-red'));
                        $ncClass  = match($n->predikat ?? '') { 'A'=>'nc-a','B'=>'nc-b','C'=>'nc-c','D'=>'nc-d','E'=>'nc-e', default=>'nc-na' };
                        $pbClass  = match($n->predikat ?? '') { 'A'=>'pb-a','B'=>'pb-b','C'=>'pb-c','D'=>'pb-d','E'=>'pb-e', default=>'' };
                    @endphp
                    <tr>
                        <td style="color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700">{{ $idx + 1 }}</td>
                        <td>
                            <p class="mapel-name">{{ $n->mataPelajaran->nama_mapel ?? '—' }}</p>
                            <p class="mapel-guru">{{ $n->guru->nama_lengkap ?? '—' }}</p>
                        </td>
                        <td class="center">
                            <span class="nilai-chip {{ $n->nilai_tugas !== null ? 'nc-b' : 'nc-na' }}">
                                {{ $n->nilai_tugas !== null ? number_format($n->nilai_tugas, 0) : '—' }}
                            </span>
                        </td>
                        <td class="center">
                            <span class="nilai-chip {{ $n->nilai_harian !== null ? 'nc-b' : 'nc-na' }}">
                                {{ $n->nilai_harian !== null ? number_format($n->nilai_harian, 0) : '—' }}
                            </span>
                        </td>
                        <td class="center">
                            <span class="nilai-chip {{ $n->nilai_uts !== null ? 'nc-b' : 'nc-na' }}">
                                {{ $n->nilai_uts !== null ? number_format($n->nilai_uts, 0) : '—' }}
                            </span>
                        </td>
                        <td class="center">
                            <span class="nilai-chip {{ $n->nilai_uas !== null ? 'nc-b' : 'nc-na' }}">
                                {{ $n->nilai_uas !== null ? number_format($n->nilai_uas, 0) : '—' }}
                            </span>
                        </td>
                        <td class="center">
                            <span class="nilai-chip {{ $ncClass }}" style="font-size:16px;min-width:60px">
                                {{ $na > 0 ? number_format($na, 1) : '—' }}
                            </span>
                        </td>
                        <td class="center">
                            <span class="predikat-badge {{ $pbClass }}">{{ $n->predikat ?? '—' }}</span>
                        </td>
                        <td>
                            <div class="nilai-bar-wrap">
                                <div class="nilai-bar-bg">
                                    <div class="nilai-bar-fill {{ $barColor }}" style="width:{{ $pc }}%"></div>
                                </div>
                                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);min-width:32px">{{ $pc > 0 ? number_format($pc,0).'%' : '' }}</span>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr class="empty-row">
                        <td colspan="9">
                            <div style="display:flex;flex-direction:column;align-items:center;gap:10px">
                                <svg width="40" height="40" fill="none" stroke="#cbd5e1" stroke-width="1.5" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                                <p style="font-weight:600;color:var(--text2)">Belum ada data nilai</p>
                                <p style="font-size:12.5px">Guru belum menginput nilai untuk periode ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ── Keterangan Bobot Nilai ── --}}
    <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;display:flex;align-items:center;gap:20px;flex-wrap:wrap">
        <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em">Formula Nilai Akhir:</span>
        @foreach(['Tugas (20%)','Harian (30%)','UTS (20%)','UAS (30%)'] as $f)
        <span style="font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2)">{{ $f }}</span>
        @endforeach
    </div>
</div>
</x-app-layout>