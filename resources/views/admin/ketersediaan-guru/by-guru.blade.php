<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
:root {
    --brand:    #1f63db;
    --brand-h:  #3582f0;
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
.btn-back { background:var(--surface2); color:var(--text2); border:1px solid var(--border); }
.btn-back:hover { background:var(--surface3); }
.btn-primary { background:var(--brand); color:#fff; }
.btn-primary:hover { filter:brightness(.93); }
.btn-primary:disabled { opacity:.6; cursor:not-allowed; filter:none; }
.btn-danger { background:var(--red-bg); color:var(--red); border:1px solid var(--red-bd); }
.btn-danger:hover { background:#fecaca; filter:none; }
.btn-sm { padding:6px 12px; font-size:12px; border-radius:6px; }
.btn-edit   { background:var(--brand-50); color:var(--brand-700); border:1px solid var(--brand-100); }
.btn-edit:hover { background:var(--brand-100); filter:none; }
.btn-del    { background:#fff0f0; color:#dc2626; border:1px solid #fecaca; }
.btn-del:hover { background:#fee2e2; filter:none; }
.btn-toggle-on  { background:#dcfce7; color:#15803d; border:1px solid #bbf7d0; }
.btn-toggle-on:hover  { background:#bbf7d0; filter:none; }
.btn-toggle-off { background:#fef9c3; color:#a16207; border:1px solid #fde68a; }
.btn-toggle-off:hover { background:#fef08a; filter:none; }

.guru-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); padding:20px 24px; margin-bottom:20px; display:flex; align-items:center; justify-content:space-between; gap:16px; flex-wrap:wrap; }
.guru-avatar { width:48px; height:48px; border-radius:50%; background:var(--brand-50); border:2px solid var(--brand-100); display:flex; align-items:center; justify-content:center; font-family:'Plus Jakarta Sans',sans-serif; font-size:16px; font-weight:800; color:var(--brand-700); flex-shrink:0; }
.guru-info { display:flex; align-items:center; gap:14px; }
.guru-name { font-family:'Plus Jakarta Sans',sans-serif; font-size:16px; font-weight:800; color:var(--text); }
.guru-meta { font-size:12.5px; color:var(--text3); margin-top:2px; }
.guru-stats { display:flex; gap:20px; flex-wrap:wrap; }
.stat-item { text-align:center; }
.stat-val { font-family:'Plus Jakarta Sans',sans-serif; font-size:20px; font-weight:800; color:var(--text); }
.stat-label { font-size:11.5px; color:var(--text3); margin-top:2px; }

.hari-section { margin-bottom:20px; }
.hari-header { display:flex; align-items:center; gap:10px; margin-bottom:12px; }
.hari-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:14px; font-weight:800; color:var(--text); text-transform:capitalize; }
.hari-count { font-family:'Plus Jakarta Sans',sans-serif; font-size:12px; font-weight:600; color:var(--text3); }
.hari-line { flex:1; height:1px; background:var(--border); }
.hari-pill { display:inline-flex; align-items:center; padding:3px 12px; border-radius:6px; font-family:'Plus Jakarta Sans',sans-serif; font-size:12.5px; font-weight:800; text-transform:capitalize; flex-shrink:0; }
.hari-senin  { background:#eef2ff; color:#4338ca; border:1px solid #c7d2fe; }
.hari-selasa { background:var(--brand-50); color:var(--brand-700); border:1px solid var(--brand-100); }
.hari-rabu   { background:#f0fdf4; color:#15803d; border:1px solid #bbf7d0; }
.hari-kamis  { background:#fefce8; color:#a16207; border:1px solid #fde68a; }
.hari-jumat  { background:#fff7ed; color:#c2410c; border:1px solid #fed7aa; }
.hari-sabtu  { background:#fdf4ff; color:#7c3aed; border:1px solid #e9d5ff; }

.slots-grid { display:grid; grid-template-columns:repeat(auto-fill, minmax(240px, 1fr)); gap:10px; }
.slot-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius-sm); padding:14px 16px; transition:box-shadow .15s; }
.slot-card:hover { box-shadow:0 2px 8px rgba(0,0,0,.06); }
.slot-card.unavailable { background:var(--surface2); border-color:var(--border); opacity:.75; }
.slot-time { font-family:'Plus Jakarta Sans',sans-serif; font-size:17px; font-weight:800; color:var(--text); margin-bottom:4px; }
.slot-duration { font-size:12px; color:var(--text3); font-family:'DM Sans',sans-serif; margin-bottom:10px; }
.slot-footer { display:flex; align-items:center; justify-content:space-between; }
.badge { display:inline-flex; align-items:center; gap:4px; padding:3px 9px; border-radius:99px; font-family:'Plus Jakarta Sans',sans-serif; font-size:11px; font-weight:700; }
.badge-dot { width:5px; height:5px; border-radius:50%; }
.badge-tersedia { background:#dcfce7; color:#15803d; } .badge-tersedia .badge-dot { background:#15803d; }
.badge-tidak    { background:#fee2e2; color:#dc2626; } .badge-tidak .badge-dot { background:#dc2626; }
.slot-actions { display:flex; gap:4px; }

.empty-day { background:var(--surface2); border:1px dashed var(--border2); border-radius:var(--radius-sm); padding:16px; text-align:center; font-size:13px; color:var(--text3); }

.bulk-card { background:var(--surface); border:1px solid var(--border); border-radius:var(--radius); overflow:hidden; margin-top:28px; }
.bulk-header { padding:16px 20px; border-bottom:1px solid var(--border); display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:12px; }
.bulk-title { font-family:'Plus Jakarta Sans',sans-serif; font-size:14px; font-weight:800; color:var(--text); }
.bulk-body { padding:20px; }
.slot-row { display:grid; grid-template-columns:140px 1fr 1fr 1fr 36px; gap:10px; align-items:center; padding:10px 0; border-bottom:1px solid var(--surface3); }
.slot-row:last-child { border-bottom:none; }
.slot-row-header { display:grid; grid-template-columns:140px 1fr 1fr 1fr 36px; gap:10px; padding:0 0 8px; border-bottom:1px solid var(--border); margin-bottom:4px; }
.slot-row-header span { font-family:'Plus Jakarta Sans',sans-serif; font-size:11px; font-weight:700; color:var(--text3); text-transform:uppercase; letter-spacing:.05em; }
.field-inline select, .field-inline input { height:34px; padding:0 10px; border:1px solid var(--border); border-radius:6px; font-family:'DM Sans',sans-serif; font-size:13px; color:var(--text); background:var(--surface2); width:100%; outline:none; }
.field-inline select:focus, .field-inline input:focus { border-color:var(--brand-h); background:#fff; }
.toggle-sm { position:relative; display:inline-block; width:36px; height:20px; }
.toggle-sm input { opacity:0; width:0; height:0; }
.toggle-sm-slider { position:absolute; inset:0; border-radius:99px; background:var(--border2); cursor:pointer; transition:background .2s; }
.toggle-sm-slider::before { content:''; position:absolute; width:14px; height:14px; left:3px; top:3px; background:#fff; border-radius:50%; transition:transform .2s; box-shadow:0 1px 2px rgba(0,0,0,.2); }
.toggle-sm input:checked + .toggle-sm-slider { background:var(--brand); }
.toggle-sm input:checked + .toggle-sm-slider::before { transform:translateX(16px); }
.btn-remove-slot { width:32px; height:32px; border-radius:6px; background:var(--red-bg); color:var(--red); border:1px solid var(--red-bd); display:flex; align-items:center; justify-content:center; cursor:pointer; }
.btn-remove-slot:hover { background:#fecaca; }
.bulk-footer { padding:16px 20px; border-top:1px solid var(--border); background:var(--surface2); display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap; }
.info-note { background:var(--brand-50); border:1px solid var(--brand-100); border-radius:var(--radius-sm); padding:10px 14px; font-size:12.5px; color:#1d4ed8; font-family:'DM Sans',sans-serif; }

.empty-state { padding:60px 20px; text-align:center; }
.empty-icon { width:56px; height:56px; background:var(--surface2); border-radius:14px; display:flex; align-items:center; justify-content:center; margin:0 auto 14px; }

@media (max-width:680px) {
    .page { padding:16px; }
    .slots-grid { grid-template-columns:1fr; }
    .slot-row { grid-template-columns:1fr 1fr; gap:8px; }
    .slot-row-header { display:none; }
}
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
            <h1 class="page-title">Ketersediaan: {{ $guru->nama_lengkap }}</h1>
            <p class="page-sub">Lihat dan kelola semua slot ketersediaan guru ini</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.ketersediaan-guru.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.ketersediaan-guru.create') }}?guru_id={{ $guru->id }}" class="btn btn-primary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Slot
            </a>
        </div>
    </div>

    @if(session('success'))
        <div style="display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13.5px;background:#dcfce7;color:var(--green);border:1px solid #bbf7d0">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="display:flex;align-items:center;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13.5px;background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd)">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ session('error') }}
        </div>
    @endif
    @if($errors->any())
        <div style="display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13.5px;background:var(--red-bg);color:var(--red);border:1px solid var(--red-bd)">
            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <div>
                <strong style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">Terdapat {{ $errors->count() }} kesalahan:</strong>
                <ul style="margin:6px 0 0 16px;display:flex;flex-direction:column;gap:2px">
                    @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
                </ul>
            </div>
        </div>
    @endif

    @php $totalSlot = $ketersediaan->flatten()->count(); $totalTersedia = $ketersediaan->flatten()->where('tersedia', true)->count(); @endphp
    <div class="guru-card">
        <div class="guru-info">
            <div class="guru-avatar">{{ strtoupper(substr($guru->nama_lengkap, 0, 2)) }}</div>
            <div>
                <p class="guru-name">{{ $guru->nama_lengkap }}</p>
                <p class="guru-meta">
                    NIP: {{ $guru->nip ?? '-' }}
                    @if($guru->status_kepegawaian) &nbsp;·&nbsp; {{ strtoupper($guru->status_kepegawaian) }} @endif
                </p>
            </div>
        </div>
        <div class="guru-stats">
            <div class="stat-item">
                <p class="stat-val">{{ $totalSlot }}</p>
                <p class="stat-label">Total Slot</p>
            </div>
            <div class="stat-item">
                <p class="stat-val" style="color:var(--green)">{{ $totalTersedia }}</p>
                <p class="stat-label">Tersedia</p>
            </div>
            <div class="stat-item">
                <p class="stat-val" style="color:var(--red)">{{ $totalSlot - $totalTersedia }}</p>
                <p class="stat-label">Tidak Tersedia</p>
            </div>
            <div class="stat-item">
                <p class="stat-val">{{ $ketersediaan->count() }}</p>
                <p class="stat-label">Hari Aktif</p>
            </div>
        </div>
    </div>

    @if($ketersediaan->isEmpty())
        <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius)">
            <div class="empty-state">
                <div class="empty-icon">
                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                </div>
                <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px">Belum ada slot ketersediaan</p>
                <p style="font-size:13px;color:var(--text3);margin-bottom:16px">Tambah slot ketersediaan untuk guru ini menggunakan form di bawah</p>
            </div>
        </div>
    @else
        @foreach($hariList as $hari)
            @if(isset($ketersediaan[$hari]) && $ketersediaan[$hari]->isNotEmpty())
            <div class="hari-section">
                <div class="hari-header">
                    <span class="hari-pill hari-{{ $hari }}">{{ ucfirst($hari) }}</span>
                    <span class="hari-count">{{ $ketersediaan[$hari]->count() }} slot</span>
                    <span class="hari-line"></span>
                </div>
                <div class="slots-grid">
                    @foreach($ketersediaan[$hari] as $k)
                    <div class="slot-card {{ !$k->tersedia ? 'unavailable' : '' }}">
                        <p class="slot-time">
                            {{ \Carbon\Carbon::parse($k->jam_mulai)->format('H:i') }}
                            <span style="color:var(--text3);font-size:14px;font-weight:600">–</span>
                            {{ \Carbon\Carbon::parse($k->jam_selesai)->format('H:i') }}
                        </p>
                        <p class="slot-duration">{{ $k->durasi_menit }} menit</p>
                        <div class="slot-footer">
                            @if($k->tersedia)
                                <span class="badge badge-tersedia"><span class="badge-dot"></span>Tersedia</span>
                            @else
                                <span class="badge badge-tidak"><span class="badge-dot"></span>Tidak Tersedia</span>
                            @endif
                            <div class="slot-actions">
                                <a href="{{ route('admin.ketersediaan-guru.edit', $k->id) }}" class="btn btn-sm btn-edit" style="padding:4px 10px;font-size:11.5px">Edit</a>
                                <form action="{{ route('admin.ketersediaan-guru.toggle', $k->id) }}" method="POST" id="tgForm-{{ $k->id }}">
                                    @csrf @method('PATCH')
                                    <button type="button" class="btn btn-sm {{ $k->tersedia ? 'btn-toggle-on' : 'btn-toggle-off' }}" style="padding:4px 10px;font-size:11.5px"
                                        onclick="confirmToggle(document.getElementById('tgForm-{{ $k->id }}'), {{ $k->tersedia ? 'true' : 'false' }})">
                                        {{ $k->tersedia ? '✓' : '✗' }}
                                    </button>
                                </form>
                                <form action="{{ route('admin.ketersediaan-guru.destroy', $k->id) }}" method="POST" id="dlForm-{{ $k->id }}">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del" style="padding:4px 8px;font-size:11.5px"
                                        onclick="confirmDelete(document.getElementById('dlForm-{{ $k->id }}'), '{{ \Carbon\Carbon::parse($k->jam_mulai)->format('H:i') }}')">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        @endforeach
    @endif

    <div class="bulk-card">
        <div class="bulk-header">
            <div>
                <p class="bulk-title">Bulk Slot — Atur Ulang Semua Ketersediaan</p>
                <p style="font-size:12.5px;color:var(--text3);margin-top:3px">Simpan akan menghapus semua slot lama dan menggantinya dengan yang baru</p>
            </div>
            <button type="button" class="btn btn-primary btn-sm" onclick="addSlotRow()">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Baris
            </button>
        </div>
        <form action="{{ route('admin.ketersediaan-guru.bulk-store', $guru->id) }}" method="POST" id="bulkForm">
            @csrf
            <div class="bulk-body">
                <div class="info-note" style="margin-bottom:16px">
                    <strong>Perhatian:</strong> Menyimpan bulk akan menghapus <strong>semua {{ $totalSlot }} slot</strong> yang ada untuk guru ini dan menggantinya dengan data baru.
                </div>
                <div class="slot-row-header">
                    <span>Hari <span style="color:var(--brand)">*</span></span>
                    <span>Jam Mulai <span style="color:var(--brand)">*</span></span>
                    <span>Jam Selesai <span style="color:var(--brand)">*</span></span>
                    <span>Tersedia</span>
                    <span></span>
                </div>
                <div id="slotContainer">
                </div>
            </div>
            <div class="bulk-footer">
                <p style="font-size:12.5px;color:var(--text3)" id="slotCount">0 baris slot</p>
                <div style="display:flex;gap:8px">
                    <button type="button" class="btn btn-danger btn-sm" onclick="clearAllSlots()">Hapus Semua Baris</button>
                    <button type="submit" class="btn btn-primary" id="btnBulk">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                        Simpan Semua Slot
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
@endif
@if($errors->any())
Swal.fire({
    icon:'error', title:'Terdapat {{ $errors->count() }} Kesalahan',
    html:`<ul style="text-align:left;padding-left:16px;margin:0;display:flex;flex-direction:column;gap:4px">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>`,
    confirmButtonColor:'#1f63db',
});
@endif

const hariOpts = ['senin','selasa','rabu','kamis','jumat','sabtu'];
let slotIdx = 0;

function buildHariOptions(selected = '') {
    return hariOpts.map(h => `<option value="${h}" ${selected === h ? 'selected' : ''}>${h.charAt(0).toUpperCase()+h.slice(1)}</option>`).join('');
}

function addSlotRow(hari = '', jamMulai = '', jamSelesai = '', tersedia = true) {
    const idx = slotIdx++;
    const container = document.getElementById('slotContainer');
    const row = document.createElement('div');
    row.className = 'slot-row';
    row.id = `row-${idx}`;
    row.innerHTML = `
        <div class="field-inline">
            <select name="slots[${idx}][hari]" required>
                <option value="">Pilih Hari</option>
                ${buildHariOptions(hari)}
            </select>
        </div>
        <div class="field-inline">
            <input type="time" name="slots[${idx}][jam_mulai]" value="${jamMulai}" required>
        </div>
        <div class="field-inline">
            <input type="time" name="slots[${idx}][jam_selesai]" value="${jamSelesai}" required>
        </div>
        <div style="display:flex;align-items:center;gap:8px">
            <input type="hidden" name="slots[${idx}][tersedia]" value="0">
            <label class="toggle-sm">
                <input type="checkbox" name="slots[${idx}][tersedia]" value="1" ${tersedia ? 'checked' : ''}>
                <span class="toggle-sm-slider"></span>
            </label>
        </div>
        <button type="button" class="btn-remove-slot" onclick="removeRow(${idx})" title="Hapus baris">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    `;
    container.appendChild(row);
    updateCount();
}

function removeRow(idx) {
    const row = document.getElementById(`row-${idx}`);
    if (row) { row.remove(); updateCount(); }
}

function clearAllSlots() {
    Swal.fire({
        title:'Hapus Semua Baris?',
        text:'Semua baris slot yang sedang diedit akan dihapus dari form.',
        icon:'warning', showCancelButton:true,
        confirmButtonColor:'#dc2626', cancelButtonColor:'#64748b',
        confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal'
    }).then(r => {
        if (r.isConfirmed) {
            document.getElementById('slotContainer').innerHTML = '';
            slotIdx = 0;
            updateCount();
        }
    });
}

function updateCount() {
    const c = document.getElementById('slotContainer').querySelectorAll('.slot-row').length;
    document.getElementById('slotCount').textContent = `${c} baris slot`;
}

document.getElementById('bulkForm').addEventListener('submit', function(e) {
    const rows = document.getElementById('slotContainer').querySelectorAll('.slot-row').length;
    if (rows === 0) {
        e.preventDefault();
        Swal.fire({ icon:'warning', title:'Form Kosong', text:'Tambahkan minimal 1 slot sebelum menyimpan.', confirmButtonColor:'#1f63db' });
        return;
    }
    Swal.fire({
        title:'Simpan Semua Slot?',
        html:`Ini akan <strong>menghapus {{ $totalSlot }} slot lama</strong> dan menggantinya dengan <strong>${rows} slot baru</strong>.`,
        icon:'warning', showCancelButton:true,
        confirmButtonColor:'#1f63db', cancelButtonColor:'#64748b',
        confirmButtonText:'Ya, Simpan!', cancelButtonText:'Batal',
    }).then(r => {
        if (r.isConfirmed) {
            const btn = document.getElementById('btnBulk');
            btn.disabled = true;
            btn.innerHTML = `<svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="animation:spin .7s linear infinite"><path d="M21 12a9 9 0 1 1-6.219-8.56"/></svg> Menyimpan…`;
            this.submit();
        }
    });
    e.preventDefault();
});

function confirmToggle(form, currentlyTersedia) {
    const newStatus = currentlyTersedia ? 'Tidak Tersedia' : 'Tersedia';
    Swal.fire({
        title:'Ubah Status?',
        text:`Slot akan diubah menjadi "${newStatus}".`,
        icon:'question', showCancelButton:true,
        confirmButtonColor:'#1f63db', cancelButtonColor:'#64748b',
        confirmButtonText:'Ya, Ubah!', cancelButtonText:'Batal',
    }).then(r => { if (r.isConfirmed) form.submit(); });
}

function confirmDelete(form, jam) {
    Swal.fire({
        title:'Hapus Slot?',
        html:`Slot pukul <strong>${jam}</strong> akan dihapus permanen.`,
        icon:'warning', showCancelButton:true,
        confirmButtonColor:'#dc2626', cancelButtonColor:'#64748b',
        confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal',
    }).then(r => { if (r.isConfirmed) form.submit(); });
}

@foreach($ketersediaan as $hari => $slots)
    @foreach($slots as $k)
        addSlotRow('{{ $k->hari }}', '{{ \Carbon\Carbon::parse($k->jam_mulai)->format('H:i') }}', '{{ \Carbon\Carbon::parse($k->jam_selesai)->format('H:i') }}', {{ $k->tersedia ? 'true' : 'false' }});
    @endforeach
@endforeach
</script>
</x-app-layout>