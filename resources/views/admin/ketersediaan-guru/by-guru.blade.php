<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
:root {
    --brand:    #1f63db;
    --brand-50: #eef6ff;
    --brand-100:#d9ebff;
    --brand-700:#1750c0;
    --surface:  #fff;
    --surface2: #f8fafc;
    --surface3: #f1f5f9;
    --border:   #e2e8f0;
    --border2:  #cbd5e1;
    --text:     #0f172a;
    --text2:    #475569;
    --text3:    #94a3b8;
    --red:      #dc2626;
    --red-bg:   #fee2e2;
    --red-bd:   #fecaca;
    --green:    #15803d;
    --green-bg: #dcfce7;
    --radius:   10px;
    --radius-sm:7px;
}
.page { padding:28px 28px 60px; max-width:2000px; margin:0 auto; }
.breadcrumb { display:flex; align-items:center; gap:6px; font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:600; color:var(--text3); margin-bottom:20px; }
.breadcrumb a { color:var(--text3); text-decoration:none; transition:color .15s; }
.breadcrumb a:hover { color:var(--brand); }
.breadcrumb .sep { color:var(--border2); }
.breadcrumb .current { color:var(--text2); }
.page-header { display:flex; align-items:flex-start; justify-content:space-between; gap:16px; margin-bottom:24px; flex-wrap:wrap; }
.page-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:20px; font-weight:800; color:var(--text); }
.page-sub { font-size:12.5px; color:var(--text3); margin-top:3px; }
.header-actions { display:flex; gap:8px; flex-wrap:wrap; }
.btn { display:inline-flex; align-items:center; gap:6px; padding:8px 16px; border-radius:var(--radius-sm); font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; cursor:pointer; border:none; text-decoration:none; transition:filter .15s, background .15s; white-space:nowrap; }
.btn-back    { background:var(--surface2); color:var(--text2); border:1px solid var(--border); }
.btn-back:hover { background:var(--surface3); }
.btn-primary { background:var(--brand); color:#fff; }
.btn-primary:hover { filter:brightness(.93); }
.btn-danger  { background:var(--red-bg); color:var(--red); border:1px solid var(--red-bd); }
.btn-danger:hover { background:#fecaca; filter:none; }
.btn-sm      { padding:5px 12px; font-size:12px; }
.guru-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:20px 24px; margin-bottom:24px; display:flex; align-items:center; gap:20px; flex-wrap:wrap; }
.guru-avatar { width:52px; height:52px; border-radius:50%; background:var(--brand-50); border:2px solid var(--brand-100); display:flex; align-items:center; justify-content:center; font-family:'Plus Jakarta Sans',sans-serif; font-size:20px; font-weight:800; color:var(--brand); flex-shrink:0; }
.guru-meta { flex:1; min-width:0; }
.guru-name { font-family:'Plus Jakarta Sans',sans-serif; font-size:17px; font-weight:800; color:var(--text); }
.guru-nip  { font-size:12.5px; color:var(--text3); margin-top:2px; font-family:'DM Sans',sans-serif; }
.guru-badges { display:flex; gap:6px; margin-top:6px; flex-wrap:wrap; }
.badge { display:inline-flex; align-items:center; gap:4px; padding:3px 10px; border-radius:99px; font-family:'Plus Jakarta Sans',sans-serif; font-size:11.5px; font-weight:700; white-space:nowrap; }
.badge-dot { width:5px; height:5px; border-radius:50%; }
.badge-aktif  { background:var(--green-bg); color:var(--green); }
.badge-aktif .badge-dot { background:var(--green); }
.badge-nonaktif { background:var(--red-bg); color:var(--red); }
.badge-nonaktif .badge-dot { background:var(--red); }
.badge-info  { background:var(--brand-50); color:var(--brand-700); }
.main-grid { display:grid; grid-template-columns:1fr 340px; gap:20px; align-items:start; }
.card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; }
.card-header { padding:14px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; gap:8px; }
.card-header-left { display:flex; align-items:center; gap:8px; }
.card-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; color:var(--text); }
.section-empty { padding:32px 20px; text-align:center; color:var(--text3); font-family:'DM Sans',sans-serif; font-size:13.5px; }
.hari-section { border-bottom:1px solid var(--border); }
.hari-section:last-child { border-bottom:none; }
.hari-label { padding:10px 20px; background:var(--surface2); display:flex; align-items:center; gap:10px; border-bottom:1px solid var(--border); }
.hari-pill { display:inline-block; padding:3px 12px; border-radius:6px; font-family:'Plus Jakarta Sans',sans-serif; font-size:12px; font-weight:800; text-transform:capitalize; }
.hari-senin  { background:#eef2ff; color:#4338ca; border:1px solid #c7d2fe; }
.hari-selasa { background:var(--brand-50); color:var(--brand-700); border:1px solid var(--brand-100); }
.hari-rabu   { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
.hari-kamis  { background:#fefce8; color:#a16207; border:1px solid #fde68a; }
.hari-jumat  { background:#fff7ed; color:#c2410c; border:1px solid #fed7aa; }
.hari-sabtu  { background:#fdf4ff; color:#7c3aed; border:1px solid #e9d5ff; }
.slot-row { display:flex; align-items:center; gap:12px; padding:12px 20px; border-bottom:1px solid var(--surface3); }
.slot-row:last-child { border-bottom:none; }
.slot-time { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; color:var(--text); min-width:110px; white-space:nowrap; }
.slot-divider { color:var(--text3); font-size:11px; }
.slot-mapel { font-family:'DM Sans',sans-serif; font-size:13px; color:var(--text2); flex:1; }
.slot-jurusan { font-size:11.5px; color:var(--text3); }
.slot-status { flex-shrink:0; }
.slot-actions { display:flex; gap:6px; flex-shrink:0; }
.ico-btn { display:inline-flex; align-items:center; justify-content:center; width:28px; height:28px; border-radius:6px; border:1px solid var(--border); background:var(--surface2); cursor:pointer; color:var(--text2); text-decoration:none; transition:background .15s; }
.ico-btn:hover { background:var(--surface3); }
.ico-btn.danger { border-color:var(--red-bd); background:var(--red-bg); color:var(--red); }
.ico-btn.danger:hover { background:#fecaca; }
.status-dot { display:inline-block; width:8px; height:8px; border-radius:50%; margin-right:4px; }
.dot-green { background:var(--green); }
.dot-red   { background:var(--red); }
/* Sidebar: mapel diampu */
.mapel-list { padding:0; }
.mapel-item { padding:12px 20px; border-bottom:1px solid var(--surface3); display:flex; align-items:flex-start; gap:10px; }
.mapel-item:last-child { border-bottom:none; }
.mapel-icon { width:32px; height:32px; border-radius:8px; background:var(--brand-50); display:flex; align-items:center; justify-content:center; flex-shrink:0; }
.mapel-name { font-family:'Plus Jakarta Sans',sans-serif; font-size:13px; font-weight:700; color:var(--text); }
.mapel-meta { font-size:11.5px; color:var(--text3); margin-top:2px; font-family:'DM Sans',sans-serif; }
/* Jadwal aktif sidebar */
.jadwal-item { padding:10px 20px; border-bottom:1px solid var(--surface3); }
.jadwal-item:last-child { border-bottom:none; }
.jadwal-hari { font-family:'Plus Jakarta Sans',sans-serif; font-size:11px; font-weight:700; color:var(--text3); text-transform:uppercase; }
.jadwal-detail { font-family:'DM Sans',sans-serif; font-size:13px; color:var(--text); margin-top:2px; }
/* Bulk form */
.bulk-section { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; margin-top:20px; }
.bulk-header { padding:14px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; gap:8px; }
.bulk-table { width:100%; border-collapse:collapse; font-size:13px; }
.bulk-table th { font-family:'Plus Jakarta Sans',sans-serif; font-size:11px; font-weight:700; color:var(--text3); text-transform:uppercase; letter-spacing:.04em; padding:10px 12px; background:var(--surface2); border-bottom:1px solid var(--border); text-align:left; }
.bulk-table td { padding:8px 12px; border-bottom:1px solid var(--surface3); vertical-align:middle; }
.bulk-table tr:last-child td { border-bottom:none; }
.bulk-table select, .bulk-table input[type="time"] { width:100%; padding:6px 8px; border:1px solid var(--border); border-radius:var(--radius-sm); font-family:'DM Sans',sans-serif; font-size:12.5px; background:var(--surface2); color:var(--text); outline:none; }
.bulk-table select:focus, .bulk-table input:focus { border-color:var(--brand); background:#fff; }
.bulk-footer { padding:14px 20px; background:var(--surface2); border-top:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; gap:10px; }
.add-row-btn { display:inline-flex; align-items:center; gap:5px; font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:700; color:var(--brand); background:none; border:none; cursor:pointer; padding:0; }
.add-row-btn:hover { text-decoration:underline; }
.del-row-btn { display:inline-flex; align-items:center; justify-content:center; width:24px; height:24px; border-radius:5px; border:none; background:var(--red-bg); color:var(--red); cursor:pointer; }
.del-row-btn:hover { background:var(--red-bd); }
.toggle-sw { position:relative; display:inline-block; width:36px; height:20px; }
.toggle-sw input { opacity:0; width:0; height:0; }
.toggle-sl { position:absolute; inset:0; border-radius:99px; background:var(--border2); cursor:pointer; transition:background .2s; }
.toggle-sl::before { content:''; position:absolute; width:14px; height:14px; left:3px; top:3px; background:#fff; border-radius:50%; transition:transform .2s; box-shadow:0 1px 2px rgba(0,0,0,.2); }
.toggle-sw input:checked + .toggle-sl { background:var(--brand); }
.toggle-sw input:checked + .toggle-sl::before { transform:translateX(16px); }
@media (max-width:900px) { .main-grid { grid-template-columns:1fr; } }
@media (max-width:600px) { .page { padding:16px; } .guru-card { flex-direction:column; align-items:flex-start; } }
@keyframes spin { to { transform:rotate(360deg); } }
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.ketersediaan-guru.index') }}">Ketersediaan Guru</a>
        <span class="sep">›</span>
        <span class="current">{{ $guru->nama_lengkap }}</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Ketersediaan Guru</h1>
            <p class="page-sub">Kelola semua slot waktu ketersediaan untuk guru ini</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.ketersediaan-guru.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.ketersediaan-guru.create', ['guru_id' => $guru->id]) }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Slot
            </a>
        </div>
    </div>

    {{-- Notifikasi --}}
    @if(session('success'))
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
            }
        });
        </script>
    @endif
    @if(session('error'))
        <div style="display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13.5px;background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd)">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Guru Info Card --}}
    <div class="guru-card">
        <div class="guru-avatar">{{ mb_strtoupper(mb_substr($guru->nama_lengkap, 0, 1)) }}</div>
        <div class="guru-meta">
            <p class="guru-name">{{ $guru->nama_lengkap }}</p>
            @if($guru->nip)
                <p class="guru-nip">NIP: {{ $guru->nip }}</p>
            @endif
            <div class="guru-badges">
                @if($guru->status === 'aktif')
                    <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                @else
                    <span class="badge badge-nonaktif"><span class="badge-dot"></span>{{ ucfirst($guru->status ?? 'Nonaktif') }}</span>
                @endif
                @if($guru->status_kepegawaian)
                    <span class="badge badge-info">{{ strtoupper($guru->status_kepegawaian) }}</span>
                @endif
                <span class="badge" style="background:var(--surface3);color:var(--text2)">
                    {{ $ketersediaan->flatten()->count() }} Slot Terdaftar
                </span>
            </div>
        </div>
    </div>

    <div class="main-grid">

        {{-- ── KOLOM UTAMA: Ketersediaan + Bulk Form ── --}}
        <div>

            {{-- Tabel Ketersediaan per Hari --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <p class="card-title">Slot Ketersediaan</p>
                    </div>
                </div>

                @if($ketersediaan->isEmpty())
                    <div class="section-empty">
                        <svg width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" style="margin:0 auto 8px;display:block;opacity:.3"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        Belum ada slot ketersediaan untuk guru ini.<br>
                        <a href="{{ route('admin.ketersediaan-guru.create', ['guru_id' => $guru->id]) }}"
                            style="color:var(--brand);font-weight:700;text-decoration:none;font-size:13px">Tambah sekarang →</a>
                    </div>
                @else
                    @foreach($hariList as $hari)
                        @if(isset($ketersediaan[$hari]))
                        <div class="hari-section">
                            <div class="hari-label">
                                <span class="hari-pill hari-{{ $hari }}">{{ ucfirst($hari) }}</span>
                                <span style="font-size:12px;color:var(--text3)">{{ $ketersediaan[$hari]->count() }} slot</span>
                            </div>
                            @foreach($ketersediaan[$hari] as $slot)
                            <div class="slot-row">
                                <div class="slot-time">
                                    {{ \Carbon\Carbon::parse($slot->jam_mulai)->format('H:i') }}
                                    <span class="slot-divider">–</span>
                                    {{ \Carbon\Carbon::parse($slot->jam_selesai)->format('H:i') }}
                                </div>
                                <div style="flex:1;min-width:0">
                                    <div class="slot-mapel">
                                        {{ $slot->mataPelajaran->nama_mapel ?? '— Bebas Mapel —' }}
                                    </div>
                                    @if($slot->jurusan)
                                        {{-- FIX: kolom DB adalah `nama` --}}
                                        <div class="slot-jurusan">{{ $slot->jurusan->nama }}</div>
                                    @endif
                                    @if($slot->catatan)
                                        <div style="font-size:11.5px;color:var(--text3);font-style:italic;margin-top:2px">{{ $slot->catatan }}</div>
                                    @endif
                                </div>
                                <div class="slot-status">
                                    @if($slot->tersedia)
                                        <span style="display:inline-flex;align-items:center;font-size:12px;font-weight:700;color:var(--green)">
                                            <span class="status-dot dot-green"></span>Tersedia
                                        </span>
                                    @else
                                        <span style="display:inline-flex;align-items:center;font-size:12px;font-weight:700;color:var(--red)">
                                            <span class="status-dot dot-red"></span>Tidak
                                        </span>
                                    @endif
                                </div>
                                <div class="slot-actions">
                                    {{-- Toggle --}}
                                    <form action="{{ route('admin.ketersediaan-guru.toggle', $slot->id) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="ico-btn" title="Toggle Status">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                                        </button>
                                    </form>
                                    {{-- Edit --}}
                                    <a href="{{ route('admin.ketersediaan-guru.edit', $slot->id) }}" class="ico-btn" title="Edit">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4z"/></svg>
                                    </a>
                                    {{-- Delete --}}
                                    <form action="{{ route('admin.ketersediaan-guru.destroy', $slot->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus slot ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="ico-btn danger" title="Hapus">
                                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    @endforeach
                @endif
            </div>

            {{-- Bulk Import Slot --}}
            <div class="bulk-section">
                <div class="bulk-header">
                    <div class="card-header-left">
                        <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                        <p class="card-title">Tambah Massal / Ganti Semua Slot</p>
                    </div>
                    <span style="font-size:12px;color:var(--red);font-weight:700;font-family:'Plus Jakarta Sans',sans-serif">
                        ⚠ Akan mengganti SEMUA slot yang ada
                    </span>
                </div>

                <form action="{{ route('admin.ketersediaan-guru.bulk-store', $guru->id) }}" method="POST" id="bulkForm">
                    @csrf
                    <div style="overflow-x:auto">
                        <table class="bulk-table">
                            <thead>
                                <tr>
                                    <th>Hari</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Mapel</th>
                                    <th>Jurusan</th>
                                    <th>Tersedia</th>
                                    <th>Catatan</th>
                                    <th style="width:36px"></th>
                                </tr>
                            </thead>
                            <tbody id="bulkBody">
                                <tr>
                                    <td>
                                        <select name="slots[0][hari]" required>
                                            <option value="">— Pilih —</option>
                                            @foreach($hariList as $h)
                                                <option value="{{ $h }}">{{ ucfirst($h) }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input type="time" name="slots[0][jam_mulai]" required></td>
                                    <td><input type="time" name="slots[0][jam_selesai]" required></td>
                                    <td>
                                        <select name="slots[0][mata_pelajaran_id]">
                                            <option value="">— Bebas —</option>
                                            @foreach($semuaMapel as $m)
                                                <option value="{{ $m->id }}">{{ $m->nama_mapel }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <select name="slots[0][jurusan_id]">
                                            <option value="">— Semua —</option>
                                            @foreach($semuaJurusan as $j)
                                                {{-- FIX: kolom DB adalah `nama` --}}
                                                <option value="{{ $j->id }}">{{ $j->nama }}</option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td style="text-align:center">
                                        <label class="toggle-sw">
                                            <input type="checkbox" name="slots[0][tersedia]" value="1" checked>
                                            <span class="toggle-sl"></span>
                                        </label>
                                    </td>
                                    <td><input type="text" name="slots[0][catatan]" placeholder="Opsional" style="width:100%;padding:6px 8px;border:1px solid var(--border);border-radius:var(--radius-sm);font-size:12.5px;background:var(--surface2);"></td>
                                    <td>
                                        <button type="button" class="del-row-btn" onclick="delRow(this)">
                                            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="bulk-footer">
                        <button type="button" class="add-row-btn" onclick="addRow()">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Tambah Baris
                        </button>
                        <button type="button" class="btn btn-danger btn-sm" onclick="confirmBulk()">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                            Simpan & Ganti Semua
                        </button>
                    </div>
                </form>
            </div>

        </div>

        {{-- ── SIDEBAR KANAN ── --}}
        <div style="display:flex;flex-direction:column;gap:16px">

            {{-- Mapel Diampu --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                        <p class="card-title">Mata Pelajaran Diampu</p>
                    </div>
                    <span class="badge badge-info">{{ $mapelDiampu->count() }}</span>
                </div>
                @if($mapelDiampu->isEmpty())
                    <div class="section-empty">Belum ada mata pelajaran yang diampu.</div>
                @else
                    <div class="mapel-list">
                        @foreach($mapelDiampu as $mp)
                        <div class="mapel-item">
                            <div class="mapel-icon">
                                <svg width="14" height="14" fill="none" stroke="var(--brand)" stroke-width="2" viewBox="0 0 24 24"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                            </div>
                            <div style="flex:1;min-width:0">
                                <p class="mapel-name">{{ $mp->nama_mapel }}</p>
                                <p class="mapel-meta">
                                    {{ $mp->kode_mapel ?? '' }}
                                    @if($mp->jurusan)
                                        @if($mp->kode_mapel) · @endif
                                        {{-- FIX: kolom DB adalah `nama` --}}
                                        {{ $mp->jurusan->nama ?? $mp->jurusan->first()?->nama ?? '' }}
                                    @endif
                                    @if($mp->pivot?->jam_per_minggu)
                                        · {{ $mp->pivot->jam_per_minggu }} jp/minggu
                                    @endif
                                </p>
                                @if($mp->pivot?->is_mapel_utama)
                                    <span class="badge" style="background:#fefce8;color:#a16207;font-size:10.5px;margin-top:3px">Mapel Utama</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Jadwal Aktif --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-header-left">
                        <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                        <p class="card-title">Jadwal Mengajar Aktif</p>
                    </div>
                    <span class="badge badge-aktif">{{ $jadwalAktif->flatten()->count() }}</span>
                </div>
                @if($jadwalAktif->isEmpty())
                    <div class="section-empty">Tidak ada jadwal aktif saat ini.</div>
                @else
                    @foreach($hariList as $hari)
                        @if(isset($jadwalAktif[$hari]))
                            @foreach($jadwalAktif[$hari] as $jadwal)
                            <div class="jadwal-item">
                                <p class="jadwal-hari">{{ ucfirst($hari) }} · {{ \Carbon\Carbon::parse($jadwal->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($jadwal->jam_selesai)->format('H:i') }}</p>
                                <p class="jadwal-detail">
                                    {{ $jadwal->mataPelajaran->nama_mapel ?? '-' }}
                                    @if($jadwal->kelas)
                                        — {{ $jadwal->kelas->nama_kelas ?? '' }}
                                        @if($jadwal->kelas->jurusan)
                                            ({{ $jadwal->kelas->jurusan->nama }})
                                        @endif
                                    @endif
                                </p>
                                @if($jadwal->ruang)
                                    <p style="font-size:11.5px;color:var(--text3)">{{ $jadwal->ruang->nama_ruang ?? '' }}</p>
                                @endif
                            </div>
                            @endforeach
                        @endif
                    @endforeach
                @endif
            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const hariList    = @json($hariList);
const semuaMapel  = @json($semuaMapel->map(fn($m) => ['id' => $m->id, 'nama_mapel' => $m->nama_mapel]));
const semuaJurusan= @json($semuaJurusan->map(fn($j) => ['id' => $j->id, 'nama' => $j->nama]));

let rowIdx = 1;

function buildRow(idx) {
    const hariOptions = hariList.map(h =>
        `<option value="${h}">${h.charAt(0).toUpperCase() + h.slice(1)}</option>`
    ).join('');

    const mapelOptions = '<option value="">— Bebas —</option>' +
        semuaMapel.map(m => `<option value="${m.id}">${m.nama_mapel}</option>`).join('');

    const jurusanOptions = '<option value="">— Semua —</option>' +
        semuaJurusan.map(j => `<option value="${j.id}">${j.nama}</option>`).join('');

    return `<tr>
        <td><select name="slots[${idx}][hari]" required><option value="">— Pilih —</option>${hariOptions}</select></td>
        <td><input type="time" name="slots[${idx}][jam_mulai]" required></td>
        <td><input type="time" name="slots[${idx}][jam_selesai]" required></td>
        <td><select name="slots[${idx}][mata_pelajaran_id]">${mapelOptions}</select></td>
        <td><select name="slots[${idx}][jurusan_id]">${jurusanOptions}</select></td>
        <td style="text-align:center">
            <label class="toggle-sw">
                <input type="checkbox" name="slots[${idx}][tersedia]" value="1" checked>
                <span class="toggle-sl"></span>
            </label>
        </td>
        <td><input type="text" name="slots[${idx}][catatan]" placeholder="Opsional" style="width:100%;padding:6px 8px;border:1px solid var(--border);border-radius:var(--radius-sm);font-size:12.5px;background:var(--surface2);"></td>
        <td><button type="button" class="del-row-btn" onclick="delRow(this)">
            <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button></td>
    </tr>`;
}

function addRow() {
    document.getElementById('bulkBody').insertAdjacentHTML('beforeend', buildRow(rowIdx++));
}

function delRow(btn) {
    const rows = document.querySelectorAll('#bulkBody tr');
    if (rows.length <= 1) { alert('Minimal harus ada 1 baris.'); return; }
    btn.closest('tr').remove();
}

function confirmBulk() {
    Swal.fire({
        title: 'Ganti Semua Slot?',
        html: 'Semua slot ketersediaan yang ada akan <strong>dihapus</strong> dan diganti dengan data baru ini.',
        icon: 'warning', showCancelButton: true,
        confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Ganti Semua!', cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) document.getElementById('bulkForm').submit(); });
}

// Swal success dari session (dirender setelah load)
@if(session('success'))
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
});
@endif
</script>
</x-app-layout>