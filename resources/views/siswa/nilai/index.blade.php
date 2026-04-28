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

    .page{padding:28px 28px 48px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

    /* ── Summary strip ── */
    .summary-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .sum-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px}
    .sum-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .sum-icon.blue  {background:#eff6ff}
    .sum-icon.green {background:#dcfce7}
    .sum-icon.yellow{background:#fef9c3}
    .sum-icon.purple{background:#fdf4ff}
    .sum-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .sum-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .sum-sub{font-size:11px;color:var(--text3);margin-top:1px}

    /* ── Filter ── */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row select:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer}
    .btn-filter:hover{background:var(--brand-700)}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center}
    .btn-reset:hover{background:var(--surface3)}

    /* ── Tab nav ── */
    .tab-nav{display:flex;gap:4px;margin-bottom:16px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius);padding:4px;width:fit-content}
    .tab-link{padding:7px 18px;border-radius:7px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text3);text-decoration:none;transition:all .15s}
    .tab-link.active{background:var(--surface);color:var(--brand-600);box-shadow:0 1px 3px rgba(0,0,0,.08)}
    .tab-link:hover:not(.active){color:var(--text2)}

    /* ── Table ── */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:12px 20px;border-bottom:1px solid var(--border);background:var(--surface2)}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}
    .table-info span{font-weight:400;color:var(--text3);margin-left:5px}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13.5px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:10px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}

    /* Nilai pill */
    .nilai-pill{display:inline-flex;align-items:center;justify-content:center;min-width:44px;height:26px;padding:0 8px;border-radius:7px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800}
    .nilai-a{background:#dcfce7;color:#15803d}
    .nilai-b{background:#dbeafe;color:#1d4ed8}
    .nilai-c{background:#fef9c3;color:#a16207}
    .nilai-d{background:#fed7aa;color:#c2410c}
    .nilai-e{background:#fee2e2;color:#dc2626}
    .nilai-null{background:var(--surface3);color:var(--text3)}

    /* Predikat badge */
    .pred-badge{display:inline-flex;align-items:center;justify-content:center;width:28px;height:28px;border-radius:7px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800}
    .pred-A{background:#dcfce7;color:#15803d}
    .pred-B{background:#dbeafe;color:#1d4ed8}
    .pred-C{background:#fef9c3;color:#a16207}
    .pred-D{background:#fed7aa;color:#c2410c}
    .pred-E{background:#fee2e2;color:#dc2626}

    /* Empty */
    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    @media(max-width:768px){
        .summary-strip{grid-template-columns:1fr 1fr}
        .page{padding:16px}
    }
    @media(max-width:480px){
        .summary-strip{grid-template-columns:1fr}
    }
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Nilai Saya</h1>
            <p class="page-sub">Catatan nilai akademik per mata pelajaran</p>
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

    {{-- ── Summary strip ── --}}
    @php
        $jumlahMapel  = $statsPerMapel->count();
        $predA        = $rekapPredikat->get('A', 0);
        $predBaik     = ($rekapPredikat->get('A', 0) + $rekapPredikat->get('B', 0));
        $rataFormatted = $rataRataAkhir ? number_format($rataRataAkhir, 1) : '—';
    @endphp
    <div class="summary-strip">
        <div class="sum-card">
            <div class="sum-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/>
                    <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>
                </svg>
            </div>
            <div>
                <p class="sum-label">Total Mapel</p>
                <p class="sum-val">{{ $jumlahMapel }}</p>
                <p class="sum-sub">mata pelajaran</p>
            </div>
        </div>

        <div class="sum-card">
            <div class="sum-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24">
                    <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
                </svg>
            </div>
            <div>
                <p class="sum-label">Rata-rata</p>
                <p class="sum-val">{{ $rataFormatted }}</p>
                <p class="sum-sub">nilai akhir</p>
            </div>
        </div>

        <div class="sum-card">
            <div class="sum-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div>
                <p class="sum-label">Predikat A</p>
                <p class="sum-val">{{ $predA }}</p>
                <p class="sum-sub">mapel nilai terbaik</p>
            </div>
        </div>

        <div class="sum-card">
            <div class="sum-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24">
                    <polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/>
                </svg>
            </div>
            <div>
                <p class="sum-label">A & B</p>
                <p class="sum-val">{{ $predBaik }}</p>
                <p class="sum-sub">nilai baik & sangat baik</p>
            </div>
        </div>
    </div>

    {{-- ── Filter ── --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('siswa.nilai.index') }}">
            <div class="filter-row">
                <select name="tahun_ajaran_id">
                    <option value="">Semua Tahun Ajaran</option>
                    @foreach($tahunList as $t)
                        <option value="{{ $t->id }}" {{ $tahunAjaranId == $t->id ? 'selected' : '' }}>
                            {{ $t->label }}
                        </option>
                    @endforeach
                </select>

                <select name="mapel_id">
                    <option value="">Semua Mata Pelajaran</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id }}" {{ request('mapel_id') == $m->id ? 'selected' : '' }}>
                            {{ $m->nama_mapel }}
                        </option>
                    @endforeach
                </select>

                <div class="filter-sep"></div>
                <a href="{{ route('siswa.nilai.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- ── Table ── --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Nilai
                <span>— {{ $nilaiList->count() }} data</span>
            </p>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:44px">#</th>
                        <th>Mata Pelajaran</th>
                        <th class="center">Tugas</th>
                        <th class="center">Harian</th>
                        <th class="center">UTS</th>
                        <th class="center">UAS</th>
                        <th class="center">Nilai Akhir</th>
                        <th class="center">Predikat</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilaiList as $i => $n)
                    <tr>
                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)">
                            {{ $i + 1 }}
                        </td>

                        <td>
                            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)">
                                {{ $n->mataPelajaran->nama_mapel ?? '—' }}
                            </p>
                            @if($n->mataPelajaran->kode_mapel ?? false)
                                <p style="font-size:11.5px;color:var(--text3);margin-top:1px">
                                    {{ $n->mataPelajaran->kode_mapel }}
                                </p>
                            @endif
                        </td>

                        @php
                            $nilaiClass = function($v) {
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

                        <td class="center">
                            <span class="nilai-pill {{ $nilaiClass($n->nilai_tugas) }}">
                                {{ $n->nilai_tugas !== null ? number_format($n->nilai_tugas, 0) : '—' }}
                            </span>
                        </td>
                        <td class="center">
                            <span class="nilai-pill {{ $nilaiClass($n->nilai_harian) }}">
                                {{ $n->nilai_harian !== null ? number_format($n->nilai_harian, 0) : '—' }}
                            </span>
                        </td>
                        <td class="center">
                            <span class="nilai-pill {{ $nilaiClass($n->nilai_uts) }}">
                                {{ $n->nilai_uts !== null ? number_format($n->nilai_uts, 0) : '—' }}
                            </span>
                        </td>
                        <td class="center">
                            <span class="nilai-pill {{ $nilaiClass($n->nilai_uas) }}">
                                {{ $n->nilai_uas !== null ? number_format($n->nilai_uas, 0) : '—' }}
                            </span>
                        </td>

                        <td class="center">
                            <span class="nilai-pill {{ $nilaiClass($n->nilai_akhir) }}" style="font-size:14px;min-width:50px">
                                {{ $n->nilai_akhir !== null ? number_format($n->nilai_akhir, 1) : '—' }}
                            </span>
                        </td>

                        <td class="center">
                            <span class="pred-badge pred-{{ $n->predikat ?? 'E' }}">
                                {{ $n->predikat ?? 'E' }}
                            </span>
                        </td>

                        <td style="font-size:12px;color:var(--text3);max-width:180px">
                            <p style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                                {{ $n->catatan ?? '—' }}
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
                                <p class="empty-title">Belum ada data nilai</p>
                                <p class="empty-sub">
                                    @if(request()->hasAny(['mapel_id','tahun_ajaran_id']))
                                        Coba ubah filter pencarian
                                    @else
                                        Data nilai belum tersedia untuk tahun ajaran ini
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Keterangan bobot --}}
        @if($nilaiList->count() > 0)
        <div style="padding:12px 20px;border-top:1px solid var(--border);background:var(--surface2);display:flex;flex-wrap:wrap;gap:16px">
            <p style="font-size:11.5px;color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600">
                Bobot Nilai Akhir:
            </p>
            <p style="font-size:11.5px;color:var(--text3)">Tugas <strong>20%</strong></p>
            <p style="font-size:11.5px;color:var(--text3)">Harian <strong>30%</strong></p>
            <p style="font-size:11.5px;color:var(--text3)">UTS <strong>20%</strong></p>
            <p style="font-size:11.5px;color:var(--text3)">UAS <strong>30%</strong></p>
        </div>
        @endif
    </div>

</div>
</x-app-layout>