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

    /* ── Layout ── */
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center}

    /* ── Buttons ── */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .btn-detail:hover{background:#dcfce7;filter:none}

    /* ── Stats strip ── */
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;transition:box-shadow .2s}
    .stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.blue{background:#eff6ff}
    .stat-icon.green{background:#f0fdf4}
    .stat-icon.yellow{background:#fefce8}
    .stat-icon.purple{background:#faf5ff}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px}

    /* ── View toggle ── */
    .view-toggle{display:flex;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:3px;gap:3px}
    .view-btn{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);background:none;border:none;cursor:pointer;transition:all .15s}
    .view-btn.active{background:var(--surface);color:var(--text);box-shadow:0 1px 4px rgba(0,0,0,.08)}

    /* ── Filter card ── */
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row select{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .filter-row select:focus{border-color:var(--brand-500);background:#fff}
    .filter-sep{flex:1}
    .btn-filter{height:36px;padding:0 18px;background:var(--brand-600);color:#fff;border:none;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;transition:background .15s}
    .btn-filter:hover{background:var(--brand-700)}
    .btn-reset{height:36px;padding:0 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;transition:background .15s}
    .btn-reset:hover{background:var(--surface3)}

    /* ── Weekly grid view ── */
    .weekly-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:12px;margin-bottom:8px}
    .hari-col{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .hari-header{padding:10px 14px;background:var(--surface2);border-bottom:1px solid var(--border);display:flex;align-items:center;justify-content:space-between}
    .hari-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;color:var(--text);text-transform:uppercase;letter-spacing:.06em}
    .hari-count{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);background:var(--surface3);padding:2px 8px;border-radius:99px}
    .hari-body{padding:10px;display:flex;flex-direction:column;gap:8px}
    .jadwal-card{background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius-sm);padding:10px 12px;cursor:pointer;text-decoration:none;display:block;transition:box-shadow .15s,border-color .15s}
    .jadwal-card:hover{box-shadow:0 3px 12px rgba(31,99,219,.12);border-color:var(--brand-500)}
    .jadwal-card.inactive{background:var(--surface2);border-color:var(--border);opacity:.75}
    .jadwal-card .jc-time{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--brand-600);margin-bottom:4px}
    .jadwal-card.inactive .jc-time{color:var(--text3)}
    .jadwal-card .jc-mapel{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);line-height:1.25;margin-bottom:3px}
    .jadwal-card .jc-kelas{font-size:11.5px;color:var(--text2)}
    .jadwal-card .jc-ruang{font-size:11px;color:var(--text3);margin-top:4px;display:flex;align-items:center;gap:4px}
    .hari-empty{padding:16px;text-align:center;font-size:12px;color:var(--text3)}

    /* ── Table view ── */
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

    /* ── Badges ── */
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;white-space:nowrap}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-aktif  {background:#dcfce7;color:#15803d} .badge-aktif  .badge-dot{background:#15803d}
    .badge-nonaktif{background:#fee2e2;color:#dc2626} .badge-nonaktif .badge-dot{background:#dc2626}

    /* ── Pill hari ── */
    .pill-hari{display:inline-flex;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;background:var(--brand-50);color:var(--brand-700)}

    /* ── Two-line cell ── */
    .two-line .primary{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .two-line .secondary{font-size:12px;color:var(--text3);margin-top:1px}

    /* ── Action group ── */
    .action-group{display:flex;align-items:center;gap:5px;justify-content:center}

    /* ── Empty state ── */
    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    /* ── Info banner ── */
    .info-banner{background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius-sm);padding:11px 16px;display:flex;align-items:center;gap:10px;margin-bottom:16px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--brand-700)}

    @media(max-width:640px){
        .stats-strip{grid-template-columns:1fr 1fr}
        .page{padding:16px}
        .header-actions{width:100%}
        .weekly-grid{grid-template-columns:1fr}
    }
</style>

<div class="page">

    {{-- ── Page Header ── --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Jadwal Mengajar</h1>
            <p class="page-sub">Lihat dan pantau jadwal mengajar Anda setiap minggu</p>
        </div>
        <div class="header-actions">
            {{-- View toggle --}}
            <div class="view-toggle">
                <button type="button" class="view-btn active" id="btnMingguan" onclick="switchView('mingguan')">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    Mingguan
                </button>
                <button type="button" class="view-btn" id="btnTabel" onclick="switchView('tabel')">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/><line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/></svg>
                    Tabel
                </button>
            </div>
        </div>
    </div>

    {{-- ── Stats ── --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Jadwal</p>
                <p class="stat-val">{{ $jadwal->count() }}</p>
                <p class="stat-sub">semua hari</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Aktif</p>
                <p class="stat-val">{{ $jadwal->where('is_active', true)->count() }}</p>
                <p class="stat-sub">jadwal aktif</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div>
                <p class="stat-label">Kelas</p>
                <p class="stat-val">{{ $jadwal->pluck('kelas_id')->unique()->count() }}</p>
                <p class="stat-sub">kelas berbeda</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="18" height="18" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
            </div>
            <div>
                <p class="stat-label">Mata Pelajaran</p>
                <p class="stat-val">{{ $jadwal->pluck('mata_pelajaran_id')->unique()->count() }}</p>
                <p class="stat-sub">mapel berbeda</p>
            </div>
        </div>
    </div>

    {{-- ── Info banner jika tidak ada jadwal ── --}}
    @if($jadwal->isEmpty())
    <div class="info-banner">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        Belum ada jadwal mengajar yang ditetapkan untuk akun Anda. Hubungi admin jika ada kesalahan.
    </div>
    @endif

    {{-- ── Filter ── --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('guru.jadwal.index') }}">
            <div class="filter-row">
                <select name="hari">
                    <option value="">Semua Hari</option>
                    @foreach($hariList as $h)
                        <option value="{{ $h }}" {{ request('hari') === $h ? 'selected' : '' }}>
                            {{ ucfirst($h) }}
                        </option>
                    @endforeach
                </select>

                <select name="kelas_id">
                    <option value="">Semua Kelas</option>
                    @foreach($jadwal->pluck('kelas')->unique('id')->filter() as $k)
                        <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>

                <select name="is_active">
                    <option value="">Semua Status</option>
                    <option value="1" {{ request('is_active') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ request('is_active') === '0' ? 'selected' : '' }}>Nonaktif</option>
                </select>

                <div class="filter-sep"></div>

                <a href="{{ route('guru.jadwal.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- ════════════════════════════════════
         VIEW: MINGGUAN (default)
    ════════════════════════════════════ --}}
    <div id="viewMingguan">
        @if($jadwal->isEmpty())
            <div class="table-card">
                <div class="empty-state">
                    <div class="empty-icon">
                        <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                    </div>
                    <p class="empty-title">Tidak ada jadwal ditemukan</p>
                    <p class="empty-sub">Coba ubah filter atau hubungi admin</p>
                </div>
            </div>
        @else
            <div class="weekly-grid">
                @foreach($hariList as $hari)
                    @php $jadwalHari = $jadwalPerHari->get($hari, collect()); @endphp
                    <div class="hari-col">
                        <div class="hari-header">
                            <span class="hari-name">{{ ucfirst($hari) }}</span>
                            <span class="hari-count">{{ $jadwalHari->count() }}</span>
                        </div>
                        <div class="hari-body">
                            @forelse($jadwalHari as $j)
                                <a href="{{ route('guru.jadwal.show', $j->id) }}"
                                   class="jadwal-card {{ $j->is_active ? '' : 'inactive' }}">
                                    <p class="jc-time">
                                        {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}
                                        –
                                        {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                    </p>
                                    <p class="jc-mapel">{{ $j->mataPelajaran->nama_mapel ?? '—' }}</p>
                                    <p class="jc-kelas">{{ $j->kelas->nama_kelas ?? '—' }}</p>
                                    @if($j->ruang)
                                        <p class="jc-ruang">
                                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/></svg>
                                            {{ $j->ruang->nama_ruang ?? $j->ruang }}
                                        </p>
                                    @endif
                                </a>
                            @empty
                                <p class="hari-empty">Tidak ada jadwal</p>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- ════════════════════════════════════
         VIEW: TABEL
    ════════════════════════════════════ --}}
    <div id="viewTabel" style="display:none">
        <div class="table-card">
            <div class="table-topbar">
                <p class="table-info">
                    Daftar Jadwal
                    @if($jadwal->count() > 0)
                        <span>— {{ $jadwal->count() }} jadwal ditemukan</span>
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
                            <th>Mata Pelajaran</th>
                            <th>Kelas</th>
                            <th class="center">Hari</th>
                            <th>Jam</th>
                            <th>Ruang</th>
                            <th>Tahun Ajaran</th>
                            <th class="center">Status</th>
                            <th class="center" style="width:100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($jadwal as $index => $j)
                        <tr>
                            <td><span class="no-col">{{ $index + 1 }}</span></td>

                            <td>
                                <div class="two-line">
                                    <p class="primary">{{ $j->mataPelajaran->nama_mapel ?? '—' }}</p>
                                    <p class="secondary">{{ $j->mataPelajaran->kode_mapel ?? '' }}</p>
                                </div>
                            </td>

                            <td class="muted" style="font-size:12.5px">{{ $j->kelas->nama_kelas ?? '—' }}</td>

                            <td class="center">
                                <span class="pill-hari">{{ ucfirst($j->hari) }}</span>
                            </td>

                            <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:13px;white-space:nowrap">
                                {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}
                                –
                                {{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                            </td>

                            <td class="muted" style="font-size:12.5px">
                                {{ is_object($j->ruang) ? ($j->ruang->nama_ruang ?? '—') : ($j->ruang ?? '—') }}
                            </td>

                            <td class="muted" style="font-size:12.5px">
                                {{ $j->tahunAjaran->nama ?? ($j->tahunAjaran->tahun ?? '—') }}
                            </td>

                            <td class="center">
                                @if($j->is_active)
                                    <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                                @else
                                    <span class="badge badge-nonaktif"><span class="badge-dot"></span>Nonaktif</span>
                                @endif
                            </td>

                            <td class="center">
                                <div class="action-group">
                                    <a href="{{ route('guru.jadwal.show', $j->id) }}" class="btn btn-sm btn-detail">Detail</a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9">
                                <div class="empty-state">
                                    <div class="empty-icon">
                                        <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                    </div>
                                    <p class="empty-title">Tidak ada jadwal ditemukan</p>
                                    <p class="empty-sub">Coba ubah filter atau hubungi admin</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script>
/* ── View toggle ── */
const VIEW_KEY = 'jadwal_view_pref';

function switchView(mode) {
    const mingguan = document.getElementById('viewMingguan');
    const tabel    = document.getElementById('viewTabel');
    const btnM     = document.getElementById('btnMingguan');
    const btnT     = document.getElementById('btnTabel');

    if (mode === 'mingguan') {
        mingguan.style.display = '';
        tabel.style.display    = 'none';
        btnM.classList.add('active');
        btnT.classList.remove('active');
    } else {
        mingguan.style.display = 'none';
        tabel.style.display    = '';
        btnT.classList.add('active');
        btnM.classList.remove('active');
    }
    try { localStorage.setItem(VIEW_KEY, mode); } catch(e) {}
}

/* Restore preference */
try {
    const saved = localStorage.getItem(VIEW_KEY);
    if (saved === 'tabel') switchView('tabel');
} catch(e) {}
</script>
</x-app-layout>