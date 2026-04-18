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
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none}.breadcrumb a:hover{color:var(--brand-600)}
    .breadcrumb .sep{color:var(--border2)}.breadcrumb .current{color:var(--text2)}
    .page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}.btn-back:hover{background:var(--surface3);filter:none}
    .btn-checkout{background:var(--brand-600);color:#fff}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}.btn-del:hover{background:#fee2e2;filter:none}
    .btn-pdf{background:#fdf4ff;color:#7c3aed;border:1px solid #e9d5ff}.btn-pdf:hover{background:#f3e8ff;filter:none}
    .detail-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .card-header{padding:16px 24px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:10px}
    .card-header-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .card-body{padding:24px}
    .dl-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px}
    .dl-item{}
    .dl-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;margin-bottom:5px}
    .dl-value{font-family:'DM Sans',sans-serif;font-size:14px;font-weight:500;color:var(--text)}
    .dl-value.large{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800}
    .dl-span2{grid-column:span 2}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;white-space:nowrap}
    .badge-dot{width:6px;height:6px;border-radius:50%}
    .badge-masuk{background:#dcfce7;color:#15803d}.badge-masuk .badge-dot{background:#15803d}
    .badge-keluar{background:var(--brand-50);color:var(--brand-700)}.badge-keluar .badge-dot{background:var(--brand-600)}
    .badge-belum{background:#f1f5f9;color:var(--text3)}.badge-belum .badge-dot{background:var(--text3)}
    .badge-pagi{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa}
    .badge-siang{background:#fefce8;color:#a16207;border:1px solid #fde68a}
    .timeline{display:flex;align-items:center;gap:0;margin:8px 0}
    .tl-step{display:flex;flex-direction:column;align-items:center;flex:1}
    .tl-circle{width:40px;height:40px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700}
    .tl-circle.done{background:#dcfce7;color:#15803d;border:2px solid #86efac}
    .tl-circle.empty{background:var(--surface3);color:var(--text3);border:2px dashed var(--border2)}
    .tl-line{flex:1;height:2px;background:var(--border);margin-bottom:20px}
    .tl-line.done{background:#86efac}
    .tl-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);margin-top:6px}
    .tl-time{font-family:'DM Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text);margin-top:2px}
    .durasi-box{background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius-sm);padding:12px 16px;display:flex;align-items:center;gap:10px;margin-top:8px}
    .durasi-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--brand-700)}
    .durasi-sub{font-size:12px;color:var(--brand-700);opacity:.7;margin-top:2px}
    .catatan-box{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:12px 16px;font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text2);line-height:1.6;margin-top:4px}
    .action-bar{display:flex;gap:10px;flex-wrap:wrap;padding:16px 24px;border-top:1px solid var(--border);background:var(--surface2)}
    @media(max-width:600px){.dl-grid{grid-template-columns:1fr}.dl-span2{grid-column:span 1}.page{padding:16px 16px 40px}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.log-piket.index') }}">Log Piket</a>
        <span class="sep">›</span>
        <span class="current">Detail Log #{{ $logPiket->id }}</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Log Piket</h1>
            <p class="page-sub">Informasi lengkap catatan piket guru</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <a href="{{ route('admin.log-piket.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.log-piket.export-pdf-single', $logPiket->id) }}" class="btn btn-pdf" target="_blank">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Export PDF
            </a>
        </div>
    </div>

    <div class="detail-card">
        <div class="card-header">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            <span class="card-header-title">Informasi Guru & Status</span>
        </div>
        <div class="card-body">
            <div class="dl-grid">
                <div class="dl-item">
                    <p class="dl-label">Nama Guru</p>
                    <p class="dl-value large">{{ $logPiket->guru->nama_lengkap ?? '-' }}</p>
                </div>
                <div class="dl-item">
                    <p class="dl-label">NIP</p>
                    <p class="dl-value">{{ $logPiket->guru->nip ?? '-' }}</p>
                </div>
                <div class="dl-item">
                    <p class="dl-label">Tanggal Piket</p>
                    <p class="dl-value">{{ \Carbon\Carbon::parse($logPiket->tanggal)->translatedFormat('l, d F Y') }}</p>
                </div>
                <div class="dl-item">
                    <p class="dl-label">Shift</p>
                    @if($logPiket->shift == 'pagi')
                        <span class="badge badge-pagi">Pagi</span>
                    @elseif($logPiket->shift == 'siang')
                        <span class="badge badge-siang">Siang</span>
                    @else
                        <p class="dl-value">-</p>
                    @endif
                </div>
                <div class="dl-item">
                    <p class="dl-label">Status</p>
                    @if($logPiket->keluar_pada)
                        <span class="badge badge-keluar"><span class="badge-dot"></span>Selesai Bertugas</span>
                    @elseif($logPiket->masuk_pada)
                        <span class="badge badge-masuk"><span class="badge-dot"></span>Sedang Bertugas</span>
                    @else
                        <span class="badge badge-belum"><span class="badge-dot"></span>Belum Masuk</span>
                    @endif
                </div>
                <div class="dl-item">
                    <p class="dl-label">Dicatat Oleh</p>
                    <p class="dl-value">{{ $logPiket->pengguna->name ?? '-' }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="card-header">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <span class="card-header-title">Timeline Waktu</span>
        </div>
        <div class="card-body">
            <div class="timeline">
                <div class="tl-step">
                    <div class="tl-circle {{ $logPiket->masuk_pada ? 'done' : 'empty' }}">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <p class="tl-label">CHECK-IN</p>
                    <p class="tl-time">{{ $logPiket->masuk_pada ? \Carbon\Carbon::parse($logPiket->masuk_pada)->format('H:i') : '—' }}</p>
                </div>
                <div class="tl-line {{ $logPiket->masuk_pada ? 'done' : '' }}"></div>
                <div class="tl-step">
                    <div class="tl-circle {{ $logPiket->keluar_pada ? 'done' : 'empty' }}">
                        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                    </div>
                    <p class="tl-label">CHECK-OUT</p>
                    <p class="tl-time">{{ $logPiket->keluar_pada ? \Carbon\Carbon::parse($logPiket->keluar_pada)->format('H:i') : '—' }}</p>
                </div>
            </div>

            @if($logPiket->masuk_pada && $logPiket->keluar_pada)
            @php
                $durasi = \Carbon\Carbon::parse($logPiket->masuk_pada)->diff(\Carbon\Carbon::parse($logPiket->keluar_pada));
                $jam = $durasi->h; $menit = $durasi->i;
            @endphp
            <div class="durasi-box">
                <svg width="20" height="20" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                <div>
                    <p class="durasi-val">{{ $jam }}j {{ $menit }}m</p>
                    <p class="durasi-sub">Total durasi piket</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    @if($logPiket->catatan)
    <div class="detail-card">
        <div class="card-header">
            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
            <span class="card-header-title">Catatan</span>
        </div>
        <div class="card-body">
            <div class="catatan-box">{{ $logPiket->catatan }}</div>
        </div>
    </div>
    @endif

    <div class="detail-card">
        <div class="action-bar">
            @if($logPiket->masuk_pada && !$logPiket->keluar_pada)
            <form action="{{ route('admin.log-piket.check-out', $logPiket->id) }}" method="POST" id="coForm">
                @csrf @method('PATCH')
                <button type="button" class="btn btn-checkout" onclick="confirmCheckout()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                    Catat Check-Out Sekarang
                </button>
            </form>
            @endif
            <form action="{{ route('admin.log-piket.destroy', $logPiket->id) }}" method="POST" id="delForm">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete()">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                    Hapus Log
                </button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
    @endif
    @if(session('error'))
    Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
    @endif

    function confirmCheckout() {
        Swal.fire({
            title:'Konfirmasi Check-Out?',
            text:'Catat waktu keluar untuk guru ini sekarang?',
            icon:'question',showCancelButton:true,
            confirmButtonColor:'#1f63db',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Check-Out!',cancelButtonText:'Batal',
        }).then(r => { if(r.isConfirmed) document.getElementById('coForm').submit(); });
    }

    function confirmDelete() {
        Swal.fire({
            title:'Hapus Log Piket?',
            text:'Log piket ini akan dihapus permanen.',
            icon:'warning',showCancelButton:true,
            confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal',
        }).then(r => { if(r.isConfirmed) document.getElementById('delForm').submit(); });
    }
</script>
</x-app-layout>