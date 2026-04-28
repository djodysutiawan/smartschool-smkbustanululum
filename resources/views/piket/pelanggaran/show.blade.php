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

    .page{padding:28px 28px 40px;max-width:2000px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap}

    .breadcrumb{display:flex;align-items:center;gap:6px;margin-bottom:20px;flex-wrap:wrap}
    .breadcrumb a{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--brand-600);text-decoration:none}
    .breadcrumb a:hover{text-decoration:underline}
    .breadcrumb-sep{color:var(--text3);font-size:12px}
    .breadcrumb-cur{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3)}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-edit:hover{background:var(--brand-100);filter:none}
    .btn-selesai{background:#fefce8;color:#a16207;border:1px solid #fde68a}
    .btn-selesai:hover{background:#fef9c3;filter:none}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;white-space:nowrap}
    .badge-dot{width:6px;height:6px;border-radius:50%;flex-shrink:0}
    .badge-pending  {background:#fef9c3;color:#a16207}   .badge-pending  .badge-dot{background:#a16207}
    .badge-diproses {background:#eff6ff;color:#1d4ed8}   .badge-diproses .badge-dot{background:#1d4ed8}
    .badge-selesai  {background:#dcfce7;color:#15803d}   .badge-selesai  .badge-dot{background:#15803d}
    .badge-banding  {background:#fdf4ff;color:#7c3aed}   .badge-banding  .badge-dot{background:#7c3aed}

    .poin-big{display:inline-flex;align-items:center;justify-content:center;width:52px;height:52px;border-radius:12px;font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800}
    .poin-low  {background:#dcfce7;color:#15803d}
    .poin-mid  {background:#fef9c3;color:#a16207}
    .poin-high {background:#fee2e2;color:#dc2626}

    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .card-body{padding:20px}

    .detail-grid{display:grid;grid-template-columns:1fr 1fr;gap:0}
    .detail-item{padding:12px 0;border-bottom:1px solid var(--border)}
    .detail-item:nth-last-child(-n+2){border-bottom:none}
    .detail-item.col-span-2{grid-column:span 2}
    .detail-item.col-span-2:last-child{border-bottom:none}
    .detail-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;margin-bottom:5px}
    .detail-value{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);font-weight:500}
    .detail-value.bold{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700}
    .detail-value.muted{color:var(--text3);font-style:italic}

    .siswa-profile{display:flex;align-items:center;gap:14px;padding:16px 20px}
    .siswa-avatar{width:48px;height:48px;border-radius:12px;background:var(--brand-100);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--brand-700)}
    .siswa-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text)}
    .siswa-meta{font-size:12.5px;color:var(--text3);margin-top:2px}
    .siswa-kelas{display:inline-flex;align-items:center;gap:4px;margin-top:4px;padding:2px 9px;background:var(--surface3);border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text2)}

    .poin-total-wrap{padding:14px 20px;border-top:1px solid var(--border);background:var(--surface2)}
    .poin-total-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;margin-bottom:6px}
    .poin-total-row{display:flex;align-items:center;gap:10px}
    .poin-bar-track{flex:1;height:8px;background:var(--border);border-radius:99px;overflow:hidden}
    .poin-bar-fill{height:100%;border-radius:99px;transition:width .6s cubic-bezier(.4,0,.2,1)}
    .poin-total-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;min-width:60px;text-align:right}

    .selesai-card{background:var(--surface);border:2px solid #fde68a;border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .selesai-card-header{padding:12px 20px;background:#fefce8;border-bottom:1px solid #fde68a;display:flex;align-items:center;gap:8px}
    .selesai-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:#92400e}
    .selesai-card-body{padding:20px}
    .form-control{width:100%;padding:10px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface);outline:none;resize:vertical;min-height:80px;transition:border-color .15s;box-sizing:border-box}
    .form-control:focus{border-color:var(--brand-500);box-shadow:0 0 0 3px rgba(53,130,240,.12)}
    .form-hint{font-family:'DM Sans',sans-serif;font-size:11.5px;color:var(--text3);margin-top:5px}
    .selesai-actions{display:flex;gap:8px;margin-top:14px;justify-content:flex-end}

    .timeline{padding:4px 0}
    .tl-item{display:flex;gap:12px;padding:10px 0;position:relative}
    .tl-item:not(:last-child)::after{content:'';position:absolute;left:15px;top:34px;bottom:-10px;width:1px;background:var(--border)}
    .tl-dot{width:30px;height:30px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;border:2px solid var(--border)}
    .tl-dot.blue{background:#eff6ff;border-color:#bfdbfe}
    .tl-dot.yellow{background:#fefce8;border-color:#fde68a}
    .tl-dot.green{background:#dcfce7;border-color:#bbf7d0}
    .tl-dot.purple{background:#fdf4ff;border-color:#e9d5ff}
    .tl-content{flex:1;padding-top:4px}
    .tl-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .tl-time{font-size:11.5px;color:var(--text3);margin-top:1px}
    .tl-desc{font-size:12.5px;color:var(--text2);margin-top:4px;padding:8px 10px;background:var(--surface2);border-radius:6px;border:1px solid var(--border)}

    @media(max-width:640px){
        .page{padding:16px}
        .detail-grid{grid-template-columns:1fr}
        .detail-item.col-span-2{grid-column:span 1}
        .detail-item:nth-last-child(-n+2){border-bottom:1px solid var(--border)}
        .detail-item:last-child{border-bottom:none}
    }
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        {{-- piket.pelanggaran.index → GET /piket/pelanggaran --}}
        <a href="{{ route('piket.pelanggaran.index') }}">Riwayat Pelanggaran</a>
        <span class="breadcrumb-sep">›</span>
        <span class="breadcrumb-cur">Detail #{{ $pelanggaran->id }}</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Pelanggaran</h1>
            <p class="page-sub">Dicatat pada {{ \Carbon\Carbon::parse($pelanggaran->tanggal)->translatedFormat('l, d F Y') }}</p>
        </div>
        <div class="header-actions">
            {{-- Edit: piket.pelanggaran.edit → GET /piket/pelanggaran/{pelanggaran}/edit --}}
            @if($pelanggaran->status === 'pending')
                <a href="{{ route('piket.pelanggaran.edit', $pelanggaran->id) }}" class="btn btn-edit">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                    </svg>
                    Edit
                </a>
            @endif

            @if(in_array($pelanggaran->status, ['pending', 'diproses']))
                <button type="button" class="btn btn-selesai" onclick="toggleSelesaiCard()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <polyline points="20 6 9 17 4 12"/>
                    </svg>
                    Selesaikan
                </button>
            @endif

            {{-- Kembali: piket.pelanggaran.index → GET /piket/pelanggaran --}}
            <a href="{{ route('piket.pelanggaran.index') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <polyline points="15 18 9 12 15 6"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- ── Selesaikan Form ── --}}
    @if(in_array($pelanggaran->status, ['pending', 'diproses']))
    <div class="selesai-card" id="selesaiCard" style="display:none">
        <div class="selesai-card-header">
            <svg width="14" height="14" fill="none" stroke="#a16207" stroke-width="2.5" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span class="selesai-card-title">Selesaikan Pelanggaran Ini</span>
        </div>
        <div class="selesai-card-body">
            {{-- piket.pelanggaran.selesaikan → PATCH /piket/pelanggaran/{pelanggaran}/selesaikan --}}
            <form action="{{ route('piket.pelanggaran.selesaikan', $pelanggaran->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <label style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);display:block;margin-bottom:5px">
                    Catatan Tindakan
                </label>
                <textarea name="tindakan" class="form-control"
                    placeholder="Tuliskan tindakan yang telah diambil sebagai tindak lanjut pelanggaran ini…">{{ $pelanggaran->tindakan }}</textarea>
                <p class="form-hint">Kolom ini opsional. Jika sudah terisi di atas, bisa langsung dikonfirmasi.</p>
                <div class="selesai-actions">
                    <button type="button" class="btn btn-secondary" onclick="toggleSelesaiCard()">Batal</button>
                    <button type="submit" class="btn btn-primary" style="background:#15803d">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                        Konfirmasi Selesai
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    {{-- ── Siswa Card ── --}}
    <div class="card">
        <div class="card-header">
            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                <circle cx="12" cy="7" r="4"/>
            </svg>
            <span class="card-title">Informasi Siswa</span>
        </div>
        <div class="siswa-profile">
            <div class="siswa-avatar">
                {{ strtoupper(substr($pelanggaran->siswa->nama_lengkap ?? '?', 0, 1)) }}
            </div>
            <div>
                <p class="siswa-name">{{ $pelanggaran->siswa->nama_lengkap ?? '—' }}</p>
                <p class="siswa-meta">NIS: {{ $pelanggaran->siswa->nis ?? '—' }}</p>
                <span class="siswa-kelas">
                    <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                    {{ $pelanggaran->siswa->kelas->nama_kelas ?? '—' }}
                </span>
            </div>
        </div>

        @php
            $maxPoin   = 100;
            $poinPct   = min(100, ($totalPoinSiswa / $maxPoin) * 100);
            $poinColor = $totalPoinSiswa <= 30 ? '#15803d' : ($totalPoinSiswa <= 60 ? '#a16207' : '#dc2626');
        @endphp
        <div class="poin-total-wrap">
            <p class="poin-total-label">Total Akumulasi Poin Pelanggaran Siswa</p>
            <div class="poin-total-row">
                <div class="poin-bar-track">
                    <div class="poin-bar-fill" style="width:{{ $poinPct }}%;background:{{ $poinColor }}"></div>
                </div>
                <span class="poin-total-val" style="color:{{ $poinColor }}">{{ $totalPoinSiswa }} poin</span>
            </div>
        </div>
    </div>

    {{-- ── Detail Pelanggaran ── --}}
    <div class="card">
        <div class="card-header">
            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                <rect x="9" y="3" width="6" height="4" rx="1"/>
            </svg>
            <span class="card-title">Detail Pelanggaran</span>
            <div style="margin-left:auto">
                <span class="badge badge-{{ $pelanggaran->status }}">
                    <span class="badge-dot"></span>
                    {{ ucfirst($pelanggaran->status) }}
                </span>
            </div>
        </div>
        <div class="card-body">
            <div class="detail-grid">

                <div class="detail-item">
                    <p class="detail-label">Kategori Pelanggaran</p>
                    <p class="detail-value bold">{{ $pelanggaran->kategori->nama ?? '—' }}</p>
                </div>

                <div class="detail-item">
                    <p class="detail-label">Poin</p>
                    <div style="display:flex;align-items:center;gap:10px;margin-top:2px">
                        @php
                            $poinClass = $pelanggaran->poin <= 20 ? 'poin-low' : ($pelanggaran->poin <= 50 ? 'poin-mid' : 'poin-high');
                        @endphp
                        <span class="poin-big {{ $poinClass }}">{{ $pelanggaran->poin }}</span>
                        <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;color:var(--text3)">
                            poin pelanggaran
                        </span>
                    </div>
                </div>

                <div class="detail-item">
                    <p class="detail-label">Tanggal Kejadian</p>
                    <p class="detail-value">{{ \Carbon\Carbon::parse($pelanggaran->tanggal)->translatedFormat('d F Y') }}</p>
                </div>

                <div class="detail-item">
                    <p class="detail-label">Dicatat Oleh</p>
                    {{--
                        Relasi dicatatOleh() → belongsTo(User::class, 'dicatat_oleh')
                        Kolom di DB: dicatat_oleh (bukan dicatat_oleh_guru_id)
                    --}}
                    <p class="detail-value bold">{{ $pelanggaran->dicatatOleh->name ?? '—' }}</p>
                </div>

                <div class="detail-item col-span-2">
                    <p class="detail-label">Deskripsi Pelanggaran</p>
                    <p class="detail-value" style="line-height:1.6;white-space:pre-line">{{ $pelanggaran->deskripsi ?? '—' }}</p>
                </div>

                <div class="detail-item col-span-2">
                    <p class="detail-label">Tindakan yang Diambil</p>
                    @if($pelanggaran->tindakan)
                        <p class="detail-value" style="line-height:1.6;white-space:pre-line">{{ $pelanggaran->tindakan }}</p>
                    @else
                        <p class="detail-value muted">Belum ada tindakan yang dicatat</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- ── Timeline Status ── --}}
    <div class="card">
        <div class="card-header">
            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
            </svg>
            <span class="card-title">Riwayat Status</span>
        </div>
        <div class="card-body">
            <div class="timeline">

                <div class="tl-item">
                    <div class="tl-dot blue">
                        <svg width="13" height="13" fill="none" stroke="#1d4ed8" stroke-width="2.5" viewBox="0 0 24 24">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                    </div>
                    <div class="tl-content">
                        <p class="tl-title">Pelanggaran Dicatat</p>
                        <p class="tl-time">
                            {{ \Carbon\Carbon::parse($pelanggaran->created_at)->translatedFormat('d F Y, H:i') }}
                            &middot; oleh <strong>{{ $pelanggaran->dicatatOleh->name ?? '—' }}</strong>
                        </p>
                    </div>
                </div>

                @if(in_array($pelanggaran->status, ['diproses', 'selesai', 'banding']))
                <div class="tl-item">
                    <div class="tl-dot yellow">
                        <svg width="13" height="13" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <polyline points="12 6 12 12 16 14"/>
                        </svg>
                    </div>
                    <div class="tl-content">
                        <p class="tl-title">Sedang Diproses</p>
                        <p class="tl-time">Status berubah ke <em>diproses</em></p>
                    </div>
                </div>
                @endif

                @if($pelanggaran->status === 'selesai')
                <div class="tl-item">
                    <div class="tl-dot green">
                        <svg width="13" height="13" fill="none" stroke="#15803d" stroke-width="2.5" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                    <div class="tl-content">
                        <p class="tl-title">Pelanggaran Diselesaikan</p>
                        <p class="tl-time">
                            {{ $pelanggaran->updated_at
                                ? \Carbon\Carbon::parse($pelanggaran->updated_at)->translatedFormat('d F Y, H:i')
                                : '—' }}
                        </p>
                        @if($pelanggaran->tindakan)
                            <div class="tl-desc">{{ $pelanggaran->tindakan }}</div>
                        @endif
                    </div>
                </div>
                @endif

                @if($pelanggaran->status === 'banding')
                <div class="tl-item">
                    <div class="tl-dot purple">
                        <svg width="13" height="13" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>
                    <div class="tl-content">
                        <p class="tl-title">Dalam Proses Banding</p>
                        <p class="tl-time">Siswa mengajukan banding atas pelanggaran ini</p>
                    </div>
                </div>
                @endif

                @if($pelanggaran->status === 'pending')
                <div class="tl-item">
                    <div class="tl-dot yellow">
                        <svg width="13" height="13" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/>
                            <line x1="12" y1="8" x2="12" y2="12"/>
                            <line x1="12" y1="16" x2="12.01" y2="16"/>
                        </svg>
                    </div>
                    <div class="tl-content">
                        <p class="tl-title" style="color:var(--text3)">Menunggu tindak lanjut…</p>
                        <p class="tl-time">Klik <strong>Selesaikan</strong> untuk menyelesaikan pelanggaran ini</p>
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({
    icon: 'success', title: 'Berhasil!',
    text: @json(session('success')),
    timer: 2800, showConfirmButton: false,
    toast: true, position: 'top-end'
});
@endif
@if(session('error'))
Swal.fire({
    icon: 'error', title: 'Gagal!',
    text: @json(session('error')),
    confirmButtonColor: '#1f63db'
});
@endif

function toggleSelesaiCard() {
    const card = document.getElementById('selesaiCard');
    const isHidden = card.style.display === 'none';
    card.style.display = isHidden ? 'block' : 'none';
    if (isHidden) card.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}
</script>
</x-app-layout>