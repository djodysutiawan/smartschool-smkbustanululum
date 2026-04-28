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
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-edit:hover{background:var(--brand-100);filter:none}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .btn-detail:hover{background:#dcfce7;filter:none}
    .btn-selesai{background:#fefce8;color:#a16207;border:1px solid #fde68a}
    .btn-selesai:hover{background:#fef9c3;filter:none}

    .checkin-banner{display:flex;align-items:center;gap:12px;padding:12px 18px;background:#fefce8;border:1px solid #fde68a;border-radius:var(--radius);margin-bottom:20px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:#92400e}
    .checkin-banner svg{flex-shrink:0}

    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;transition:box-shadow .2s}
    .stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.blue{background:#eff6ff}
    .stat-icon.yellow{background:#fefce8}
    .stat-icon.green{background:#f0fdf4}
    .stat-icon.purple{background:#faf5ff}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px}

    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row select,.filter-row input[type=date],.filter-row input[type=text]{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row input[type=date]{width:148px}
    .filter-row input[type=text]{min-width:200px}
    .filter-row select:focus,.filter-row input:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s}
    .btn-filter:hover{background:var(--brand-700)}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:background .15s}
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
    td.muted{color:var(--text3)}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-pending  {background:#fef9c3;color:#a16207}   .badge-pending  .badge-dot{background:#a16207}
    .badge-diproses {background:#eff6ff;color:#1d4ed8}   .badge-diproses .badge-dot{background:#1d4ed8}
    .badge-selesai  {background:#dcfce7;color:#15803d}   .badge-selesai  .badge-dot{background:#15803d}
    .badge-banding  {background:#fdf4ff;color:#7c3aed}   .badge-banding  .badge-dot{background:#7c3aed}

    .poin-pill{display:inline-flex;align-items:center;justify-content:center;min-width:36px;height:24px;padding:0 8px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800}
    .poin-low  {background:#dcfce7;color:#15803d}
    .poin-mid  {background:#fef9c3;color:#a16207}
    .poin-high {background:#fee2e2;color:#dc2626}

    .two-line .primary{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .two-line .secondary{font-size:12px;color:var(--text3);margin-top:1px}

    .action-group{display:flex;align-items:center;gap:5px;justify-content:center;flex-wrap:wrap}

    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px;align-items:center}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none}
    .pag-btn:hover{background:var(--surface2);border-color:var(--border2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px}

    .selesai-form-wrap{display:none;margin-top:8px;padding:10px 12px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm)}
    .selesai-form-wrap.open{display:block}
    .selesai-form-wrap textarea{width:100%;min-height:64px;padding:8px 10px;border:1px solid var(--border);border-radius:6px;font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text);resize:vertical;outline:none;transition:border-color .15s;box-sizing:border-box}
    .selesai-form-wrap textarea:focus{border-color:var(--brand-500);background:#fff}
    .selesai-form-actions{display:flex;gap:6px;margin-top:8px;justify-content:flex-end}

    @media(max-width:640px){
        .stats-strip{grid-template-columns:1fr 1fr}
        .page{padding:16px}
        .header-actions{width:100%}
    }
</style>

<div class="page">

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Riwayat Pelanggaran</h1>
            <p class="page-sub">
                @if($guruAktifId)
                    Daftar pelanggaran siswa yang Anda catat
                @else
                    Data pelanggaran hari ini (read-only — belum check-in)
                @endif
            </p>
        </div>
        <div class="header-actions">
            @if($guruAktifId)
                <a href="{{ route('piket.pelanggaran.create') }}" class="btn btn-primary">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                        <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                    </svg>
                    Input Pelanggaran
                </a>
            @endif
        </div>
    </div>

    {{-- ── Banner belum check-in ── --}}
    @if(!$guruAktifId)
    <div class="checkin-banner">
        <svg width="16" height="16" fill="none" stroke="#a16207" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="12" r="10"/>
            <line x1="12" y1="8" x2="12" y2="12"/>
            <line x1="12" y1="16" x2="12.01" y2="16"/>
        </svg>
        Anda belum check-in hari ini. Data yang ditampilkan adalah seluruh pelanggaran hari ini (mode baca saja).
        Check-in terlebih dahulu untuk mencatat atau mengelola pelanggaran.
    </div>
    @endif

    {{-- ── Stats ── --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                    <rect x="9" y="3" width="6" height="4" rx="1"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Total Catatan</p>
                <p class="stat-val">{{ $stats['total'] }}</p>
                <p class="stat-sub">{{ $guruAktifId ? 'semua waktu' : 'hari ini (semua guru)' }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Diproses</p>
                <p class="stat-val">{{ $stats['diproses'] }}</p>
                <p class="stat-sub">menunggu tindak lanjut</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24">
                    <rect x="3" y="4" width="18" height="18" rx="2"/>
                    <line x1="16" y1="2" x2="16" y2="6"/>
                    <line x1="8" y1="2" x2="8" y2="6"/>
                    <line x1="3" y1="10" x2="21" y2="10"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Bulan Ini</p>
                <p class="stat-val">{{ $stats['bulan_ini'] }}</p>
                <p class="stat-sub">{{ now()->translatedFormat('F Y') }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Selesai</p>
                <p class="stat-val">{{ $stats['selesai'] }}</p>
                <p class="stat-sub">sudah ditindaklanjuti</p>
            </div>
        </div>
    </div>

    {{-- ── Filter ── --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('piket.pelanggaran.index') }}">
            <div class="filter-row">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama / NIS siswa…">

                <select name="kelas_id">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                <select name="kategori_id">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoriList as $kat)
                        <option value="{{ $kat->id }}" {{ request('kategori_id') == $kat->id ? 'selected' : '' }}>
                            {{ $kat->nama }}
                        </option>
                    @endforeach
                </select>

                <select name="status">
                    <option value="">Semua Status</option>
                    @foreach($statusList as $s)
                        <option value="{{ $s }}" {{ request('status') == $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                    @endforeach
                </select>

                <input type="date" name="tanggal_dari"   value="{{ request('tanggal_dari') }}">
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}">

                <div class="filter-sep"></div>
                <a href="{{ route('piket.pelanggaran.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- ── Table ── --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                {{ $guruAktifId ? 'Riwayat Pelanggaran Saya' : 'Pelanggaran Hari Ini (Semua Guru)' }}
                @if($pelanggaran->total() > 0)
                    <span>— menampilkan {{ $pelanggaran->firstItem() }}–{{ $pelanggaran->lastItem() }} dari {{ $pelanggaran->total() }} data</span>
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
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Kategori</th>
                        <th class="center">Poin</th>
                        <th>Tanggal</th>
                        <th class="center">Status</th>
                        <th>Deskripsi</th>
                        <th class="center" style="width:200px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pelanggaran as $index => $p)
                    <tr>
                        <td><span class="no-col">{{ $pelanggaran->firstItem() + $index }}</span></td>

                        <td>
                            <div class="two-line">
                                <p class="primary">{{ $p->siswa->nama_lengkap ?? '—' }}</p>
                                <p class="secondary">NIS: {{ $p->siswa->nis ?? '—' }}</p>
                            </div>
                        </td>

                        <td class="muted" style="font-size:12.5px">{{ $p->siswa->kelas->nama_kelas ?? '—' }}</td>

                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text)">
                            {{ $p->kategori->nama ?? '—' }}
                        </td>

                        <td class="center">
                            @php
                                $poinClass = $p->poin <= 10 ? 'poin-low' : ($p->poin <= 30 ? 'poin-mid' : 'poin-high');
                            @endphp
                            <span class="poin-pill {{ $poinClass }}">{{ $p->poin }}</span>
                        </td>

                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:13px">
                            {{ \Carbon\Carbon::parse($p->tanggal)->format('d M Y') }}
                        </td>

                        <td class="center">
                            <span class="badge badge-{{ $p->status }}">
                                <span class="badge-dot"></span>
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>

                        <td style="font-size:12.5px;color:var(--text2);max-width:160px">
                            <p style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                                {{ $p->deskripsi ?? '—' }}
                            </p>
                        </td>

                        <td class="center">
                            <div class="action-group">
                                {{-- Detail: semua bisa lihat --}}
                                <a href="{{ route('piket.pelanggaran.show', $p->id) }}" class="btn btn-sm btn-detail">Detail</a>

                                {{--
                                    Edit & Selesaikan: hanya jika sudah check-in
                                    dan $p->dicatat_oleh (FK ke users.id) === $guruAktifId (user->id yang sedang login)
                                --}}
                                @if($guruAktifId && $p->dicatat_oleh === $guruAktifId)
                                    @if($p->status === 'pending')
                                        <a href="{{ route('piket.pelanggaran.edit', $p->id) }}" class="btn btn-sm btn-edit">Edit</a>
                                    @endif

                                    @if(in_array($p->status, ['pending', 'diproses']))
                                        <button type="button" class="btn btn-sm btn-selesai"
                                            onclick="toggleSelesai('selesai-{{ $p->id }}')">
                                            Selesaikan
                                        </button>
                                    @endif
                                @endif
                            </div>

                            {{-- Inline selesaikan form — hanya owner --}}
                            @if($guruAktifId && $p->dicatat_oleh === $guruAktifId && in_array($p->status, ['pending', 'diproses']))
                            <div id="selesai-{{ $p->id }}" class="selesai-form-wrap">
                                <form action="{{ route('piket.pelanggaran.selesaikan', $p->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <textarea name="tindakan" placeholder="Catatan tindakan (opsional)…">{{ $p->tindakan }}</textarea>
                                    <div class="selesai-form-actions">
                                        <button type="button" class="btn btn-sm btn-secondary"
                                            onclick="toggleSelesai('selesai-{{ $p->id }}')">Batal</button>
                                        <button type="submit" class="btn btn-sm" style="background:#15803d;color:#fff;border:none">
                                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                                <polyline points="20 6 9 17 4 12"/>
                                            </svg>
                                            Konfirmasi
                                        </button>
                                    </div>
                                </form>
                            </div>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path d="M9 5H7a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-2"/>
                                        <rect x="9" y="3" width="6" height="4" rx="1"/>
                                    </svg>
                                </div>
                                <p class="empty-title">Belum ada riwayat pelanggaran</p>
                                <p class="empty-sub">Coba ubah filter atau catat pelanggaran baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($pelanggaran->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">
                Menampilkan {{ $pelanggaran->firstItem() }} – {{ $pelanggaran->lastItem() }}
                dari {{ $pelanggaran->total() }} pelanggaran
            </p>
            <div class="pag-btns">
                @if($pelanggaran->onFirstPage())
                    <span class="pag-btn disabled">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $pelanggaran->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                @foreach($pelanggaran->getUrlRange(1, $pelanggaran->lastPage()) as $page => $url)
                    @if($page == $pelanggaran->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $pelanggaran->lastPage() || abs($page - $pelanggaran->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $pelanggaran->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach

                @if($pelanggaran->hasMorePages())
                    <a href="{{ $pelanggaran->nextPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                @else
                    <span class="pag-btn disabled">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </span>
                @endif
            </div>
        </div>
        @endif
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

function toggleSelesai(id) {
    const el = document.getElementById(id);
    el.classList.toggle('open');
    if (el.classList.contains('open')) {
        el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}
</script>
</x-app-layout>