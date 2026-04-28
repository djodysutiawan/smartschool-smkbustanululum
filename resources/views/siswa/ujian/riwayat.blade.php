<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand:#1f63db;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px}
    *{box-sizing:border-box}
    .page{padding:28px 28px 60px;max-width:1200px;margin:0 auto}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;font-family:'DM Sans',sans-serif}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-sm{padding:6px 14px;font-size:12.5px}
    .btn-outline{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}.btn-outline:hover{background:var(--surface3);filter:none}
    .btn-detail{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}.btn-detail:hover{background:var(--brand-100);filter:none}
    .stat-row{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.green{background:#f0fdf4}.stat-icon.red{background:#fff0f0}.stat-icon.blue{background:var(--brand-50)}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border)}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13.5px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid var(--surface3);transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:12px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)}
    .ujian-wrap .uname{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .ujian-wrap .umapel{font-size:11.5px;color:var(--text3);margin-top:1px;font-family:'DM Sans',sans-serif}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-dot{width:5px;height:5px;border-radius:50%}
    .b-lulus{background:#dcfce7;color:#15803d}.b-lulus .badge-dot{background:#15803d}
    .b-tidak-lulus{background:#fee2e2;color:#dc2626}.b-tidak-lulus .badge-dot{background:#dc2626}
    .b-habis{background:#fef9c3;color:#a16207}.b-habis .badge-dot{background:#a16207}
    .nilai-box{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800}
    .nilai-box.lulus{color:#15803d}.nilai-box.tidak-lulus{color:#dc2626}
    .jenis-pill{display:inline-block;padding:2px 8px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700}
    .j-ulangan_harian{background:#fef9c3;color:#a16207}
    .j-uts{background:var(--brand-50);color:var(--brand-700)}
    .j-uas{background:#f0fdf4;color:#15803d}
    .j-kuis,.j-quiz{background:#fdf4ff;color:#7c3aed}
    .j-remedial{background:#fff7ed;color:#ea580c}
    .empty-state{padding:80px 20px;text-align:center}
    .empty-icon{width:60px;height:60px;background:var(--brand-50);border-radius:16px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:16px;color:var(--text);margin-bottom:6px}
    .empty-sub{font-size:13px;color:var(--text3);font-family:'DM Sans',sans-serif}
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3);font-family:'DM Sans',sans-serif}
    .pag-btns{display:flex;gap:4px}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;text-decoration:none;transition:all .15s}
    .pag-btn:hover{background:var(--surface2)}.pag-btn.active{background:var(--brand);border-color:var(--brand);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;display:flex;align-items:center}
    @media(max-width:768px){.stat-row{grid-template-columns:1fr 1fr}.page{padding:16px}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Riwayat Ujian</h1>
            <p class="page-sub">Semua ujian yang sudah Anda kerjakan</p>
        </div>
        <a href="{{ route('siswa.ujian.index') }}" class="btn btn-outline btn-sm">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Ujian Tersedia
        </a>
    </div>

    @if($sesiList->total() > 0)
    @php
        $totalLulus    = $sesiList->getCollection()->where('lulus', true)->count();
        $totalTdkLulus = $sesiList->getCollection()->where('lulus', false)->count();
        $rataRata      = $sesiList->getCollection()->whereNotNull('nilai_akhir')->avg('nilai_akhir');
    @endphp
    <div class="stat-row">
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div><p class="stat-label">Lulus</p><p class="stat-val" style="color:#15803d">{{ $totalLulus }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
            </div>
            <div><p class="stat-label">Tidak Lulus</p><p class="stat-val" style="color:#dc2626">{{ $totalTdkLulus }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            </div>
            <div>
                <p class="stat-label">Rata-rata Nilai</p>
                <p class="stat-val">{{ $rataRata ? number_format($rataRata, 1) : '—' }}</p>
            </div>
        </div>
    </div>
    @endif

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Riwayat Pengerjaan
                <span>— {{ $sesiList->firstItem() ?? 0 }}–{{ $sesiList->lastItem() ?? 0 }} dari {{ $sesiList->total() }} ujian</span>
            </p>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Ujian</th>
                        <th class="center">Jenis</th>
                        <th class="center">Nilai</th>
                        <th class="center">Benar</th>
                        <th class="center">Salah</th>
                        <th class="center">Kosong</th>
                        <th class="center">Status</th>
                        <th>Diselesaikan</th>
                        <th class="center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sesiList as $idx => $s)
                    @php
                        $lulus      = $s->lulus ?? false;
                        $jenis      = $s->ujian->jenis ?? '';
                        $jenisLabel = ['ulangan_harian'=>'UH','uts'=>'UTS','uas'=>'UAS','kuis'=>'Kuis','quiz'=>'Quiz','remedial'=>'Rem'][$jenis] ?? strtoupper($jenis);
                    @endphp
                    <tr>
                        <td><span class="no-col">{{ $sesiList->firstItem() + $idx }}</span></td>
                        <td>
                            <div class="ujian-wrap">
                                <p class="uname">{{ $s->ujian->judul ?? '—' }}</p>
                                <p class="umapel">{{ $s->ujian->mataPelajaran->nama_mapel ?? '—' }}</p>
                            </div>
                        </td>
                        <td class="center">
                            <span class="jenis-pill j-{{ $jenis }}">{{ $jenisLabel }}</span>
                        </td>
                        <td class="center">
                            @if($s->ujian && ($s->ujian->tampilkan_nilai ?? true))
                                <span class="nilai-box {{ $lulus ? 'lulus' : 'tidak-lulus' }}">
                                    {{ number_format($s->nilai_akhir ?? 0, 1) }}
                                </span>
                            @else
                                <span style="color:var(--text3);font-size:13px">—</span>
                            @endif
                        </td>
                        <td class="center" style="color:#15803d;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif">{{ $s->total_benar ?? 0 }}</td>
                        <td class="center" style="color:#dc2626;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif">{{ $s->total_salah ?? 0 }}</td>
                        <td class="center" style="color:var(--text3);font-family:'DM Sans',sans-serif">{{ $s->total_kosong ?? 0 }}</td>
                        <td class="center">
                            @if($s->status === 'habis_waktu')
                                <span class="badge b-habis"><span class="badge-dot"></span>Habis Waktu</span>
                            @elseif($lulus)
                                <span class="badge b-lulus"><span class="badge-dot"></span>Lulus</span>
                            @else
                                <span class="badge b-tidak-lulus"><span class="badge-dot"></span>Tidak Lulus</span>
                            @endif
                        </td>
                        <td style="font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text3)">
                            {{ $s->selesai_pada ? $s->selesai_pada->translatedFormat('d M Y, H:i') : '—' }}
                        </td>
                        <td class="center">
                            @if($s->ujian && ($s->ujian->tampilkan_nilai ?? true))
                                <a href="{{ route('siswa.ujian.hasil', $s->ujian_id) }}" class="btn btn-detail btn-sm">
                                    Lihat Hasil
                                </a>
                            @else
                                <span style="font-size:12px;color:var(--text3)">—</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="26" height="26" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                                </div>
                                <p class="empty-title">Belum ada riwayat ujian</p>
                                <p class="empty-sub">Anda belum menyelesaikan ujian apapun.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($sesiList->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $sesiList->firstItem() }}–{{ $sesiList->lastItem() }} dari {{ $sesiList->total() }}</p>
            <div class="pag-btns">
                @if($sesiList->onFirstPage())
                    <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $sesiList->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($sesiList->getUrlRange(1, $sesiList->lastPage()) as $page => $url)
                    @if($page == $sesiList->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $sesiList->lastPage() || abs($page - $sesiList->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $sesiList->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($sesiList->hasMorePages())
                    <a href="{{ $sesiList->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>
</x-app-layout>