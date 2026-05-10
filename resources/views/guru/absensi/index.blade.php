<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --green:#15803d;--yellow:#a16207;--blue:#1d4ed8;--purple:#7c3aed;--red:#dc2626;
        --radius:10px;--radius-sm:7px;
    }

    /* ── Layout ── */
    .page{padding:28px 28px 48px;max-width:100%}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    /* ── Buttons ── */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-ghost{background:transparent;color:var(--text2);border:1px solid var(--border)}
    .btn-ghost:hover{background:var(--surface2);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-edit:hover{background:var(--brand-100);filter:none}
    .btn-del{background:#fff0f0;color:var(--red);border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}
    .btn-detail{background:#f0fdf4;color:var(--green);border:1px solid #bbf7d0}
    .btn-detail:hover{background:#dcfce7;filter:none}

    /* ── Stats ── */
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:22px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;display:flex;align-items:center;gap:14px;transition:box-shadow .2s,transform .15s}
    .stat-card:hover{box-shadow:0 6px 20px rgba(0,0,0,.07);transform:translateY(-1px)}
    .stat-icon{width:42px;height:42px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.green{background:#f0fdf4} .stat-icon.yellow{background:#fefce8}
    .stat-icon.blue{background:#eff6ff}  .stat-icon.red{background:#fff0f0}
    .stat-body{}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px}

    /* ── Filter card ── */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row select,.filter-row input[type=text],.filter-row input[type=date]{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s,background .15s}
    .filter-row select:focus,.filter-row input:focus{border-color:var(--brand-500);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1)}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:6px;transition:background .15s}
    .btn-filter:hover{background:var(--brand-700)}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:background .15s}
    .btn-reset:hover{background:var(--surface3)}

    /* ── Table card ── */
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
    td.muted{color:var(--text3);font-size:12.5px}

    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3)}
    .two-line .primary{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .two-line .secondary{font-size:11.5px;color:var(--text3);margin-top:1px}

    /* ── Badges ── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-hadir{background:#dcfce7;color:var(--green)}   .badge-hadir .badge-dot{background:var(--green)}
    .badge-telat{background:#fefce8;color:var(--yellow)}  .badge-telat .badge-dot{background:var(--yellow)}
    .badge-izin {background:#eff6ff;color:var(--blue)}    .badge-izin  .badge-dot{background:#3b82f6}
    .badge-sakit{background:#fdf4ff;color:var(--purple)}  .badge-sakit .badge-dot{background:#a855f7}
    .badge-alfa {background:#fee2e2;color:var(--red)}     .badge-alfa  .badge-dot{background:var(--red)}
    .badge-manual{background:var(--surface3);color:var(--text2)} .badge-manual .badge-dot{background:var(--text3)}
    .badge-qr   {background:#ecfdf5;color:#065f46}        .badge-qr    .badge-dot{background:#059669}

    .action-group{display:flex;align-items:center;gap:5px;justify-content:center;flex-wrap:nowrap}

    /* ── Empty ── */
    .empty-state{padding:64px 20px;text-align:center}
    .empty-icon{width:60px;height:60px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    /* ── Pagination ── */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px;align-items:center}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none}
    .pag-btn:hover{background:var(--surface2);border-color:var(--border2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px}

    @media(max-width:900px){.stats-strip{grid-template-columns:1fr 1fr}}
    @media(max-width:640px){.stats-strip{grid-template-columns:1fr 1fr}.page{padding:16px}}
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Catat Absensi</h1>
            <p class="page-sub">Kelola dan pantau kehadiran siswa di kelas Anda</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.absensi.rekap') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Rekap Kelas
            </a>
            <a href="{{ route('guru.absensi.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Catat Absensi
            </a>
        </div>
    </div>

    {{-- Stats Hari Ini --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="20" height="20" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div class="stat-body">
                <p class="stat-label">Hadir</p>
                <p class="stat-val">{{ $rekap['hadir'] }}</p>
                <p class="stat-sub">hari ini</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="20" height="20" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div class="stat-body">
                <p class="stat-label">Izin</p>
                <p class="stat-val">{{ $rekap['izin'] }}</p>
                <p class="stat-sub">hari ini</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="20" height="20" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 12h-4l-3 9L9 3l-3 9H2"/></svg>
            </div>
            <div class="stat-body">
                <p class="stat-label">Sakit</p>
                <p class="stat-val">{{ $rekap['sakit'] }}</p>
                <p class="stat-sub">hari ini</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="20" height="20" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
            </div>
            <div class="stat-body">
                <p class="stat-label">Alfa</p>
                <p class="stat-val">{{ $rekap['alfa'] }}</p>
                <p class="stat-sub">hari ini</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('guru.absensi.index') }}">
            <div class="filter-row">
                <select name="kelas_id" style="min-width:150px">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
                <select name="status" style="min-width:130px">
                    <option value="">Semua Status</option>
                    @foreach($statusList as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <input type="date" name="tanggal_dari"   value="{{ request('tanggal_dari') }}"   style="width:148px" title="Dari tanggal">
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" style="width:148px" title="Sampai tanggal">
                <input type="text" name="search"         value="{{ request('search') }}"          style="min-width:180px" placeholder="Cari nama siswa…">
                <div class="filter-sep"></div>
                @if(request()->hasAny(['kelas_id','status','tanggal_dari','tanggal_sampai','search']))
                <a href="{{ route('guru.absensi.index') }}" class="btn-reset">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Reset
                </a>
                @endif
                <button type="submit" class="btn-filter">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    Terapkan
                </button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Absensi
                @if($absensi->total() > 0)
                    <span>— {{ $absensi->firstItem() }}–{{ $absensi->lastItem() }} dari {{ $absensi->total() }} data</span>
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
                        <th>Tanggal</th>
                        <th class="center">Status</th>
                        <th class="center">Metode</th>
                        <th>Jam Masuk</th>
                        <th>Keterangan</th>
                        <th class="center" style="width:180px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi as $index => $a)
                    <tr>
                        <td><span class="no-col">{{ $absensi->firstItem() + $index }}</span></td>
                        <td>
                            <div class="two-line">
                                <p class="primary">{{ $a->siswa->nama_lengkap ?? '—' }}</p>
                                <p class="secondary">NIS: {{ $a->siswa->nis ?? '—' }}</p>
                            </div>
                        </td>
                        <td class="muted">{{ $a->kelas->nama_kelas ?? '—' }}</td>
                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:13px;white-space:nowrap">
                            {{ \Carbon\Carbon::parse($a->tanggal)->locale('id')->isoFormat('D MMM Y') }}
                        </td>
                        <td class="center">
                            <span class="badge badge-{{ $a->status }}">
                                <span class="badge-dot"></span>{{ ucfirst($a->status) }}
                            </span>
                        </td>
                        <td class="center">
                            @if($a->metode === 'qr' || $a->metode === 'qr_scan')
                                <span class="badge badge-qr"><span class="badge-dot"></span>QR Code</span>
                            @elseif($a->metode === 'manual')
                                <span class="badge badge-manual"><span class="badge-dot"></span>Manual</span>
                            @elseif($a->metode)
                                <span class="badge badge-manual"><span class="badge-dot"></span>{{ ucfirst($a->metode) }}</span>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>
                        <td class="muted">{{ $a->jam_masuk ? \Carbon\Carbon::parse($a->jam_masuk)->format('H:i') : '—' }}</td>
                        <td style="font-size:12.5px;color:var(--text2);max-width:180px">
                            <p style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;line-height:1.4">
                                {{ $a->keterangan ?? '—' }}
                            </p>
                        </td>
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('guru.absensi.show', $a->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                <a href="{{ route('guru.absensi.edit', $a->id) }}"  class="btn btn-sm btn-edit">Edit</a>
                                <form action="{{ route('guru.absensi.destroy', $a->id) }}" method="POST"
                                      id="del-{{ $a->id }}" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(
                                            document.getElementById('del-{{ $a->id }}'),
                                            '{{ addslashes($a->siswa->nama_lengkap ?? '') }}',
                                            '{{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}'
                                        )">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="26" height="26" fill="none" stroke="#94a3b8" stroke-width="1.6" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                </div>
                                <p class="empty-title">Belum ada data absensi</p>
                                <p class="empty-sub">Coba ubah filter atau catat absensi baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($absensi->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $absensi->firstItem() }} – {{ $absensi->lastItem() }} dari {{ $absensi->total() }}</p>
            <div class="pag-btns">
                @if($absensi->onFirstPage())
                    <span class="pag-btn disabled">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $absensi->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                @foreach($absensi->getUrlRange(1, $absensi->lastPage()) as $page => $url)
                    @if($page == $absensi->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $absensi->lastPage() || abs($page - $absensi->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $absensi->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach

                @if($absensi->hasMorePages())
                    <a href="{{ $absensi->nextPageUrl() }}" class="pag-btn">
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
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2800,showConfirmButton:false,toast:true,position:'top-end'});
@endif
@if(session('error'))
Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
@endif

function confirmDelete(form, nama, tanggal) {
    Swal.fire({
        title: 'Hapus Absensi?',
        html: `Absensi <strong>${nama}</strong> tanggal <strong>${tanggal}</strong> akan dihapus permanen.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) form.submit(); });
}
</script>
</x-app-layout>