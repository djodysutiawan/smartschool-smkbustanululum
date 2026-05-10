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

    /* ── Layout ────────────────────────────────────────────────────────────── */
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    /* ── Buttons ───────────────────────────────────────────────────────────── */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-edit:hover{background:var(--brand-100);filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .btn-detail:hover{background:#dcfce7;filter:none}
    /* Sembunyikan = kuning, Publikasikan = hijau */
    .btn-toggle-on {background:#fefce8;color:#a16207;border:1px solid #fde68a}
    .btn-toggle-on:hover{background:#fef9c3;filter:none}
    .btn-toggle-off{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .btn-toggle-off:hover{background:#dcfce7;filter:none}

    /* ── Stats Strip ───────────────────────────────────────────────────────── */
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;transition:box-shadow .2s}
    .stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.blue  {background:#eff6ff}
    .stat-icon.green {background:#f0fdf4}
    .stat-icon.red   {background:#fff0f0}
    .stat-icon.yellow{background:#fefce8}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px}

    /* ── Filter ────────────────────────────────────────────────────────────── */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row select,.filter-row input[type=text]{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;cursor:pointer}
    .filter-row input[type=text]{cursor:text;min-width:200px}
    .filter-row select:focus,.filter-row input:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s}
    .btn-filter:hover{background:var(--brand-700)}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:background .15s}
    .btn-reset:hover{background:var(--surface3)}

    /* ── Table ─────────────────────────────────────────────────────────────── */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:8px}
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

    /* ── Badges ────────────────────────────────────────────────────────────── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-publish { background:#dcfce7; color:#15803d; }
    .badge-publish  .badge-dot { background:#15803d; }
    .badge-draft   { background:#f1f5f9; color:#64748b; }
    .badge-draft    .badge-dot { background:#94a3b8; }
    .badge-jenis   { background:#eff6ff; color:#1d4ed8; border:1px solid #bfdbfe; }

    /* ── Deadline coloring ─────────────────────────────────────────────────── */
    .deadline-expired { color:#dc2626; font-weight:700; }
    .deadline-soon    { color:#d97706; font-weight:600; }
    .deadline-ok      { color:var(--text2); }

    /* ── Two-line cell ─────────────────────────────────────────────────────── */
    .two-line .primary{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .two-line .secondary{font-size:12px;color:var(--text3);margin-top:2px;display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden;max-width:300px}

    /* ── Action group ──────────────────────────────────────────────────────── */
    .action-group{display:flex;align-items:center;gap:5px;justify-content:center;flex-wrap:wrap}

    /* ── Empty state ───────────────────────────────────────────────────────── */
    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    /* ── Pagination ────────────────────────────────────────────────────────── */
    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .pag-info{font-size:12.5px;color:var(--text3)}
    .pag-btns{display:flex;gap:4px;align-items:center}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none}
    .pag-btn:hover{background:var(--surface2);border-color:var(--border2)}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff}
    .pag-btn.disabled{opacity:.4;cursor:not-allowed;pointer-events:none}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;line-height:32px}

    @media(max-width:768px){
        .stats-strip{grid-template-columns:1fr 1fr}
        .page{padding:16px}
        .header-actions{width:100%}
        .filter-sep{display:none}
    }
</style>

<div class="page">

    {{-- ── Header ─────────────────────────────────────────────────────────── --}}
    <div class="page-header">
        <div>
            {{-- FIX: Judul halaman yang benar — sebelumnya "Buat Tugas" --}}
            <h1 class="page-title">Kelola Tugas</h1>
            <p class="page-sub">Buat dan pantau pengumpulan tugas siswa</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.tugas.create') }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                </svg>
                Buat Tugas Baru
            </a>
        </div>
    </div>

    {{-- ── Stats — data dari controller, bukan query di blade ─────────────── --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M9 11l3 3L22 4"/>
                    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Total Tugas</p>
                {{-- FIX: Gunakan $tugas->total() yang mencerminkan semua tugas guru
                     (tidak terpengaruh filter halaman saat ini) --}}
                <p class="stat-val">{{ $tugas->total() }}</p>
                <p class="stat-sub">semua tugas</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <polyline points="12 6 12 12 16 14"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Aktif</p>
                <p class="stat-val">{{ $stats['total_aktif'] }}</p>
                <p class="stat-sub">sedang berjalan</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10"/>
                    <line x1="12" y1="8" x2="12" y2="12"/>
                    <line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Kedaluwarsa</p>
                <p class="stat-val">{{ $stats['total_expired'] }}</p>
                <p class="stat-sub">lewat batas waktu</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                </svg>
            </div>
            <div>
                <p class="stat-label">Draft</p>
                <p class="stat-val">{{ $stats['total_draft'] }}</p>
                <p class="stat-sub">belum dipublikasi</p>
            </div>
        </div>
    </div>

    {{-- ── Filter ───────────────────────────────────────────────────────────── --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('guru.tugas.index') }}">
            <div class="filter-row">
                <select name="kelas_id">
                    <option value="">Semua Kelas</option>
                    @foreach($kelasList as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                <select name="mata_pelajaran_id">
                    <option value="">Semua Mapel</option>
                    @foreach($mapelList as $m)
                        <option value="{{ $m->id }}" {{ request('mata_pelajaran_id') == $m->id ? 'selected' : '' }}>
                            {{ $m->nama_mapel }}
                        </option>
                    @endforeach
                </select>

                <select name="dipublikasikan">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('dipublikasikan') === '1' ? 'selected' : '' }}>Dipublikasikan</option>
                    <option value="0" {{ request('dipublikasikan') === '0' ? 'selected' : '' }}>Draft</option>
                </select>

                <input type="text" name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari judul tugas…"
                       maxlength="100"
                       autocomplete="off">

                <div class="filter-sep"></div>
                <a href="{{ route('guru.tugas.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- ── Table ────────────────────────────────────────────────────────────── --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Tugas
                @if($tugas->total() > 0)
                    <span>— menampilkan {{ $tugas->firstItem() }}–{{ $tugas->lastItem() }} dari {{ $tugas->total() }} data</span>
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
                        <th>Judul Tugas</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th class="center">Jenis Kumpul</th>
                        <th>Batas Waktu</th>
                        <th class="center">Status</th>
                        <th class="center">Nilai Maks</th>
                        <th class="center" style="width:230px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tugas as $index => $t)
                    @php
                        // FIX: Gunakan Carbon::parse() untuk memastikan batas_waktu
                        // selalu Carbon instance meski model tidak cast field ini.
                        // Akses ->isPast() langsung pada string akan error.
                        $batasWaktu = \Carbon\Carbon::parse($t->batas_waktu);
                        $isExpired  = $batasWaktu->isPast();
                        $isSoon     = ! $isExpired && $batasWaktu->diffInHours(now()) <= 24;
                        $deadlineClass = $isExpired ? 'deadline-expired' : ($isSoon ? 'deadline-soon' : 'deadline-ok');
                    @endphp
                    <tr>
                        {{-- # --}}
                        <td><span class="no-col">{{ $tugas->firstItem() + $index }}</span></td>

                        {{-- Judul & Deskripsi --}}
                        <td>
                            <div class="two-line">
                                <p class="primary">{{ $t->judul }}</p>
                                {{-- FIX: Gunakan \Illuminate\Support\Str:: agar tidak error
                                     jika Str facade tidak di-import di context blade --}}
                                <p class="secondary">{{ \Illuminate\Support\Str::limit($t->deskripsi ?? '—', 60) }}</p>
                            </div>
                        </td>

                        {{-- Kelas --}}
                        <td class="muted" style="font-size:12.5px">
                            {{ $t->kelas->nama_kelas ?? '—' }}
                        </td>

                        {{-- Mata Pelajaran --}}
                        <td class="muted" style="font-size:12.5px">
                            {{ $t->mataPelajaran->nama_mapel ?? '—' }}
                        </td>

                        {{-- Jenis Pengumpulan --}}
                        <td class="center">
                            <span class="badge badge-jenis">
                                {{ strtoupper($t->jenis_pengumpulan) }}
                            </span>
                        </td>

                        {{-- Batas Waktu --}}
                        <td style="font-size:13px;white-space:nowrap">
                            <span class="{{ $deadlineClass }}">
                                {{ $batasWaktu->translatedFormat('d M Y, H:i') }}
                            </span>
                            @if($isExpired)
                                <br><span style="font-size:11px;color:#dc2626;font-weight:700">Kedaluwarsa</span>
                            @elseif($isSoon)
                                <br><span style="font-size:11px;color:#d97706;font-weight:700">Segera berakhir</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td class="center">
                            @if($t->dipublikasikan)
                                <span class="badge badge-publish">
                                    <span class="badge-dot"></span>Publik
                                </span>
                            @else
                                <span class="badge badge-draft">
                                    <span class="badge-dot"></span>Draft
                                </span>
                            @endif
                        </td>

                        {{-- Nilai Maksimal --}}
                        <td class="center">
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text2)">
                                {{ $t->nilai_maksimal ?? 100 }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('guru.tugas.show', $t->id) }}"
                                   class="btn btn-sm btn-detail">Detail</a>

                                <a href="{{ route('guru.tugas.edit', $t->id) }}"
                                   class="btn btn-sm btn-edit">Edit</a>

                                {{-- Toggle publikasi --}}
                                <form action="{{ route('guru.tugas.toggle-status', $t->id) }}"
                                      method="POST" style="display:inline">
                                    @csrf @method('PATCH')
                                    @if($t->dipublikasikan)
                                        <button type="submit" class="btn btn-sm btn-toggle-on"
                                            title="Sembunyikan tugas ini">Sembunyikan</button>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-toggle-off"
                                            title="Publikasikan tugas ini">Publikasikan</button>
                                    @endif
                                </form>

                                {{-- FIX: Gunakan data-* attribute dan Js::from() di luar onclick
                                     untuk menghindari ParseError yang disebabkan @json() di
                                     dalam string atribut HTML (konflik tanda kutip + Blade parser).
                                     Sebelumnya: onclick="confirmDelete('id', @json($t->judul))"
                                     → ParseError: unexpected token "," --}}
                                <button type="button"
                                    class="btn btn-sm btn-del"
                                    data-id="{{ $t->id }}"
                                    data-judul="{{ $t->judul }}"
                                    onclick="confirmDelete(this)">
                                    Hapus
                                </button>
                                <form action="{{ route('guru.tugas.destroy', $t->id) }}"
                                      method="POST"
                                      id="delTugas-{{ $t->id }}"
                                      style="display:none">
                                    @csrf @method('DELETE')
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24">
                                        <path d="M9 11l3 3L22 4"/>
                                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                                    </svg>
                                </div>
                                @if(request()->hasAny(['kelas_id', 'mata_pelajaran_id', 'dipublikasikan', 'search']))
                                    <p class="empty-title">Tidak ada hasil</p>
                                    <p class="empty-sub">
                                        Tidak ada tugas yang sesuai filter.
                                        <a href="{{ route('guru.tugas.index') }}" style="color:var(--brand-600)">Reset filter</a>
                                    </p>
                                @else
                                    <p class="empty-title">Belum ada tugas</p>
                                    <p class="empty-sub">Mulai buat tugas pertama untuk siswa Anda</p>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- ── Pagination ──────────────────────────────────────────────────── --}}
        @if($tugas->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">
                Menampilkan {{ $tugas->firstItem() }} – {{ $tugas->lastItem() }}
                dari {{ $tugas->total() }} tugas
            </p>
            <div class="pag-btns">

                {{-- Prev --}}
                @if($tugas->onFirstPage())
                    <span class="pag-btn disabled">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $tugas->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                {{-- FIX: Ellipsis pagination dengan flag agar tidak duplikat --}}
                @php
                    $current   = $tugas->currentPage();
                    $last      = $tugas->lastPage();
                    $showLeft  = false;
                    $showRight = false;
                @endphp

                @foreach($tugas->getUrlRange(1, $last) as $page => $url)
                    @php
                        $isFirst  = $page === 1;
                        $isLast   = $page === $last;
                        $isNear   = abs($page - $current) <= 1;
                        $showPage = $isFirst || $isLast || $isNear;
                    @endphp

                    @if($showPage)
                        @if($page === $current)
                            <span class="pag-btn active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                        @endif
                    @else
                        @if(!$showLeft && $page < $current)
                            <span class="pag-ellipsis">…</span>
                            @php $showLeft = true; @endphp
                        @endif
                        @if(!$showRight && $page > $current)
                            <span class="pag-ellipsis">…</span>
                            @php $showRight = true; @endphp
                        @endif
                    @endif
                @endforeach

                {{-- Next --}}
                @if($tugas->hasMorePages())
                    <a href="{{ $tugas->nextPageUrl() }}" class="pag-btn">
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
    </div>{{-- /table-card --}}

</div>{{-- /page --}}

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

// Baca data dari data-* attribute lalu tampilkan konfirmasi hapus.
function confirmDelete(btn) {
    const id    = btn.dataset.id;
    const judul = btn.dataset.judul;

    Swal.fire({
        title: 'Hapus Tugas?',
        html: 'Tugas <strong>' + judul + '</strong> akan dihapus permanen beserta semua pengumpulan siswa.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
    }).then(result => {
        if (result.isConfirmed) {
            document.getElementById('delTugas-' + id).submit();
        }
    });
}
</script>
</x-app-layout>