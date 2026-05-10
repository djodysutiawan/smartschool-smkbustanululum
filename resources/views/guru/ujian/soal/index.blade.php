<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
:root {
    --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
    --brand-100:#d9ebff;--brand-50:#eef6ff;
    --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
    --border:#e2e8f0;--border2:#cbd5e1;
    --text:#0f172a;--text2:#475569;--text3:#94a3b8;
    --green:#15803d;--red:#dc2626;--purple:#7c3aed;--yellow:#a16207;
    --radius:10px;--radius-sm:7px;
}
*{box-sizing:border-box}
.page{padding:28px 28px 48px;max-width:1400px;margin:0 auto}
.breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;flex-wrap:wrap}
.breadcrumb a{color:var(--text3);text-decoration:none;transition:color .15s}
.breadcrumb a:hover{color:var(--text)}
.breadcrumb .sep{color:var(--border2)}
.breadcrumb .cur{color:var(--text2)}
.page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:20px;flex-wrap:wrap}
.page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
.page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
.header-actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap}

.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
.btn:hover{filter:brightness(.93)}
.btn-primary{background:var(--brand-600);color:#fff}
.btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
.btn-secondary:hover{background:var(--surface3);filter:none}
.btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}
.btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
.btn-edit:hover{background:var(--brand-100);filter:none}
.btn-del{background:#fff0f0;color:var(--red);border:1px solid #fecaca}
.btn-del:hover{background:#fee2e2;filter:none}
.btn-essay{background:#faf5ff;color:var(--purple);border:1px solid #e9d5ff}
.btn-essay:hover{background:#f3e8ff;filter:none}

/* Stats */
.stats-strip{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:20px}
.stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 16px;display:flex;align-items:center;gap:10px;transition:box-shadow .2s}
.stat-card:hover{box-shadow:0 4px 14px rgba(0,0,0,.06)}
.stat-icon{width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.stat-icon.blue{background:#eff6ff}
.stat-icon.green{background:#f0fdf4}
.stat-icon.purple{background:#faf5ff}
.stat-icon.yellow{background:#fefce8}
.stat-icon.red{background:#fff0f0}
.stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
.stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.1}
.stat-sub{font-size:11px;color:var(--text3);margin-top:1px}

/* Alert */
.alert-warn{background:#fffbeb;border:1px solid #fde68a;border-radius:var(--radius-sm);padding:10px 16px;margin-bottom:16px;display:flex;gap:10px;align-items:flex-start}
.alert-warn p{font-size:12.5px;color:#92400e;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;line-height:1.5}
.alert-essay{background:#faf5ff;border:1px solid #e9d5ff;border-radius:var(--radius-sm);padding:10px 16px;margin-bottom:16px;display:flex;gap:10px;align-items:center;justify-content:space-between;flex-wrap:wrap}
.alert-essay p{font-size:12.5px;color:var(--purple);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600}

/* Table card */
.table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
.table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:8px}
.table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
.table-info span{font-weight:400;color:var(--text3);margin-left:6px}
.table-hint{font-size:12px;color:var(--text3);font-family:'DM Sans',sans-serif;display:flex;align-items:center;gap:5px}
.table-wrap{overflow-x:auto}
table{width:100%;border-collapse:collapse;font-size:13.5px}
thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
thead th.center{text-align:center}
thead th.right{text-align:right}
tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
tbody tr:last-child{border-bottom:none}
tbody tr:hover{background:#fafbff}
tbody tr.drag-over{background:var(--brand-50);border-color:var(--brand-500)}
tbody tr.dragging{opacity:.4}
td{padding:10px 14px;color:var(--text);vertical-align:middle}
td.center{text-align:center}
td.right{text-align:right}
td.muted{color:var(--text3)}

/* Drag handle */
.drag-handle{cursor:grab;color:var(--text3);padding:4px;display:flex;align-items:center;border-radius:4px;transition:color .15s,background .15s;user-select:none}
.drag-handle:hover{color:var(--text2);background:var(--surface3)}
.drag-handle:active{cursor:grabbing}

/* Nomor soal badge */
.soal-no{width:28px;height:28px;background:var(--brand-50);color:var(--brand-700);border-radius:7px;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;flex-shrink:0}

/* Jenis pill */
.jenis-pill{display:inline-flex;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
.jenis-pill.pilihan_ganda{background:var(--brand-50);color:var(--brand-700)}
.jenis-pill.benar_salah{background:#f0fdf4;color:var(--green)}
.jenis-pill.essay{background:#faf5ff;color:var(--purple)}

/* Bobot bar */
.bobot-wrap{display:flex;align-items:center;gap:8px}
.bobot-bar{width:60px;height:5px;background:var(--surface3);border-radius:99px;overflow:hidden;flex-shrink:0}
.bobot-fill{height:100%;background:var(--brand-500);border-radius:99px}
.bobot-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:800;color:var(--brand-600);min-width:28px}

/* Action group */
.action-group{display:flex;align-items:center;gap:5px;justify-content:center}

/* Empty */
.empty-state{padding:60px 20px;text-align:center}
.empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
.empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
.empty-sub{font-size:13px;color:var(--text3);margin-bottom:20px}

/* Bobot total footer */
.bobot-footer{display:flex;align-items:center;justify-content:flex-end;gap:10px;padding:12px 20px;border-top:1px solid var(--border);background:var(--surface2)}
.bobot-footer-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2)}
.bobot-footer-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:800}
.bobot-footer-val.ok{color:var(--green)}
.bobot-footer-val.warn{color:var(--red)}

@keyframes spin{to{transform:rotate(360deg)}}
@media(max-width:900px){
    .stats-strip{grid-template-columns:repeat(3,1fr)}
    .page{padding:16px}
}
@media(max-width:600px){
    .stats-strip{grid-template-columns:1fr 1fr}
}
</style>

<div class="page">

    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('guru.ujian.index') }}">Kelola Ujian</a>
        <span class="sep">›</span>
        <a href="{{ route('guru.ujian.show', $ujian) }}">{{ Str::limit($ujian->judul, 35) }}</a>
        <span class="sep">›</span>
        <span class="cur">Bank Soal</span>
    </nav>

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Bank Soal</h1>
            <p class="page-sub">{{ $ujian->judul }} &middot; {{ $ujian->mataPelajaran->nama_mapel ?? '—' }} &middot; {{ $ujian->kelas->nama_kelas ?? '—' }}</p>
        </div>
        <div class="header-actions">
            @if($stats['essay_count'] > 0)
            <a href="{{ route('guru.ujian.soal.koreksi.index', $ujian) }}" class="btn btn-essay">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 9.5-9.5z"/></svg>
                Koreksi Essay
                @if(isset($stats['essay_belum_koreksi']) && $stats['essay_belum_koreksi'] > 0)
                    <span style="background:var(--purple);color:#fff;border-radius:99px;padding:1px 7px;font-size:11px">{{ $stats['essay_belum_koreksi'] }}</span>
                @endif
            </a>
            @endif
            <a href="{{ route('guru.ujian.soal.create', $ujian) }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Tambah Soal
            </a>
            <a href="{{ route('guru.ujian.show', $ujian) }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="15" height="15" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Soal</p>
                <p class="stat-val">{{ $stats['total_soal'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon {{ $stats['total_bobot'] == 100 ? 'green' : 'red' }}">
                <svg width="15" height="15" fill="none" stroke="{{ $stats['total_bobot'] == 100 ? '#15803d' : '#dc2626' }}" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Bobot</p>
                <p class="stat-val" style="color:{{ $stats['total_bobot'] == 100 ? 'var(--green)' : 'var(--red)' }}">{{ $stats['total_bobot'] }}</p>
                <p class="stat-sub">{{ $stats['total_bobot'] == 100 ? '✓ Sudah 100' : 'Target: 100' }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="15" height="15" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/></svg>
            </div>
            <div>
                <p class="stat-label">Pilihan Ganda</p>
                <p class="stat-val">{{ $stats['pg_count'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="15" height="15" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Benar/Salah</p>
                <p class="stat-val">{{ $stats['bs_count'] }}</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon purple">
                <svg width="15" height="15" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 9.5-9.5z"/></svg>
            </div>
            <div>
                <p class="stat-label">Essay</p>
                <p class="stat-val">{{ $stats['essay_count'] }}</p>
            </div>
        </div>
    </div>

    {{-- Warning bobot != 100 --}}
    @if($stats['total_soal'] > 0 && $stats['total_bobot'] != 100)
    <div class="alert-warn">
        <svg width="16" height="16" fill="none" stroke="#92400e" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
        <p>Total bobot soal saat ini <strong>{{ $stats['total_bobot'] }}</strong>, bukan 100. Nilai siswa akan dihitung dari proporsi bobot — pastikan totalnya = 100 agar akurat.</p>
    </div>
    @endif

    {{-- Alert ada jawaban siswa --}}
    @if($stats['ada_jawaban'])
    <div class="alert-warn">
        <svg width="16" height="16" fill="none" stroke="#92400e" stroke-width="2" viewBox="0 0 24 24" style="flex-shrink:0;margin-top:1px"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        <p>Sudah ada siswa yang mengerjakan ujian ini. Mengubah atau menghapus soal dapat mempengaruhi perhitungan nilai yang sudah ada.</p>
    </div>
    @endif

    {{-- Tabel Soal --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Soal
                @if($soalList->count() > 0)
                    <span>— {{ $soalList->count() }} soal</span>
                @endif
            </p>
            @if($soalList->count() > 1)
            <p class="table-hint">
                <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/></svg>
                Seret baris untuk mengubah urutan
            </p>
            @endif
        </div>

        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:36px"></th>
                        <th style="width:52px" class="center">No</th>
                        <th>Pertanyaan</th>
                        <th class="center">Jenis</th>
                        <th class="right">Bobot</th>
                        <th class="center" style="width:140px">Aksi</th>
                    </tr>
                </thead>
                <tbody id="soalTbody">
                    @forelse($soalList as $soal)
                    <tr data-id="{{ $soal->id }}" draggable="true">
                        {{-- Drag handle --}}
                        <td>
                            <div class="drag-handle" title="Seret untuk reorder">
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="3" y1="9" x2="21" y2="9"/><line x1="3" y1="15" x2="21" y2="15"/></svg>
                            </div>
                        </td>
                        {{-- Nomor --}}
                        <td class="center">
                            <div class="soal-no">{{ $soal->nomor_soal }}</div>
                        </td>
                        {{-- Pertanyaan --}}
                        <td>
                            <div style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:13px;color:var(--text);line-height:1.5">
                                {{ Str::limit(strip_tags($soal->pertanyaan), 100) }}
                            </div>
                            @if($soal->gambar_soal)
                            <div style="margin-top:4px;display:flex;align-items:center;gap:4px;font-size:11.5px;color:var(--text3)">
                                <svg width="11" height="11" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                Ada gambar
                            </div>
                            @endif
                            @if($soal->jenis_soal === 'pilihan_ganda' || $soal->jenis_soal === 'benar_salah')
                            <div style="margin-top:5px;display:flex;gap:5px;flex-wrap:wrap">
                                @foreach($soal->pilihan as $p)
                                <span style="font-size:11px;padding:1px 7px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;
                                    background:{{ $p->adalah_benar ? '#dcfce7' : 'var(--surface3)' }};
                                    color:{{ $p->adalah_benar ? 'var(--green)' : 'var(--text3)' }};
                                    border:1px solid {{ $p->adalah_benar ? '#bbf7d0' : 'var(--border)' }}">
                                    {{ $p->kode_pilihan }}{{ $p->adalah_benar ? ' ✓' : '' }}
                                </span>
                                @endforeach
                            </div>
                            @endif
                        </td>
                        {{-- Jenis --}}
                        <td class="center">
                            <span class="jenis-pill {{ $soal->jenis_soal }}">
                                @if($soal->jenis_soal === 'pilihan_ganda') PG
                                @elseif($soal->jenis_soal === 'benar_salah') B/S
                                @else Essay
                                @endif
                            </span>
                        </td>
                        {{-- Bobot --}}
                        <td class="right">
                            <div class="bobot-wrap" style="justify-content:flex-end">
                                <div class="bobot-bar">
                                    <div class="bobot-fill" style="width:{{ min(100, $soal->bobot) }}%"></div>
                                </div>
                                <span class="bobot-val">{{ $soal->bobot }}</span>
                            </div>
                        </td>
                        {{-- Aksi --}}
                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('guru.ujian.soal.edit', [$ujian, $soal]) }}" class="btn btn-sm btn-edit">Edit</a>
                                <form action="{{ route('guru.ujian.soal.destroy', [$ujian, $soal]) }}" method="POST"
                                      id="delSoal-{{ $soal->id }}" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-del"
                                        onclick="confirmDelete(document.getElementById('delSoal-{{ $soal->id }}'), {{ $soal->nomor_soal }})">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
                                </div>
                                <p class="empty-title">Belum ada soal</p>
                                <p class="empty-sub">Tambahkan soal pertama untuk ujian ini.</p>
                                <a href="{{ route('guru.ujian.soal.create', $ujian) }}" class="btn btn-primary">
                                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                                    Tambah Soal Pertama
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($soalList->count() > 0)
        <div class="bobot-footer">
            <span class="bobot-footer-label">Total Bobot:</span>
            <span class="bobot-footer-val {{ $stats['total_bobot'] == 100 ? 'ok' : 'warn' }}">
                {{ $stats['total_bobot'] }} / 100
            </span>
        </div>
        @endif
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ── Flash messages ────────────────────────────────────────────────────────────
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
@endif

// ── Confirm delete ────────────────────────────────────────────────────────────
function confirmDelete(form, nomor) {
    Swal.fire({
        title: 'Hapus Soal?',
        html: `Soal nomor <strong>${nomor}</strong> akan dihapus permanen.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal',
    }).then(r => { if (r.isConfirmed) form.submit(); });
}

// ── Drag & Drop Reorder ───────────────────────────────────────────────────────
(function () {
    const tbody    = document.getElementById('soalTbody');
    if (!tbody) return;

    let dragged = null;

    tbody.addEventListener('dragstart', e => {
        dragged = e.target.closest('tr');
        if (!dragged) return;
        dragged.classList.add('dragging');
        e.dataTransfer.effectAllowed = 'move';
    });

    tbody.addEventListener('dragend', e => {
        const row = e.target.closest('tr');
        if (row) row.classList.remove('dragging');
        tbody.querySelectorAll('tr').forEach(r => r.classList.remove('drag-over'));
        saveOrder();
    });

    tbody.addEventListener('dragover', e => {
        e.preventDefault();
        const target = e.target.closest('tr');
        if (!target || target === dragged) return;
        tbody.querySelectorAll('tr').forEach(r => r.classList.remove('drag-over'));
        target.classList.add('drag-over');

        const rows     = [...tbody.querySelectorAll('tr[data-id]')];
        const dragIdx  = rows.indexOf(dragged);
        const targIdx  = rows.indexOf(target);
        if (dragIdx < targIdx) {
            target.after(dragged);
        } else {
            target.before(dragged);
        }
    });

    tbody.addEventListener('dragleave', e => {
        const target = e.target.closest('tr');
        if (target) target.classList.remove('drag-over');
    });

    function saveOrder() {
        const order = [...tbody.querySelectorAll('tr[data-id]')].map(r => r.dataset.id);
        // Update nomor tampilan
        tbody.querySelectorAll('tr[data-id]').forEach((r, i) => {
            const badge = r.querySelector('.soal-no');
            if (badge) badge.textContent = i + 1;
        });

        fetch('{{ route('guru.ujian.soal.reorder', $ujian) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({ order }),
        })
        .then(r => r.json())
        .then(d => {
            if (!d.success) {
                Swal.fire({ icon:'error', title:'Gagal', text:'Urutan gagal disimpan.', confirmButtonColor:'#1f63db' });
            }
        })
        .catch(() => {});
    }
})();
</script>
</x-app-layout>