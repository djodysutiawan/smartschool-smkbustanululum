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
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .btn-detail:hover{background:#dcfce7;filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}
    .btn-nonaktif{background:#fefce8;color:#a16207;border:1px solid #fde68a}
    .btn-nonaktif:hover{background:#fef9c3;filter:none}
    .btn-print{background:#faf5ff;color:#7c3aed;border:1px solid #e9d5ff}
    .btn-print:hover{background:#f3e8ff;filter:none}

    .stats-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;transition:box-shadow .2s}
    .stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.blue{background:#eff6ff}.stat-icon.green{background:#f0fdf4}.stat-icon.red{background:#fff0f0}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px}

    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row select,.filter-row input{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row select:focus,.filter-row input:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center}

    /* Card grid untuk sesi QR */
    .sesi-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:14px;margin-top:0}
    .sesi-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;transition:box-shadow .2s}
    .sesi-card:hover{box-shadow:0 4px 20px rgba(0,0,0,.08)}
    .sesi-card-header{padding:16px 18px 12px;display:flex;align-items:flex-start;justify-content:space-between;gap:10px}
    .sesi-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text);line-height:1.3}
    .sesi-card-sub{font-size:12px;color:var(--text3);margin-top:2px}
    .sesi-card-body{padding:0 18px 14px;display:flex;flex-direction:column;gap:8px}
    .sesi-info-row{display:flex;align-items:center;gap:6px;font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text2)}
    .sesi-info-row svg{flex-shrink:0;color:var(--text3)}
    .sesi-card-footer{padding:12px 18px;border-top:1px solid var(--surface3);display:flex;gap:6px;flex-wrap:wrap}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-aktif  {background:#dcfce7;color:#15803d} .badge-aktif   .badge-dot{background:#15803d}
    .badge-expired{background:#fee2e2;color:#dc2626} .badge-expired .badge-dot{background:#dc2626}

    .kode-qr{font-family:'DM Sans',monospace;font-size:11.5px;background:var(--surface2);padding:4px 8px;border-radius:5px;color:var(--text2);letter-spacing:.05em;border:1px solid var(--border)}

    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 0;flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px;align-items:center}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none}
    .pag-btn:hover{background:var(--surface2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px}

    @media(max-width:640px){.stats-strip{grid-template-columns:1fr}.page{padding:16px}.sesi-grid{grid-template-columns:1fr}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Buat Sesi QR</h1>
            <p class="page-sub">Kelola sesi QR code untuk absensi digital siswa</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.sesi-qr.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Buat Sesi QR Baru
            </a>
        </div>
    </div>

    {{-- Stats --}}
    @php
        $userId     = auth()->id();
        $totalSesi  = $sesiQrs->total();
        $totalAktif = \App\Models\SesiQr::where('dibuat_oleh',$userId)->where('is_active',true)->where('kadaluarsa_pada','>=',now())->count();
        $totalExp   = \App\Models\SesiQr::where('dibuat_oleh',$userId)->where(fn($q)=>$q->where('is_active',false)->orWhere('kadaluarsa_pada','<',now()))->count();
    @endphp
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            </div>
            <div><p class="stat-label">Total Sesi</p><p class="stat-val">{{ $totalSesi }}</p><p class="stat-sub">semua sesi</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div><p class="stat-label">Aktif</p><p class="stat-val">{{ $totalAktif }}</p><p class="stat-sub">masih berlaku</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div><p class="stat-label">Kedaluwarsa</p><p class="stat-val">{{ $totalExp }}</p><p class="stat-sub">tidak aktif</p></div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('guru.sesi-qr.index') }}">
            <div class="filter-row">
                <select name="kelas_id">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" style="width:148px">
                <select name="is_active">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
                <div class="filter-sep"></div>
                <a href="{{ route('guru.sesi-qr.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- Card Grid --}}
    @if($sesiQrs->count() > 0)
    <div class="sesi-grid">
        @foreach($sesiQrs as $s)
        @php $isExpired = \Carbon\Carbon::parse($s->kadaluarsa_pada)->isPast() || !$s->is_active; @endphp
        <div class="sesi-card">
            <div class="sesi-card-header">
                <div style="flex:1;overflow:hidden">
                    <p class="sesi-card-title">{{ $s->kelas->nama_kelas ?? '—' }}</p>
                    <p class="sesi-card-sub">{{ $s->mataPelajaran->nama_mapel ?? 'Semua Mapel' }}</p>
                </div>
                <span class="badge {{ $isExpired ? 'badge-expired' : 'badge-aktif' }}">
                    <span class="badge-dot"></span>{{ $isExpired ? 'Kedaluwarsa' : 'Aktif' }}
                </span>
            </div>
            <div class="sesi-card-body">
                <div class="sesi-info-row">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    {{ \Carbon\Carbon::parse($s->tanggal)->format('d M Y') }}
                </div>
                <div class="sesi-info-row">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    {{ \Carbon\Carbon::parse($s->berlaku_mulai)->format('H:i') }} — {{ \Carbon\Carbon::parse($s->kadaluarsa_pada)->format('H:i') }}
                </div>
                @if($s->radius_meter)
                <div class="sesi-info-row">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="10" r="3"/><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 1 0-16 0c0 3 2.7 6.9 8 11.7z"/></svg>
                    Radius {{ $s->radius_meter }}m
                </div>
                @endif
                <div class="sesi-info-row">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
                    <span class="kode-qr">{{ $s->kode_qr ?? '—' }}</span>
                </div>
                @php $scanCount = $s->riwayatScan->count() ?? 0; @endphp
                <div class="sesi-info-row">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    {{ $scanCount }} scan masuk
                </div>
            </div>
            <div class="sesi-card-footer">
                <a href="{{ route('guru.sesi-qr.show', $s->id) }}" class="btn btn-sm btn-detail">Detail</a>
                <a href="{{ route('guru.sesi-qr.cetak-qr', $s->id) }}" target="_blank" class="btn btn-sm btn-print">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Cetak QR
                </a>
                @if(!$isExpired)
                <form action="{{ route('guru.sesi-qr.nonaktifkan', $s->id) }}" method="POST" style="display:inline">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-nonaktif">Nonaktifkan</button>
                </form>
                @endif
                <form action="{{ route('guru.sesi-qr.destroy', $s->id) }}" method="POST" id="delSesi-{{ $s->id }}" style="display:inline">
                    @csrf @method('DELETE')
                    <button type="button" class="btn btn-sm btn-del"
                        onclick="confirmDelete(document.getElementById('delSesi-{{ $s->id }}'),'{{ $s->kelas->nama_kelas ?? '' }}','{{ \Carbon\Carbon::parse($s->tanggal)->format('d M Y') }}')">
                        Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>

    @if($sesiQrs->hasPages())
    <div class="pag-wrap">
        <p class="pag-info">Menampilkan {{ $sesiQrs->firstItem() }} – {{ $sesiQrs->lastItem() }} dari {{ $sesiQrs->total() }} sesi</p>
        <div class="pag-btns">
            @if($sesiQrs->onFirstPage())
                <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
            @else
                <a href="{{ $sesiQrs->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
            @endif
            @foreach($sesiQrs->getUrlRange(1, $sesiQrs->lastPage()) as $page => $url)
                @if($page == $sesiQrs->currentPage())
                    <span class="pag-btn active">{{ $page }}</span>
                @elseif($page == 1 || $page == $sesiQrs->lastPage() || abs($page - $sesiQrs->currentPage()) <= 1)
                    <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                @elseif(abs($page - $sesiQrs->currentPage()) == 2)
                    <span class="pag-ellipsis">…</span>
                @endif
            @endforeach
            @if($sesiQrs->hasMorePages())
                <a href="{{ $sesiQrs->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
            @else
                <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
            @endif
        </div>
    </div>
    @endif

    @else
    <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius)">
        <div class="empty-state">
            <div class="empty-icon">
                <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            </div>
            <p class="empty-title">Belum ada sesi QR</p>
            <p class="empty-sub">Buat sesi QR baru untuk mengaktifkan absensi digital</p>
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2800,showConfirmButton:false,toast:true,position:'top-end'});
@endif
@if(session('error'))
Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
@endif

function confirmDelete(form, kelas, tanggal) {
    Swal.fire({
        title:'Hapus Sesi QR?',
        html:`Sesi QR kelas <strong>${kelas}</strong> tanggal <strong>${tanggal}</strong> akan dihapus permanen.`,
        icon:'warning',showCancelButton:true,
        confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',
        confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal',
    }).then(r => { if(r.isConfirmed) form.submit(); });
}
</script>
</x-app-layout>