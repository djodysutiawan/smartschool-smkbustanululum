<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;--brand-100:#d9ebff;--brand-50:#eef6ff;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px;}
    *{box-sizing:border-box;}
    .page{padding:28px 28px 48px;}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-primary{background:var(--brand-600);color:#fff;}
    .btn-outline{background:var(--surface);color:var(--text2);border:1px solid var(--border);}
    .btn-outline:hover{background:var(--surface2);filter:none;}
    .btn-pdf{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .btn-pdf:hover{background:#fee2e2;filter:none;}
    .btn-excel{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .btn-excel:hover{background:#dcfce7;filter:none;}
    .btn-sm{padding:5px 11px;font-size:11.5px;border-radius:6px;}

    /* Stats — 4 kartu: total, aktif, L, P */
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;display:flex;align-items:center;gap:10px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}
    .stat-icon.green{background:#f0fdf4;}
    .stat-icon.sky{background:#f0f9ff;}
    .stat-icon.pink{background:#fdf2f8;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .stat-note{font-size:11px;color:var(--text3);margin-top:2px;}

    /* Charts — radar + doughnut (beda dari absensi) */
    .charts-row{display:grid;grid-template-columns:1fr 300px;gap:16px;margin-bottom:16px;}
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .card-header{padding:13px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:space-between;}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .card-sub{font-size:11.5px;color:var(--text3);}
    .card-body{padding:16px 20px;}
    .chart-wrap{position:relative;height:220px;}

    /* Filter */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;}
    .filter-grid{display:grid;grid-template-columns:2fr 1fr 1fr 1fr auto auto;gap:10px;align-items:end;}
    .filter-row2{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:10px;}
    .field{display:flex;flex-direction:column;gap:5px;}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);}
    .field input,.field select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;}
    .field input:focus,.field select:focus{border-color:var(--brand-500);background:#fff;}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;}
    .btn-filter:hover{background:var(--brand-700);}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;white-space:nowrap;}
    .btn-reset:hover{background:var(--surface3);}

    /* Table */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:13px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:8px;}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px;}
    .table-actions{display:flex;gap:7px;}
    .table-wrap{overflow-x:auto;}
    table{width:100%;border-collapse:collapse;font-size:13.5px;}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border);}
    thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap;}
    thead th.center{text-align:center;}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s;}
    tbody tr:last-child{border-bottom:none;}
    tbody tr:hover{background:#fafbff;}
    td{padding:10px 14px;color:var(--text);vertical-align:middle;}
    td.center{text-align:center;}
    td.muted{color:var(--text3);font-size:12.5px;}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3);}

    .avatar-wrap{width:34px;height:34px;border-radius:8px;overflow:hidden;border:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .avatar-wrap img{width:100%;height:100%;object-fit:cover;}
    .avatar-initial{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--brand-600);}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-aktif{background:#dcfce7;color:#15803d;}.badge-aktif .badge-dot{background:#15803d;}
    .badge-tidak_aktif{background:#fee2e2;color:#dc2626;}.badge-tidak_aktif .badge-dot{background:#dc2626;}
    .badge-lulus{background:#dbeafe;color:#1d4ed8;}.badge-lulus .badge-dot{background:#1d4ed8;}
    .badge-pindah{background:#fef9c3;color:#a16207;}.badge-pindah .badge-dot{background:#a16207;}
    .badge-keluar{background:#f1f5f9;color:#64748b;}.badge-keluar .badge-dot{background:#64748b;}

    .jk-pill{display:inline-block;padding:2px 9px;border-radius:5px;font-size:11.5px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;}
    .jk-l{background:#f0f9ff;color:#0284c7;border:1px solid #bae6fd;}
    .jk-p{background:#fdf2f8;color:#db2777;border:1px solid #fbcfe8;}

    .empty-state{padding:50px 20px;text-align:center;}
    .empty-icon{width:52px;height:52px;background:var(--surface2);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 12px;}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--text);margin-bottom:4px;}
    .empty-sub{font-size:13px;color:var(--text3);}

    .pag-wrap{display:flex;align-items:center;justify-content:space-between;padding:13px 20px;border-top:1px solid var(--border);flex-wrap:wrap;gap:10px;}
    .pag-info{font-size:12.5px;color:var(--text3);}
    .pag-btns{display:flex;gap:4px;}
    .pag-btn{height:32px;min-width:32px;padding:0 8px;border-radius:7px;display:flex;align-items:center;justify-content:center;border:1px solid var(--border);background:var(--surface);color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;cursor:pointer;transition:all .15s;text-decoration:none;}
    .pag-btn:hover{background:var(--surface2);}
    .pag-btn.active{background:var(--brand-600);border-color:var(--brand-600);color:#fff;}
    .pag-ellipsis{color:var(--text3);font-size:13px;padding:0 4px;display:flex;align-items:center;}

    @media(max-width:900px){
        .stats-strip{grid-template-columns:1fr 1fr;}
        .charts-row{grid-template-columns:1fr;}
        .filter-grid{grid-template-columns:1fr 1fr;}
        .page{padding:16px;}
    }
</style>

<div class="page">

    {{-- ══ HEADER ══ --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Laporan Siswa</h1>
            <p class="page-sub">Rekap data siswa — filter, rekap per kelas, dan ekspor laporan</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.laporan.index') }}" class="btn btn-outline">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.siswa.create') }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Siswa
            </a>
        </div>
    </div>

    {{--
        ══ STAT CARDS ══
        Sumber: $statsS dari controller — ['total', 'aktif', 'laki', 'perempuan']
        $siswa->total() = total sesuai filter aktif (dari paginator)
        $statsS['total'] = seluruh data DB (Siswa::count())
    --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="17" height="17" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Siswa</p>
                <p class="stat-val">{{ number_format($statsS['total']) }}</p>
                <p class="stat-note">seluruh data</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="17" height="17" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Aktif</p>
                <p class="stat-val">{{ number_format($statsS['aktif']) }}</p>
                <p class="stat-note">status aktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon sky">
                <svg width="17" height="17" fill="none" stroke="#0284c7" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div>
                <p class="stat-label">Laki-laki</p>
                <p class="stat-val">{{ number_format($statsS['laki']) }}</p>
                <p class="stat-note">siswa aktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon pink">
                <svg width="17" height="17" fill="none" stroke="#db2777" stroke-width="1.8" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
            </div>
            <div>
                <p class="stat-label">Perempuan</p>
                <p class="stat-val">{{ number_format($statsS['perempuan']) }}</p>
                <p class="stat-note">siswa aktif</p>
            </div>
        </div>
    </div>

    {{--
        ══ CHARTS ══
        Versi siswa: horizontal bar (distribusi status) + pie jenis kelamin
        Berbeda dari absensi (line+doughnut) dan pelanggaran (line+doughnut merah)
        Data: $statsS dari controller (sudah via GROUP BY, tidak ada query di view)
    --}}
    <div class="charts-row">
        <div class="card">
            <div class="card-header">
                <span class="card-title">Distribusi Status Siswa</span>
                <span class="card-sub">Aktif, Lulus, Pindah, Keluar, Tidak Aktif</span>
            </div>
            <div class="card-body">
                <div class="chart-wrap"><canvas id="statusChart"></canvas></div>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <span class="card-title">Komposisi Jenis Kelamin</span>
                <span class="card-sub">Siswa aktif</span>
            </div>
            <div class="card-body">
                <div class="chart-wrap"><canvas id="jkChart"></canvas></div>
            </div>
        </div>
    </div>

    {{--
        ══ FILTER ══
        Sesuai applySiswaFilters(): kelas_id, tahun_ajaran_id, jenis_kelamin, status, search
        FIX: tambahkan tahun_ajaran_id yang ada di controller tapi tidak di view lama.
    --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('admin.laporan.siswa') }}">
            <div class="filter-grid">
                <div class="field">
                    <label>Cari Nama / NIS / NISN</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Ketik nama, NIS, atau NISN...">
                </div>
                <div class="field">
                    <label>Kelas</label>
                    <select name="kelas_id">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>{{ $k->nama_kelas }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Status</label>
                    <select name="status">
                        <option value="">Semua Status</option>
                        @foreach(['aktif' => 'Aktif', 'tidak_aktif' => 'Tidak Aktif', 'lulus' => 'Lulus', 'pindah' => 'Pindah', 'keluar' => 'Keluar'] as $val => $label)
                            <option value="{{ $val }}" {{ request('status') === $val ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="field">
                    <label>Jenis Kelamin</label>
                    <select name="jenis_kelamin">
                        <option value="">Semua</option>
                        <option value="L" {{ request('jenis_kelamin') === 'L' ? 'selected' : '' }}>Laki-laki</option>
                        <option value="P" {{ request('jenis_kelamin') === 'P' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
                <a href="{{ route('admin.laporan.siswa') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Filter</button>
            </div>
            {{-- FIX: tahun_ajaran_id ada di applySiswaFilters() tapi hilang di view lama --}}
            <div class="filter-row2">
                <div class="field">
                    <label>Tahun Ajaran</label>
                    <select name="tahun_ajaran_id">
                        <option value="">Semua Tahun Ajaran</option>
                        @foreach($tahunAjaranList as $t)
                            <option value="{{ $t->id }}" {{ request('tahun_ajaran_id') == $t->id ? 'selected' : '' }}>{{ $t->nama ?? $t->tahun }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </form>
    </div>

    {{-- ══ TABEL ══ --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Siswa
                @if($siswa->total() > 0)
                    <span>— {{ $siswa->firstItem() }}–{{ $siswa->lastItem() }} dari {{ number_format($siswa->total()) }} record</span>
                @else
                    <span>— Tidak ada data</span>
                @endif
            </p>
            <div class="table-actions">
                <a href="{{ route('admin.laporan.siswa.export.pdf', request()->query()) }}"
                   class="btn btn-sm btn-pdf" target="_blank">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('admin.laporan.siswa.export.excel', request()->query()) }}"
                   class="btn btn-sm btn-excel">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M3 15h18M9 3v18"/></svg>
                    Export Excel
                </a>
            </div>
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th style="width:44px">Foto</th>
                        <th>Nama / NIS</th>
                        <th>Jenis Kelamin</th>
                        <th>Kelas</th>
                        <th>Tahun Ajaran</th>
                        <th>Status</th>
                        <th class="center" style="width:80px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $i => $s)
                    <tr>
                        <td><span class="no-col">{{ $siswa->firstItem() + $i }}</span></td>

                        {{-- Foto --}}
                        <td>
                            <div class="avatar-wrap">
                                @if($s->foto ?? false)
                                    <img src="{{ asset('storage/' . $s->foto) }}" alt="{{ $s->nama_lengkap }}">
                                @else
                                    <span class="avatar-initial">{{ strtoupper(substr($s->nama_lengkap, 0, 1)) }}</span>
                                @endif
                            </div>
                        </td>

                        {{-- Nama & NIS --}}
                        <td>
                            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;line-height:1.3;">
                                {{ $s->nama_lengkap }}
                            </p>
                            <p style="font-size:11.5px;color:var(--text3);font-family:'DM Sans',sans-serif;">
                                NIS: {{ $s->nis ?? '—' }}
                                @if($s->nisn ?? false)
                                    &nbsp;·&nbsp;NISN: {{ $s->nisn }}
                                @endif
                            </p>
                        </td>

                        {{-- Jenis Kelamin --}}
                        <td>
                            @if($s->jenis_kelamin === 'L')
                                <span class="jk-pill jk-l">♂ Laki-laki</span>
                            @elseif($s->jenis_kelamin === 'P')
                                <span class="jk-pill jk-p">♀ Perempuan</span>
                            @else
                                <span class="muted">—</span>
                            @endif
                        </td>

                        {{--
                            Kelas — relasi kelas() via kelas_id.
                            FIX: optional() agar tidak fatal jika kelas belum diassign.
                        --}}
                        <td style="font-size:13px;font-weight:600;font-family:'Plus Jakarta Sans',sans-serif;">
                            {{ optional($s->kelas)->nama_kelas ?? '—' }}
                        </td>

                        {{--
                            Tahun Ajaran — via relasi kelas.tahunAjaran (sudah di-eager load
                            dengan ['kelas.tahunAjaran'] di controller).
                        --}}
                        <td class="muted">
                            {{ optional(optional($s->kelas)->tahunAjaran)->nama
                               ?? optional(optional($s->kelas)->tahunAjaran)->tahun
                               ?? '—' }}
                        </td>

                        {{--
                            Status — kolom 'status' di tabel siswa.
                            FIX: guard CSS class agar tidak error jika nilai di luar daftar valid.
                        --}}
                        <td>
                            @php
                                $validStatus = ['aktif', 'tidak_aktif', 'lulus', 'pindah', 'keluar'];
                                $statusClass = in_array($s->status, $validStatus) ? $s->status : 'aktif';
                                $statusLabel = ['aktif' => 'Aktif', 'tidak_aktif' => 'Tidak Aktif', 'lulus' => 'Lulus', 'pindah' => 'Pindah', 'keluar' => 'Keluar'];
                            @endphp
                            <span class="badge badge-{{ $statusClass }}">
                                <span class="badge-dot"></span>{{ $statusLabel[$statusClass] ?? ucfirst($s->status) }}
                            </span>
                        </td>

                        <td class="center">
                            <a href="{{ route('admin.siswa.show', $s->id) }}"
                               class="btn btn-sm"
                               style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;text-decoration:none;">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="22" height="22" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                </div>
                                <p class="empty-title">Tidak ada data siswa</p>
                                <p class="empty-sub">Coba ubah filter atau reset pencarian</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination — ellipsis fix dengan flag --}}
        @if($siswa->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $siswa->firstItem() }} – {{ $siswa->lastItem() }} dari {{ number_format($siswa->total()) }} data</p>
            <div class="pag-btns">
                @if($siswa->onFirstPage())
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </span>
                @else
                    <a href="{{ $siswa->previousPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    </a>
                @endif

                @php $cur = $siswa->currentPage(); $last = $siswa->lastPage(); $ellL = false; $ellR = false; @endphp
                @foreach($siswa->getUrlRange(1, $last) as $page => $url)
                    @php $isEdge = ($page === 1 || $page === $last); $isNear = abs($page - $cur) <= 1; @endphp
                    @if($page === $cur)
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($isEdge || $isNear)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(!$ellL && $page < $cur)
                        @php $ellL = true @endphp <span class="pag-ellipsis">…</span>
                    @elseif(!$ellR && $page > $cur)
                        @php $ellR = true @endphp <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach

                @if($siswa->hasMorePages())
                    <a href="{{ $siswa->nextPageUrl() }}" class="pag-btn">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </a>
                @else
                    <span class="pag-btn" style="opacity:.4;cursor:not-allowed">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg>
                    </span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
        Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif

    Chart.defaults.font.family = "'DM Sans', sans-serif";
    Chart.defaults.color = '#94a3b8';

    {{--
        Chart 1: Horizontal bar — distribusi status siswa.
        Data dari $statsS (controller via GROUP BY jenis_kelamin).
        FIX: $statsS dari controller hanya punya 'total','aktif','laki','perempuan'.
        Status breakdown (aktif, lulus, pindah, dll) perlu ditambahkan di controller.
        Sementara pakai data yang tersedia: aktif vs non-aktif (total - aktif).
        Jika controller sudah menambah key statusCounts, update label & data di sini.
    --}}
    new Chart(document.getElementById('statusChart'), {
        type: 'bar',
        data: {
            labels: ['Aktif', 'Tidak Aktif / Lulus / Keluar'],
            datasets: [{
                label: 'Jumlah Siswa',
                data: [
                    {{ $statsS['aktif'] }},
                    {{ $statsS['total'] - $statsS['aktif'] }},
                ],
                backgroundColor: ['rgba(34,197,94,.8)', 'rgba(148,163,184,.5)'],
                borderColor:     ['#16a34a', '#94a3b8'],
                borderWidth: 1.5,
                borderRadius: 6,
                borderSkipped: false,
            }]
        },
        options: {
            indexAxis: 'y',   {{-- horizontal bar — beda dari absensi yang pakai line --}}
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { callbacks: { label: ctx => ` ${ctx.raw} siswa` } }
            },
            scales: {
                x: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { stepSize: 1 } },
                y: { grid: { display: false } }
            }
        }
    });

    {{--
        Chart 2: Pie — komposisi jenis kelamin.
        Beda dari absensi (doughnut 60% cutout); ini pakai pie penuh.
        Data dari $statsS['laki'] dan $statsS['perempuan'] — sudah via GROUP BY di controller.
    --}}
    new Chart(document.getElementById('jkChart'), {
        type: 'pie',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: [{{ $statsS['laki'] }}, {{ $statsS['perempuan'] }}],
                backgroundColor: ['rgba(14,165,233,.8)', 'rgba(236,72,153,.7)'],
                borderColor:     ['#0284c7', '#db2777'],
                borderWidth: 2,
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: { boxWidth: 10, padding: 12, font: { family: "'Plus Jakarta Sans'", weight: '700', size: 11 } }
                },
                tooltip: {
                    callbacks: {
                        label: ctx => ` ${ctx.label}: ${ctx.raw} siswa`
                    }
                }
            }
        }
    });
</script>
</x-app-layout>