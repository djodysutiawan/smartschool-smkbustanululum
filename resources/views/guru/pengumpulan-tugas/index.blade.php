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
    .btn-detail{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
    .btn-detail:hover{background:#dcfce7;filter:none}
    .btn-nilai{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-nilai:hover{background:var(--brand-100);filter:none}

    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:12px;margin-bottom:20px}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;transition:box-shadow .2s}
    .stat-card:hover{box-shadow:0 4px 16px rgba(0,0,0,.06)}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .stat-icon.blue{background:#eff6ff}
    .stat-icon.green{background:#f0fdf4}
    .stat-icon.yellow{background:#fefce8}
    .stat-icon.red{background:#fff0f0}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px}
    .stat-sub{font-size:11px;color:var(--text3);margin-top:1px}

    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 20px;margin-bottom:16px}
    .filter-row{display:flex;flex-wrap:wrap;gap:10px;align-items:center}
    .filter-row select,.filter-row input[type=text]{height:36px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
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
    .badge-belum_dikumpulkan{background:#f1f5f9;color:#64748b}        .badge-belum_dikumpulkan .badge-dot{background:#94a3b8}
    .badge-dikumpulkan      {background:#dcfce7;color:#15803d}         .badge-dikumpulkan       .badge-dot{background:#15803d}
    .badge-terlambat        {background:#fefce8;color:#a16207}         .badge-terlambat         .badge-dot{background:#a16207}
    .badge-sudah_dinilai    {background:#eff6ff;color:#1d4ed8}         .badge-sudah_dinilai     .badge-dot{background:#3b82f6}

    .nilai-chip{display:inline-flex;align-items:center;justify-content:center;width:44px;height:26px;border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800}
    .nilai-high  {background:#dcfce7;color:#15803d}
    .nilai-mid   {background:#fefce8;color:#a16207}
    .nilai-low   {background:#fee2e2;color:#dc2626}
    .nilai-none  {background:var(--surface2);color:var(--text3)}

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

    {{-- Modal Nilai --}}
    .modal-overlay{display:none;position:fixed;inset:0;background:rgba(15,23,42,.45);z-index:300;align-items:center;justify-content:center}
    .modal-overlay.active{display:flex}
    .modal{background:var(--surface);border-radius:var(--radius);width:420px;max-width:calc(100vw - 32px);box-shadow:0 20px 60px rgba(0,0,0,.15);overflow:hidden}
    .modal-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--border)}
    .modal-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text)}
    .modal-close{width:28px;height:28px;display:flex;align-items:center;justify-content:center;border:none;background:var(--surface2);border-radius:6px;cursor:pointer;color:var(--text3)}
    .modal-close:hover{background:var(--surface3);color:var(--text)}
    .modal-body{padding:20px}
    .modal-footer{display:flex;gap:8px;justify-content:flex-end;padding:14px 20px;border-top:1px solid var(--border);background:var(--surface2)}
    .field{display:flex;flex-direction:column;gap:5px;margin-bottom:14px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}
    .field input,.field textarea{padding:9px 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s}
    .field input:focus,.field textarea:focus{border-color:var(--brand-500);background:#fff}
    .field textarea{resize:vertical;min-height:80px}

    @media(max-width:640px){
        .stats-strip{grid-template-columns:1fr 1fr}
        .page{padding:16px}
        .header-actions{width:100%}
    }
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Nilai Pengumpulan</h1>
            <p class="page-sub">Periksa dan beri nilai hasil pengumpulan tugas siswa</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.tugas.index') }}" class="btn btn-secondary">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                Lihat Semua Tugas
            </a>
        </div>
    </div>

    {{-- Stats --}}
    @php
        $guruId        = auth()->user()->guru->id;
        $totalKumpul   = $pengumpulan->total();
        $totalDikumpul = \App\Models\PengumpulanTugas::whereHas('tugas', fn($q)=>$q->where('guru_id',$guruId))->where('status','dikumpulkan')->count();
        $totalTerlambat= \App\Models\PengumpulanTugas::whereHas('tugas', fn($q)=>$q->where('guru_id',$guruId))->where('status','terlambat')->count();
        $totalDinilai  = \App\Models\PengumpulanTugas::whereHas('tugas', fn($q)=>$q->where('guru_id',$guruId))->where('status','sudah_dinilai')->count();
    @endphp
    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            </div>
            <div>
                <p class="stat-label">Total Masuk</p>
                <p class="stat-val">{{ $totalKumpul }}</p>
                <p class="stat-sub">semua pengumpulan</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div>
                <p class="stat-label">Dikumpulkan</p>
                <p class="stat-val">{{ $totalDikumpul }}</p>
                <p class="stat-sub">tepat waktu</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon yellow">
                <svg width="18" height="18" fill="none" stroke="#a16207" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <div>
                <p class="stat-label">Terlambat</p>
                <p class="stat-val">{{ $totalTerlambat }}</p>
                <p class="stat-sub">lewat batas waktu</p>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="18" height="18" fill="none" stroke="#1d4ed8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4 12.5-12.5z"/></svg>
            </div>
            <div>
                <p class="stat-label">Sudah Dinilai</p>
                <p class="stat-val">{{ $totalDinilai }}</p>
                <p class="stat-sub">sudah mendapat nilai</p>
            </div>
        </div>
    </div>

    {{-- Filter --}}
    <div class="filter-card">
        <form method="GET" action="{{ route('guru.pengumpulan-tugas.index') }}">
            <div class="filter-row">
                <select name="tugas_id" style="min-width:220px">
                    <option value="">Semua Tugas</option>
                    @foreach($tugasList as $t)
                        <option value="{{ $t->id }}" {{ request('tugas_id') == $t->id ? 'selected' : '' }}>
                            {{ Str::limit($t->judul, 40) }}
                        </option>
                    @endforeach
                </select>

                <select name="status">
                    <option value="">Semua Status</option>
                    @foreach($statusList as $key => $label)
                        <option value="{{ $key }}" {{ request('status') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>

                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama siswa…" style="min-width:200px">

                <div class="filter-sep"></div>
                <a href="{{ route('guru.pengumpulan-tugas.index') }}" class="btn-reset">Reset</a>
                <button type="submit" class="btn-filter">Terapkan</button>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Daftar Pengumpulan
                @if($pengumpulan->total() > 0)
                    <span>— menampilkan {{ $pengumpulan->firstItem() }}–{{ $pengumpulan->lastItem() }} dari {{ $pengumpulan->total() }} data</span>
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
                        <th>Siswa</th>
                        <th>Kelas</th>
                        <th>Tugas</th>
                        <th>Dikumpulkan Pada</th>
                        <th class="center">Status</th>
                        <th class="center">Nilai</th>
                        <th class="center" style="width:160px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengumpulan as $index => $p)
                    <tr>
                        <td><span class="no-col">{{ $pengumpulan->firstItem() + $index }}</span></td>

                        <td>
                            <div class="two-line">
                                <p class="primary">{{ $p->siswa->nama_lengkap ?? '—' }}</p>
                                <p class="secondary">NIS: {{ $p->siswa->nis ?? '—' }}</p>
                            </div>
                        </td>

                        <td class="muted" style="font-size:12.5px">{{ $p->siswa->kelas->nama_kelas ?? '—' }}</td>

                        <td>
                            <div class="two-line">
                                <p class="primary" style="font-size:13px">{{ Str::limit($p->tugas->judul ?? '—', 40) }}</p>
                                <p class="secondary">{{ $p->tugas->mataPelajaran->nama_mapel ?? '—' }}</p>
                            </div>
                        </td>

                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:13px">
                            {{ $p->created_at ? $p->created_at->format('d M Y, H:i') : '—' }}
                        </td>

                        <td class="center">
                            <span class="badge badge-{{ $p->status }}">
                                <span class="badge-dot"></span>
                                {{ $statusList[$p->status] ?? ucfirst($p->status) }}
                            </span>
                        </td>

                        <td class="center">
                            @php
                                $nilaiClass = 'nilai-none';
                                if ($p->nilai !== null) {
                                    if ($p->nilai >= 75) $nilaiClass = 'nilai-high';
                                    elseif ($p->nilai >= 50) $nilaiClass = 'nilai-mid';
                                    else $nilaiClass = 'nilai-low';
                                }
                            @endphp
                            <span class="nilai-chip {{ $nilaiClass }}">
                                {{ $p->nilai !== null ? $p->nilai : '—' }}
                            </span>
                        </td>

                        <td class="center">
                            <div class="action-group">
                                <a href="{{ route('guru.pengumpulan-tugas.show', $p->id) }}" class="btn btn-sm btn-detail">Detail</a>

                                @if(in_array($p->status, ['dikumpulkan', 'terlambat', 'sudah_dinilai']))
                                    <button type="button" class="btn btn-sm btn-nilai"
                                        onclick="openNilaiModal({{ $p->id }}, {{ $p->tugas->nilai_maksimal ?? 100 }}, {{ $p->nilai ?? 'null' }}, `{{ addslashes($p->umpan_balik ?? '') }}`)">
                                        Beri Nilai
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                </div>
                                <p class="empty-title">Belum ada pengumpulan</p>
                                <p class="empty-sub">Siswa belum mengumpulkan tugas apapun</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($pengumpulan->hasPages())
        <div class="pag-wrap">
            <p class="pag-info">Menampilkan {{ $pengumpulan->firstItem() }} – {{ $pengumpulan->lastItem() }} dari {{ $pengumpulan->total() }} pengumpulan</p>
            <div class="pag-btns">
                @if($pengumpulan->onFirstPage())
                    <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></span>
                @else
                    <a href="{{ $pengumpulan->previousPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg></a>
                @endif

                @foreach($pengumpulan->getUrlRange(1, $pengumpulan->lastPage()) as $page => $url)
                    @if($page == $pengumpulan->currentPage())
                        <span class="pag-btn active">{{ $page }}</span>
                    @elseif($page == 1 || $page == $pengumpulan->lastPage() || abs($page - $pengumpulan->currentPage()) <= 1)
                        <a href="{{ $url }}" class="pag-btn">{{ $page }}</a>
                    @elseif(abs($page - $pengumpulan->currentPage()) == 2)
                        <span class="pag-ellipsis">…</span>
                    @endif
                @endforeach

                @if($pengumpulan->hasMorePages())
                    <a href="{{ $pengumpulan->nextPageUrl() }}" class="pag-btn"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></a>
                @else
                    <span class="pag-btn disabled"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 18 15 12 9 6"/></svg></span>
                @endif
            </div>
        </div>
        @endif
    </div>
</div>

{{-- Modal Beri Nilai --}}
<div class="modal-overlay" id="nilaiModal">
    <div class="modal">
        <div class="modal-header">
            <span class="modal-title">Beri Nilai Pengumpulan</span>
            <button type="button" class="modal-close" onclick="closeNilaiModal()">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
        <form id="nilaiForm" method="POST">
            @csrf @method('PATCH')
            <div class="modal-body">
                <div class="field">
                    <label id="nilaiLabel">Nilai <span style="color:#dc2626">*</span></label>
                    <input type="number" name="nilai" id="nilaiInput" min="0" step="0.5" placeholder="Masukkan nilai…" required>
                    <span id="nilaiHint" style="font-size:11.5px;color:var(--text3);margin-top:2px"></span>
                </div>
                <div class="field">
                    <label>Umpan Balik <span style="color:var(--text3);font-weight:400">(opsional)</span></label>
                    <textarea name="umpan_balik" id="umpanBalikInput" placeholder="Tulis komentar atau catatan untuk siswa…"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeNilaiModal()">Batal</button>
                <button type="submit" class="btn btn-primary">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
                    Simpan Nilai
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2800, showConfirmButton:false, toast:true, position:'top-end' });
@endif
@if(session('error'))
Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
@endif

function openNilaiModal(id, nilaiMaks, nilaiSaat, umpanBalikSaat) {
    const form = document.getElementById('nilaiForm');
    form.action = `/guru/pengumpulan-tugas/${id}/beri-nilai`;
    document.getElementById('nilaiInput').max    = nilaiMaks;
    document.getElementById('nilaiInput').value  = nilaiSaat !== null ? nilaiSaat : '';
    document.getElementById('umpanBalikInput').value = umpanBalikSaat || '';
    document.getElementById('nilaiHint').textContent = `Nilai maksimal: ${nilaiMaks}`;
    document.getElementById('nilaiModal').classList.add('active');
}

function closeNilaiModal() {
    document.getElementById('nilaiModal').classList.remove('active');
}

document.getElementById('nilaiModal').addEventListener('click', function(e) {
    if (e.target === this) closeNilaiModal();
});
</script>
</x-app-layout>