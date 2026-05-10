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
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .btn-detail:hover{background:#dcfce7;filter:none}
    .btn-nilai{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-nilai:hover{background:var(--brand-100);filter:none}
    .btn-nilai-done{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .btn-nilai-done:hover{background:#dcfce7;filter:none}

    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px}

    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row select,.filter-row input[type=text]{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row input[type=text]{min-width:200px}
    .filter-row select:focus,.filter-row input:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer}
    .btn-filter:hover{background:var(--brand-700)}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;text-decoration:none;display:inline-flex;align-items:center}
    .btn-reset:hover{background:var(--surface3)}

    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border)}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13.5px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:10px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)}
    .two-line .primary{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .two-line .secondary{font-size:12px;color:var(--text3);margin-top:1px}
    .action-group{display:flex;align-items:center;gap:5px;justify-content:center}

    .badge{display:inline-flex;align-items:center;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-belum_dikumpulkan{background:#f1f5f9;color:#64748b}
    .badge-dikumpulkan{background:#dbeafe;color:#1d4ed8}
    .badge-terlambat{background:#fff7ed;color:#c2410c}
    .badge-dinilai{background:#dcfce7;color:#15803d}

    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px;align-items:center}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;transition:all .15s;text-decoration:none}
    .pag-btn:hover{background:var(--surface2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;pointer-events:none}

    @media(max-width:900px){.stats-strip{grid-template-columns:1fr 1fr}}
    @media(max-width:640px){.page{padding:16px}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Pengumpulan Tugas</h1>
            <p class="page-sub">Kelola dan nilai pengumpulan tugas siswa</p>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
                <p class="stat-label">Total</p>
                <p class="stat-val">{{ $totalData }}</p>
                <p class="stat-sub">pengumpulan</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Sudah Dinilai</p>
                <p class="stat-val">{{ $totalDinilai }}</p>
                <p class="stat-sub">dari filter</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Masuk</p>
                <p class="stat-val">{{ $totalMasuk }}</p>
                <p class="stat-sub">dikumpulkan + terlambat</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background:#fff0f0">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-label">Terlambat</p>
                <p class="stat-val">{{ $totalTerlambat }}</p>
                <p class="stat-sub">dari filter</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('guru.pengumpulan-tugas.index') }}">
            <div class="filter-row">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / NIS siswa…">
                <select name="tugas_id">
                    <option value="">Semua Tugas</option>
                    @foreach($tugasList as $t)
                        <option value="{{ $t->id }}" {{ request('tugas_id') == $t->id ? 'selected' : '' }}>
                            {{ Str::limit($t->judul, 50) }}
                        </option>
                    @endforeach
                </select>
                <select name="status">
                    <option value="">Semua Status</option>
                    @foreach($statusList as $val => $label)
                        <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('guru.pengumpulan-tugas.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Data Pengumpulan
                @if($pengumpulanList->total() > 0)
                    <span>— {{ $pengumpulanList->firstItem() }}–{{ $pengumpulanList->lastItem() }} dari {{ $pengumpulanList->total() }} data</span>
                @else
                    <span>— tidak ada data</span>
                @endif
            </p>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Siswa</th>
                        <th>Tugas</th>
                        <th class="center">Status</th>
                        <th class="center">Nilai</th>
                        <th class="center">Dikumpulkan</th>
                        <th class="center" style="width:160px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengumpulanList as $index => $p)
                    <tr>
                        <td><span class="no-col">{{ $pengumpulanList->firstItem() + $index }}</span></td>
                        <td>
                            <div class="two-line">
                                <p class="primary">{{ $p->siswa->nama_lengkap ?? '—' }}</p>
                                <p class="secondary">NIS: {{ $p->siswa->nis ?? '—' }}</p>
                            </div>
                        </td>
                        <td>
                            <div class="two-line">
                                <p class="primary">{{ Str::limit($p->tugas->judul ?? '—', 45) }}</p>
                                <p class="secondary">
                                    @if($p->tugas?->batas_waktu)
                                        Batas: {{ \Carbon\Carbon::parse($p->tugas->batas_waktu)->locale('id')->isoFormat('D MMM Y, HH:mm') }}
                                    @else
                                        Tanpa batas waktu
                                    @endif
                                </p>
                            </div>
                        </td>
                        <td class="center">
                            @php
                                $labelMap = [
                                    'belum_dikumpulkan' => 'Belum',
                                    'dikumpulkan'       => 'Dikumpulkan',
                                    'terlambat'         => 'Terlambat',
                                    'dinilai'           => 'Dinilai',
                                ];
                            @endphp
                            <span class="badge badge-{{ $p->status }}">
                                {{ $labelMap[$p->status] ?? $p->status }}
                            </span>
                        </td>
                        <td class="center">
                            @if(! is_null($p->nilai))
                                @php $vc = $p->nilai >= 80 ? '#15803d' : ($p->nilai >= 65 ? '#a16207' : '#dc2626'); @endphp
                                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:13.5px;color:{{ $vc }}">
                                    {{ number_format($p->nilai, 1) }}
                                </span>
                            @else
                                <span style="color:var(--text3);font-size:12px">—</span>
                            @endif
                        </td>
                        <td class="center">
                            @if($p->dikumpulkan_pada)
                                <span style="font-size:12px;color:var(--text2)">
                                    {{ \Carbon\Carbon::parse($p->dikumpulkan_pada)->locale('id')->isoFormat('D MMM Y, HH:mm') }}
                                </span>
                            @else
                                <span style="color:var(--text3);font-size:12px">—</span>
                            @endif
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('guru.pengumpulan-tugas.show', $p->id) }}"
                                   class="btn btn-sm btn-detail">Detail</a>
                                @if(in_array($p->status, ['dikumpulkan', 'terlambat', 'dinilai']))
                                    <a href="{{ route('guru.pengumpulan-tugas.form-nilai', $p->id) }}"
                                       class="btn btn-sm {{ $p->status === 'dinilai' ? 'btn-nilai-done' : 'btn-nilai' }}">
                                        {{ $p->status === 'dinilai' ? 'Edit Nilai' : 'Beri Nilai' }}
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                </div>
                                <p class="empty-title">Belum ada pengumpulan tugas</p>
                                <p class="empty-sub">Pengumpulan tugas dari siswa akan muncul di sini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pengumpulanList->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $pengumpulanList->firstItem() }}–{{ $pengumpulanList->lastItem() }} dari {{ $pengumpulanList->total() }}</p>
            <div class="pag-btns">
                @if($pengumpulanList->onFirstPage())
                    <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $pengumpulanList->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($pengumpulanList->getUrlRange(1, $pengumpulanList->lastPage()) as $page => $url)
                    @if($page == $pengumpulanList->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $pengumpulanList->lastPage() || abs($page - $pengumpulanList->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $pengumpulanList->currentPage()) == 2)
                        <span style="color:var(--text3);padding:0 4px">…</span>
                    @endif
                @endforeach
                @if($pengumpulanList->hasMorePages())
                    <a href="{{ $pengumpulanList->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text: @json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text: @json(session('error')), confirmButtonColor:'#1f63db' });
@endif
</script>
</x-app-layout>