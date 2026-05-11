<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
        --brand-100:#d9ebff;--brand-50:#eef6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --green:#15803d;--yellow:#a16207;--blue:#1d4ed8;--purple:#7c3aed;--red:#dc2626;--orange:#c2410c;
        --radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 48px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}

    /* ── Filter card ── */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row select,.filter-row input[type=date],.filter-row input[type=text]{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row select:focus,.filter-row input:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;display:inline-flex;align-items:center;gap:6px}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:5px}
    .btn-reset:hover{background:var(--surface3)}

    /* ── Toggle "saya saja" ── */
    .toggle-wrap{display:flex;align-items:center;gap:8px;padding:4px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);background:var(--surface2);cursor:pointer;transition:all .15s}
    .toggle-wrap:hover{background:var(--surface3)}
    .toggle-wrap input{display:none}
    .toggle-switch{width:32px;height:18px;background:var(--border2);border-radius:99px;position:relative;transition:background .2s;flex-shrink:0}
    .toggle-switch::after{content:'';position:absolute;width:12px;height:12px;background:#fff;border-radius:50%;top:3px;left:3px;transition:left .2s;box-shadow:0 1px 3px rgba(0,0,0,.2)}
    .toggle-wrap input:checked ~ .toggle-switch{background:var(--brand-600)}
    .toggle-wrap input:checked ~ .toggle-switch::after{left:17px}
    .toggle-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}

    /* ── Table card ── */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border)}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:10px 14px;vertical-align:middle}
    td.center{text-align:center}
    .name-col{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text)}
    .sub-col{font-size:11.5px;color:var(--text3);margin-top:1px}
    .time-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text2)}
    .date-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--text);white-space:nowrap}

    /* ── Badge ── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-hadir{background:#dcfce7;color:var(--green)} .badge-hadir .badge-dot{background:var(--green)}
    .badge-telat{background:#fefce8;color:var(--yellow)} .badge-telat .badge-dot{background:var(--yellow)}
    .badge-izin {background:#eff6ff;color:var(--blue)}  .badge-izin  .badge-dot{background:#3b82f6}
    .badge-sakit{background:#fdf4ff;color:var(--purple)} .badge-sakit .badge-dot{background:#a855f7}
    .badge-alfa {background:#fee2e2;color:var(--red)}   .badge-alfa  .badge-dot{background:var(--red)}
    .badge-cuti {background:#ffedd5;color:var(--orange)} .badge-cuti  .badge-dot{background:var(--orange)}
    .badge-dinas_luar{background:#d1fae5;color:#065f46} .badge-dinas_luar .badge-dot{background:#059669}
    .badge-qr   {background:#ecfdf5;color:#065f46}      .badge-qr    .badge-dot{background:#059669}
    .badge-manual{background:var(--surface3);color:var(--text2)} .badge-manual .badge-dot{background:var(--text3)}

    /* ── Empty ── */
    .empty-state{padding:56px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    /* ── Pagination ── */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none}
    .pag-btn:hover{background:var(--surface2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px}

    @media(max-width:640px){.page{padding:16px}}
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Riwayat Absensi Guru</h1>
            <p class="page-sub">Semua catatan kehadiran guru yang telah direkam</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('piket.absensi-guru.export-pdf', array_merge(request()->query(), ['tanggal' => request('tanggal_dari', today()->toDateString())])) }}"
               class="btn btn-secondary" target="_blank">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Export PDF
            </a>
            <a href="{{ route('piket.absensi-guru.massal.form') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Catat Absensi
            </a>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('piket.absensi-guru.riwayat') }}">
            <div class="filter-row">
                <select name="guru_id" style="min-width:180px">
                    <option value="">Semua Guru</option>
                    @foreach($guruList as $g)
                        <option value="{{ $g->id }}" {{ request('guru_id') == $g->id ? 'selected' : '' }}>{{ $g->nama_lengkap }}</option>
                    @endforeach
                </select>
                <select name="status" style="min-width:130px">
                    <option value="">Semua Status</option>
                    @foreach($statusList as $s)
                        <option value="{{ $s }}" {{ request('status') === $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
                <input type="date" name="tanggal_dari"   value="{{ request('tanggal_dari') }}"   title="Dari tanggal" style="width:148px">
                <input type="date" name="tanggal_sampai" value="{{ request('tanggal_sampai') }}" title="Sampai tanggal" style="width:148px">
                <label class="toggle-wrap" style="cursor:pointer">
                    <input type="checkbox" name="saya_saja" value="1"
                           {{ request()->boolean('saya_saja') ? 'checked' : '' }}
                           onchange="this.form.submit()">
                    <span class="toggle-switch"></span>
                    <span class="toggle-label">Catatan saya saja</span>
                </label>
                <div class="filter-sep"></div>
                @if(request()->hasAny(['guru_id','status','tanggal_dari','tanggal_sampai','saya_saja']))
                <a href="{{ route('piket.absensi-guru.riwayat') }}" class="btn-reset">
                    <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
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
                Riwayat Absensi
                @if($riwayat->total() > 0)
                    <span>— {{ $riwayat->firstItem() }}–{{ $riwayat->lastItem() }} dari {{ $riwayat->total() }} data</span>
                @else
                    <span>— tidak ada data</span>
                @endif
            </p>
            @if(request()->boolean('saya_saja'))
            <span style="background:var(--brand-50);color:var(--brand-700);font-size:11.5px;font-weight:700;padding:3px 10px;border-radius:99px;border:1px solid var(--brand-100)">
                Catatan Anda saja
            </span>
            @endif
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:44px">#</th>
                        <th>Nama Guru</th>
                        <th>Tanggal</th>
                        <th class="center">Status</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th class="center">Metode</th>
                        <th>Keterangan</th>
                        <th>Pencatat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $i => $a)
                    <tr>
                        <td style="font-size:12px;color:var(--text3);font-weight:700">{{ $riwayat->firstItem() + $i }}</td>
                        <td>
                            <p class="name-col">{{ $a->guru->nama_lengkap ?? '—' }}</p>
                            <p class="sub-col">{{ $a->guru->nip ?? 'NIP—' }}</p>
                        </td>
                        <td class="date-col">{{ \Carbon\Carbon::parse($a->tanggal)->locale('id')->isoFormat('D MMM Y') }}</td>
                        <td class="center">
                            <span class="badge badge-{{ $a->status }}">
                                <span class="badge-dot"></span>{{ ucfirst($a->status) }}
                            </span>
                        </td>
                        <td class="time-col">{{ $a->jam_masuk ? \Carbon\Carbon::parse($a->jam_masuk)->format('H:i') : '—' }}</td>
                        <td class="time-col">{{ $a->jam_keluar ? \Carbon\Carbon::parse($a->jam_keluar)->format('H:i') : '—' }}</td>
                        <td class="center">
                            @if($a->metode === 'qr')
                                <span class="badge badge-qr"><span class="badge-dot"></span>QR</span>
                            @else
                                <span class="badge badge-manual"><span class="badge-dot"></span>Manual</span>
                            @endif
                        </td>
                        <td style="font-size:12.5px;color:var(--text2);max-width:180px">
                            <p style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden">
                                {{ $a->keterangan ?: '—' }}
                            </p>
                        </td>
                        <td style="font-size:12px;color:var(--text3)">{{ $a->pencatat->name ?? '—' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                </div>
                                <p class="empty-title">Tidak ada data absensi</p>
                                <p class="empty-sub">Coba ubah filter atau catat absensi baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($riwayat->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $riwayat->firstItem() }} – {{ $riwayat->lastItem() }} dari {{ $riwayat->total() }}</p>
            <div class="pag-btns">
                @if($riwayat->onFirstPage())
                    <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $riwayat->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif
                @foreach($riwayat->getUrlRange(1, $riwayat->lastPage()) as $page => $url)
                    @if($page == $riwayat->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $riwayat->lastPage() || abs($page - $riwayat->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $riwayat->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach
                @if($riwayat->hasMorePages())
                    <a href="{{ $riwayat->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
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
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2800,showConfirmButton:false,toast:true,position:'top-end'});
@endif
</script>
</x-app-layout>