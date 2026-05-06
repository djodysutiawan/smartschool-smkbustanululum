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
    .page{padding:28px 28px 40px;}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2;}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-primary{background:var(--brand-600);color:#fff;}
    .btn-sm{padding:6px 12px;font-size:12px;border-radius:6px;}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}.btn-detail:hover{background:#dcfce7;filter:none;}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}.btn-del:hover{background:#fee2e2;filter:none;}
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}
    .stat-icon.green{background:#f0fdf4;}
    .stat-icon.orange{background:#fff7ed;}
    .stat-icon.purple{background:#fdf4ff;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:10px;}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px;}
    .table-wrap{overflow-x:auto;}
    table{width:100%;border-collapse:collapse;font-size:13.5px;}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border);}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap;}
    thead th.center{text-align:center;}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s;}
    tbody tr:last-child{border-bottom:none;}
    tbody tr:hover{background:#fafbff;}
    td{padding:10px 14px;color:var(--text);vertical-align:middle;}
    td.center{text-align:center;}
    td.muted{color:var(--text3);}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3);}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-selesai{background:#dcfce7;color:#15803d;}.badge-selesai .badge-dot{background:#15803d;}
    .badge-diproses{background:#fefce8;color:#a16207;}.badge-diproses .badge-dot{background:#ca8a04;}
    .badge-draft{background:#f1f5f9;color:#64748b;}.badge-draft .badge-dot{background:#94a3b8;}
    .badge-dibatalkan{background:#fff0f0;color:#dc2626;}.badge-dibatalkan .badge-dot{background:#dc2626;}
    .action-group{display:flex;align-items:center;gap:5px;flex-wrap:wrap;}
    .empty-state{padding:60px 20px;text-align:center;}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px;}
    .empty-sub{font-size:13px;color:var(--text3);}
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px;}
    .pag-info{font-size:12.5px;color:var(--text3);}
    .pag-btns{display:flex;gap:4px;align-items:center;}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;text-decoration:none;}
    .pag-btn:hover{background:var(--surface2);}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff;}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none;}
    .stat-mini{display:flex;align-items:center;gap:10px;}
    .stat-mini-item{display:flex;flex-direction:column;align-items:center;}
    .stat-mini-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;}
    .stat-mini-lbl{font-size:10px;color:var(--text3);font-weight:600;text-transform:uppercase;letter-spacing:.04em;}
    @media(max-width:640px){.stats-strip{grid-template-columns:1fr 1fr;}.page{padding:16px;}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Kenaikan Kelas</h1>
            <p class="page-sub">Riwayat proses kenaikan & kelulusan siswa per tahun ajaran</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.kenaikan-kelas.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Proses Baru
            </a>
        </div>
    </div>

    @php
        $allBatch   = $batch->getCollection();
        $totalNaik  = $allBatch->sum('naik_kelas');
        $totalTdkNaik = $allBatch->sum('tidak_naik');
        $totalLulus = $allBatch->sum('lulus');
        $totalSiswa = $allBatch->sum('total_siswa');
    @endphp

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M5 15l7-7 7 7"/></svg>
            </div>
            <div><p class="stat-label">Total Proses</p><p class="stat-val">{{ $batch->total() }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M5 15l7-7 7 7"/></svg>
            </div>
            <div><p class="stat-label">Total Naik</p><p class="stat-val">{{ $totalNaik }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="18" height="18" fill="none" stroke="#ea580c" stroke-width="1.8" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
            </div>
            <div><p class="stat-label">Tidak Naik</p><p class="stat-val">{{ $totalTdkNaik }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div><p class="stat-label">Total Lulus</p><p class="stat-val">{{ $totalLulus }}</p></div>
        </div>
    </div>

    @if(session('success'))
    <div style="display:flex;align-items:center;gap:10px;padding:12px 16px;background:#f0fdf4;border:1px solid #bbf7d0;color:#15803d;border-radius:var(--radius);margin-bottom:16px;font-size:13px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="display:flex;align-items:center;gap:10px;padding:12px 16px;background:#fff0f0;border:1px solid #fecaca;color:#dc2626;border-radius:var(--radius);margin-bottom:16px;font-size:13px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
    </div>
    @endif

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">Riwayat Kenaikan Kelas
                @if($batch->total())
                    <span>— menampilkan {{ $batch->firstItem() }}–{{ $batch->lastItem() }} dari {{ $batch->total() }} proses</span>
                @endif
            </p>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Tingkat</th>
                        <th>Tahun Ajaran Asal</th>
                        <th>Tahun Ajaran Tujuan</th>
                        <th class="center">Total Siswa</th>
                        <th class="center">Hasil</th>
                        <th>Status</th>
                        <th>Diproses Oleh</th>
                        <th>Tanggal</th>
                        <th class="center" style="width:150px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($batch as $idx => $item)
                    <tr>
                        <td><span class="no-col">{{ $batch->firstItem() + $idx }}</span></td>
                        <td>
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text);">
                                {{ $item->label_tingkat }}
                            </span>
                        </td>
                        <td class="muted" style="font-size:12.5px;">{{ optional($item->tahunAjaranAsal)->nama ?? '—' }}</td>
                        <td class="muted" style="font-size:12.5px;">{{ optional($item->tahunAjaranTujuan)->nama ?? '—' }}</td>
                        <td class="center">
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;">{{ $item->total_siswa }}</span>
                        </td>
                        <td class="center">
                            <div class="stat-mini">
                                <div class="stat-mini-item">
                                    <span class="stat-mini-val" style="color:#15803d;">{{ $item->naik_kelas }}</span>
                                    <span class="stat-mini-lbl">Naik</span>
                                </div>
                                <div style="width:1px;height:24px;background:var(--border);"></div>
                                <div class="stat-mini-item">
                                    <span class="stat-mini-val" style="color:#ea580c;">{{ $item->tidak_naik }}</span>
                                    <span class="stat-mini-lbl">Tdk Naik</span>
                                </div>
                                <div style="width:1px;height:24px;background:var(--border);"></div>
                                <div class="stat-mini-item">
                                    <span class="stat-mini-val" style="color:#7c3aed;">{{ $item->lulus }}</span>
                                    <span class="stat-mini-lbl">Lulus</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            @php
                                $badgeCls = match($item->status) {
                                    'selesai'    => 'badge-selesai',
                                    'diproses'   => 'badge-diproses',
                                    'dibatalkan' => 'badge-dibatalkan',
                                    default      => 'badge-draft',
                                };
                                $badgeLbl = match($item->status) {
                                    'selesai'    => 'Selesai',
                                    'diproses'   => 'Diproses',
                                    'dibatalkan' => 'Dibatalkan',
                                    default      => 'Draft',
                                };
                            @endphp
                            <span class="badge {{ $badgeCls }}">
                                <span class="badge-dot"></span>{{ $badgeLbl }}
                            </span>
                        </td>
                        <td style="font-size:12.5px;">{{ optional($item->diprosesOleh)->name ?? '—' }}</td>
                        <td style="font-size:12px;color:var(--text3);">{{ $item->diproses_pada?->format('d M Y') }}</td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('admin.kenaikan-kelas.show', $item) }}" class="btn btn-sm btn-detail">Detail</a>
                                @if(! $item->isSelesai() && ! $item->isDibatalkan())
                                    <form method="POST" action="{{ route('admin.kenaikan-kelas.batalkan', $item) }}"
                                          id="batalForm-{{ $item->id }}">
                                        @csrf
                                        <button type="button" class="btn btn-sm btn-del"
                                            onclick="confirmBatal(document.getElementById('batalForm-{{ $item->id }}'), '{{ $item->label_tingkat }}')">
                                            Batalkan
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M5 15l7-7 7 7"/></svg>
                                </div>
                                <p class="empty-title">Belum ada proses kenaikan kelas</p>
                                <p class="empty-sub">Klik "Proses Baru" untuk memulai proses kenaikan kelas pertama</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($batch->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $batch->firstItem() }} – {{ $batch->lastItem() }} dari {{ $batch->total() }} proses</p>
            <div class="pag-btns">
                <a href="{{ $batch->previousPageUrl() ?? '#' }}" class="pag-btn {{ $batch->onFirstPage() ? 'disabled' : '' }}">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                </a>
                @foreach($batch->getUrlRange(1, $batch->lastPage()) as $page => $url)
                    @if($page == $batch->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $batch->lastPage() || abs($page - $batch->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $batch->currentPage()) == 2)
                        <span style="color:var(--text3);font-size:13px;padding:0 4px;">…</span>
                    @endif
                @endforeach
                <a href="{{ $batch->nextPageUrl() ?? '#' }}" class="pag-btn {{ !$batch->hasMorePages() ? 'disabled' : '' }}">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif

    function confirmBatal(form, label) {
        Swal.fire({
            title: 'Batalkan Proses?',
            text: `Proses "${label}" akan dibatalkan. Tindakan ini tidak dapat diurungkan.`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Batalkan!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>