<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }

    .page{padding:28px 28px 48px;max-width:2000px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

    /* ── Tab nav ── */
    .tab-nav{display:flex;gap:4px;margin-bottom:20px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius);padding:4px;width:fit-content}
    .tab-link{padding:7px 18px;border-radius:7px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text3);text-decoration:none;transition:all .15s}
    .tab-link.active{background:var(--surface);color:var(--brand-600);box-shadow:0 1px 3px rgba(0,0,0,.08)}
    .tab-link:hover:not(.active){color:var(--text2)}

    /* ── Rapor header card ── */
    .rapor-header{background:linear-gradient(135deg,#1f63db 0%,#3582f0 100%);border-radius:var(--radius);padding:24px 28px;margin-bottom:20px;color:#fff;display:flex;align-items:center;justify-content:space-between;gap:16px;flex-wrap:wrap}
    .rapor-header-left .siswa-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;margin-bottom:4px}
    .rapor-header-left .siswa-meta{font-size:12.5px;opacity:.8;display:flex;gap:12px;flex-wrap:wrap}
    .rapor-header-left .siswa-meta span{display:flex;align-items:center;gap:4px}
    .rapor-score{text-align:center}
    .rapor-score .score-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:44px;font-weight:800;line-height:1}
    .rapor-score .score-label{font-size:12px;opacity:.8;margin-top:4px}
    .rapor-score .score-pred{display:inline-block;background:rgba(255,255,255,.2);border-radius:8px;padding:2px 12px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:18px;margin-top:6px}

    /* ── Filter ── */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row select:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer}
    .btn-filter:hover{background:var(--brand-700)}

    /* ── Rapor table ── */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:12px 20px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13.5px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:10px 14px;text-align:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.left{text-align:left}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:10px 14px;color:var(--text);vertical-align:middle;text-align:center}
    td.left{text-align:left}

    /* Nilai pill */
    .nilai-pill{display:inline-flex;align-items:center;justify-content:center;min-width:44px;height:26px;padding:0 8px;border-radius:7px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700}
    .nilai-a{background:#dcfce7;color:#15803d}
    .nilai-b{background:#dbeafe;color:#1d4ed8}
    .nilai-c{background:#fef9c3;color:#a16207}
    .nilai-d{background:#fed7aa;color:#c2410c}
    .nilai-e{background:#fee2e2;color:#dc2626}
    .nilai-null{background:var(--surface3);color:var(--text3);font-weight:500}

    /* Predikat badge */
    .pred-badge{display:inline-flex;align-items:center;justify-content:center;width:30px;height:30px;border-radius:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800}
    .pred-A{background:#dcfce7;color:#15803d}
    .pred-B{background:#dbeafe;color:#1d4ed8}
    .pred-C{background:#fef9c3;color:#a16207}
    .pred-D{background:#fed7aa;color:#c2410c}
    .pred-E{background:#fee2e2;color:#dc2626}

    /* Tfoot rata-rata */
    tfoot tr{background:var(--surface2);border-top:2px solid var(--border)}
    tfoot td{padding:12px 14px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)}

    /* Empty */
    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    @media(max-width:768px){.page{padding:16px}}
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Rekap Nilai / Rapor</h1>
            <p class="page-sub">Ringkasan nilai akhir seluruh mata pelajaran per tahun ajaran</p>
        </div>
    </div>

    {{-- Tab navigasi --}}
    <div class="tab-nav">
        <a href="{{ route('siswa.nilai.index') }}"
           class="tab-link {{ request()->routeIs('siswa.nilai.index') ? 'active' : '' }}">
            Nilai per Mapel
        </a>
        <a href="{{ route('siswa.nilai.rapor') }}"
           class="tab-link {{ request()->routeIs('siswa.nilai.rapor') ? 'active' : '' }}">
            Rekap / Rapor
        </a>
    </div>

    {{-- ── Rapor header card ── --}}
    <div class="rapor-header">
        <div class="rapor-header-left">
            <p class="siswa-name">{{ $siswa->nama ?? Auth::user()->name }}</p>
            <div class="siswa-meta">
                @if($siswa->nis ?? false)
                    <span>
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="2" y="5" width="20" height="14" rx="2"/>
                            <line x1="2" y1="10" x2="22" y2="10"/>
                        </svg>
                        NIS: {{ $siswa->nis }}
                    </span>
                @endif
                @if($siswa->kelas->nama_kelas ?? false)
                    <span>
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        </svg>
                        {{ $siswa->kelas->nama_kelas }}
                    </span>
                @endif
                @if($selectedTahun)
                    <span>
                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/>
                            <line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
                        </svg>
                        {{ $selectedTahun->label }}
                    </span>
                @endif
            </div>
        </div>
        @if($rataRata)
        <div class="rapor-score">
            <div class="score-val">{{ number_format($rataRata, 1) }}</div>
            <div class="score-label">Rata-rata Nilai Akhir</div>
            <div class="score-pred">{{ $predikatUmum }}</div>
        </div>
        @endif
    </div>

    {{-- ── Filter ── --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('siswa.nilai.rapor') }}">
            <div class="filter-row">
                <select name="tahun_ajaran_id">
                    <option value="">Pilih Tahun Ajaran</option>
                    @foreach($tahunList as $t)
                        <option value="{{ $t->id }}" {{ $tahunAjaranId == $t->id ? 'selected' : '' }}>
                            {{ $t->label }}
                        </option>
                    @endforeach
                </select>
                <div class="filter-sep"></div>
                <button type="submit" class="btn-filter">Tampilkan</button>
            </div>
        </form>
    </div>

    {{-- ── Rapor table ── --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">Rekap Nilai Akhir &nbsp;—&nbsp; {{ $raporData->count() }} mata pelajaran</p>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th class="left" style="width:44px">#</th>
                        <th class="left">Mata Pelajaran</th>
                        <th>Tugas<br><span style="font-weight:400;font-size:10px;text-transform:none;letter-spacing:0">(20%)</span></th>
                        <th>Harian<br><span style="font-weight:400;font-size:10px;text-transform:none;letter-spacing:0">(30%)</span></th>
                        <th>UTS<br><span style="font-weight:400;font-size:10px;text-transform:none;letter-spacing:0">(20%)</span></th>
                        <th>UAS<br><span style="font-weight:400;font-size:10px;text-transform:none;letter-spacing:0">(30%)</span></th>
                        <th>Nilai Akhir</th>
                        <th>Predikat</th>
                        <th class="left">Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($raporData as $i => $r)
                    @php
                        $pc = function($v) {
                            if ($v === null) return 'nilai-null';
                            return match(true) {
                                $v >= 90 => 'nilai-a',
                                $v >= 80 => 'nilai-b',
                                $v >= 70 => 'nilai-c',
                                $v >= 60 => 'nilai-d',
                                default  => 'nilai-e',
                            };
                        };
                    @endphp
                    <tr>
                        <td class="left" style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)">
                            {{ $i + 1 }}
                        </td>
                        <td class="left">
                            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)">
                                {{ $r['mapel']->nama_mapel ?? '—' }}
                            </p>
                            @if($r['mapel']->kode_mapel ?? false)
                                <p style="font-size:11px;color:var(--text3);margin-top:1px">{{ $r['mapel']->kode_mapel }}</p>
                            @endif
                        </td>

                        <td><span class="nilai-pill {{ $pc($r['nilai_tugas']) }}">{{ $r['nilai_tugas'] ?? '—' }}</span></td>
                        <td><span class="nilai-pill {{ $pc($r['nilai_harian']) }}">{{ $r['nilai_harian'] ?? '—' }}</span></td>
                        <td><span class="nilai-pill {{ $pc($r['nilai_uts']) }}">{{ $r['nilai_uts'] ?? '—' }}</span></td>
                        <td><span class="nilai-pill {{ $pc($r['nilai_uas']) }}">{{ $r['nilai_uas'] ?? '—' }}</span></td>

                        <td>
                            <span class="nilai-pill {{ $pc($r['nilai_akhir']) }}" style="font-size:14px;font-weight:800;min-width:50px">
                                {{ number_format($r['nilai_akhir'], 1) }}
                            </span>
                        </td>

                        <td>
                            <span class="pred-badge pred-{{ $r['predikat'] }}">{{ $r['predikat'] }}</span>
                        </td>

                        <td class="left" style="font-size:12px;color:var(--text3);max-width:160px">
                            <p style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                                {{ $r['catatan'] ?? '—' }}
                            </p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                                    </svg>
                                </div>
                                <p class="empty-title">Belum ada data rapor</p>
                                <p class="empty-sub">Pilih tahun ajaran untuk melihat rekap nilai</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>

                @if($raporData->count() > 0)
                <tfoot>
                    <tr>
                        <td colspan="6" class="left" style="color:var(--text2)">
                            Rata-rata Keseluruhan
                        </td>
                        <td>
                            @php
                                $rtClass = match(true) {
                                    $rataRata >= 90 => 'nilai-a',
                                    $rataRata >= 80 => 'nilai-b',
                                    $rataRata >= 70 => 'nilai-c',
                                    $rataRata >= 60 => 'nilai-d',
                                    default         => 'nilai-e',
                                };
                            @endphp
                            <span class="nilai-pill {{ $rtClass }}" style="font-size:14px;font-weight:800;min-width:50px">
                                {{ number_format($rataRata, 1) }}
                            </span>
                        </td>
                        <td>
                            <span class="pred-badge pred-{{ $predikatUmum }}">{{ $predikatUmum }}</span>
                        </td>
                        <td></td>
                    </tr>
                </tfoot>
                @endif
            </table>
        </div>

        @if($raporData->count() > 0)
        <div style="padding:12px 20px;border-top:1px solid var(--border);background:var(--surface2);display:flex;flex-wrap:wrap;gap:16px;align-items:center">
            <p style="font-size:11.5px;color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600">Keterangan Predikat:</p>
            @foreach(['A'=>['#15803d','≥ 90'],'B'=>['#1d4ed8','80–89'],'C'=>['#a16207','70–79'],'D'=>['#c2410c','60–69'],'E'=>['#dc2626','< 60']] as $p => $info)
            <span style="display:inline-flex;align-items:center;gap:5px;font-size:11.5px;color:var(--text3)">
                <span style="width:18px;height:18px;border-radius:4px;background:{{ $info[0] }}20;color:{{ $info[0] }};font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:11px;display:inline-flex;align-items:center;justify-content:center">{{ $p }}</span>
                {{ $info[1] }}
            </span>
            @endforeach
        </div>
        @endif
    </div>

</div>
</x-app-layout>