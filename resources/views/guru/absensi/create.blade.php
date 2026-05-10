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
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:22px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-sm{padding:5px 11px;font-size:12px;border-radius:6px}

    /* ── Step indicator ── */
    .steps{display:flex;align-items:center;gap:0;margin-bottom:22px}
    .step{display:flex;align-items:center;gap:10px;padding:10px 16px;border-radius:var(--radius-sm);flex:1;transition:background .2s}
    .step-num{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;flex-shrink:0;transition:all .2s}
    .step-info{display:flex;flex-direction:column}
    .step-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;letter-spacing:.05em;text-transform:uppercase}
    .step-desc{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;margin-top:1px}
    .step.done .step-num{background:#15803d;color:#fff}
    .step.done .step-label{color:#15803d} .step.done .step-desc{color:#166534}
    .step.active .step-num{background:var(--brand-600);color:#fff;box-shadow:0 0 0 4px var(--brand-100)}
    .step.active .step-label{color:var(--brand-600)} .step.active .step-desc{color:var(--text)}
    .step.active{background:var(--brand-50)}
    .step.pending .step-num{background:var(--surface3);color:var(--text3)}
    .step.pending .step-label{color:var(--text3)} .step.pending .step-desc{color:var(--text3)}
    .step-sep{width:32px;height:2px;background:var(--border);flex-shrink:0;margin:0 4px}
    .step-sep.done{background:#15803d}

    /* ── Form card ── */
    .form-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .form-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .form-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text)}
    .form-card-body{padding:20px}

    .field{display:flex;flex-direction:column;gap:5px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}
    .field select,.field input{height:40px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s,background .15s;width:100%}
    .field select:focus,.field input:focus{border-color:var(--brand-500);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1)}
    .step1-grid{display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:20px}

    /* ── Summary bar ── */
    .summary-bar{background:var(--brand-50);border:1px solid var(--brand-100);border-radius:var(--radius-sm);padding:12px 18px;display:flex;align-items:center;gap:16px;flex-wrap:wrap;margin-bottom:20px}
    .summary-item{display:flex;flex-direction:column}
    .summary-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--brand-700);letter-spacing:.04em;text-transform:uppercase}
    .summary-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text)}
    .summary-sep{width:1px;height:32px;background:var(--brand-100);flex-shrink:0}

    /* ── Bulk action bar ── */
    .bulk-bar{display:flex;align-items:center;justify-content:space-between;padding:12px 20px;background:var(--surface2);border-bottom:1px solid var(--border);flex-wrap:wrap;gap:10px}
    .bulk-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);display:flex;align-items:center;gap:8px}
    .bulk-actions{display:flex;gap:6px;align-items:center;flex-wrap:wrap}
    .bulk-status-btn{display:inline-flex;align-items:center;gap:5px;padding:5px 12px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;cursor:pointer;border:2px solid transparent;transition:all .15s;background:var(--surface);border-color:var(--border);color:var(--text2)}
    .bulk-status-btn.hadir{border-color:#15803d;background:#f0fdf4;color:#15803d}
    .bulk-status-btn.telat{border-color:#a16207;background:#fefce8;color:#a16207}
    .bulk-status-btn.izin {border-color:#1d4ed8;background:#eff6ff;color:#1d4ed8}
    .bulk-status-btn.sakit{border-color:#7c3aed;background:#fdf4ff;color:#7c3aed}
    .bulk-status-btn.alfa {border-color:#dc2626;background:#fff0f0;color:#dc2626}
    .bulk-dot{width:7px;height:7px;border-radius:50%;flex-shrink:0}
    .bulk-dot.hadir{background:#15803d} .bulk-dot.telat{background:#a16207}
    .bulk-dot.izin {background:#1d4ed8} .bulk-dot.sakit{background:#7c3aed}
    .bulk-dot.alfa {background:#dc2626}

    /* ── Siswa table ── */
    .siswa-table-wrap{overflow-x:auto}
    table.siswa-table{width:100%;border-collapse:collapse}
    table.siswa-table thead tr{background:var(--surface2);border-bottom:2px solid var(--border)}
    table.siswa-table thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    table.siswa-table tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    table.siswa-table tbody tr:last-child{border-bottom:none}
    table.siswa-table tbody tr:hover{background:#fafbff}
    table.siswa-table tbody tr.row-hadir{border-left:3px solid #15803d}
    table.siswa-table tbody tr.row-telat{border-left:3px solid #a16207}
    table.siswa-table tbody tr.row-izin {border-left:3px solid #1d4ed8}
    table.siswa-table tbody tr.row-sakit{border-left:3px solid #7c3aed}
    table.siswa-table tbody tr.row-alfa {border-left:3px solid #dc2626}
    table.siswa-table td{padding:10px 14px;color:var(--text);vertical-align:middle}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)}
    .siswa-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .siswa-nis{font-size:12px;color:var(--text3);margin-top:1px}

    /* ── Status radio pills ── */
    .status-pills{display:flex;gap:5px;flex-wrap:wrap}
    .status-pill{position:relative}
    .status-pill input[type=radio]{position:absolute;opacity:0;width:0;height:0}
    .pill-label{display:inline-flex;align-items:center;gap:4px;padding:4px 11px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;cursor:pointer;border:2px solid var(--border);background:var(--surface2);color:var(--text3);transition:all .12s;white-space:nowrap;user-select:none}
    .pill-dot{width:6px;height:6px;border-radius:50%;flex-shrink:0}
    .pill-dot.hadir{background:#15803d} .pill-dot.telat{background:#a16207}
    .pill-dot.izin{background:#1d4ed8}  .pill-dot.sakit{background:#7c3aed}
    .pill-dot.alfa{background:#dc2626}
    .status-pill input:checked + .pill-label.hadir{border-color:#15803d;background:#dcfce7;color:#15803d}
    .status-pill input:checked + .pill-label.telat{border-color:#a16207;background:#fef9c3;color:#a16207}
    .status-pill input:checked + .pill-label.izin {border-color:#1d4ed8;background:#dbeafe;color:#1d4ed8}
    .status-pill input:checked + .pill-label.sakit{border-color:#7c3aed;background:#f3e8ff;color:#7c3aed}
    .status-pill input:checked + .pill-label.alfa {border-color:#dc2626;background:#fee2e2;color:#dc2626}

    /* ── Inputs dalam table ── */
    .table-input{height:34px;padding:0 10px;border:1px solid var(--border);border-radius:6px;font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;min-width:80px}
    .table-input:focus{border-color:var(--brand-500);background:#fff}
    .table-textarea{padding:6px 10px;border:1px solid var(--border);border-radius:6px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text);background:var(--surface2);outline:none;transition:border-color .15s;width:100%;min-width:140px;resize:none;height:34px;line-height:1.4}
    .table-textarea:focus{border-color:var(--brand-500);background:#fff;height:60px}

    /* ── Stats counter ── */
    .count-strip{display:flex;gap:8px;align-items:center;flex-wrap:wrap}
    .count-badge{display:inline-flex;align-items:center;gap:5px;padding:4px 12px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700}
    .count-badge.hadir{background:#dcfce7;color:#15803d}
    .count-badge.telat{background:#fef9c3;color:#a16207}
    .count-badge.izin {background:#dbeafe;color:#1d4ed8}
    .count-badge.sakit{background:#f3e8ff;color:#7c3aed}
    .count-badge.alfa {background:#fee2e2;color:#dc2626}

    /* ── Submit bar ── */
    .submit-bar{position:sticky;bottom:0;background:var(--surface);border-top:1px solid var(--border);padding:14px 20px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;z-index:50;box-shadow:0 -4px 20px rgba(0,0,0,.06)}
    .submit-bar-left{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text2)}
    .submit-bar-left span{color:var(--brand-600);font-size:16px;font-weight:800}

    /* ── Upload ── */
    .file-btn{display:inline-flex;align-items:center;gap:5px;padding:4px 10px;border:1px dashed var(--border2);border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);cursor:pointer;background:var(--surface2);transition:all .12s;white-space:nowrap}
    .file-btn:hover{border-color:var(--brand-500);color:var(--brand-600);background:var(--brand-50)}
    .file-name{font-size:11px;color:var(--brand-600);margin-top:3px;display:none;word-break:break-all;max-width:120px}

    /* ── Empty states ── */
    .step2-empty{padding:60px 20px;text-align:center}
    .step2-empty-icon{width:60px;height:60px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .step2-empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .step2-empty-sub{font-size:13px;color:var(--text3)}

    @media(max-width:768px){
        .step1-grid{grid-template-columns:1fr 1fr}
        .page{padding:16px}
        .steps{display:none}
    }
    @media(max-width:480px){
        .step1-grid{grid-template-columns:1fr}
        .bulk-actions{width:100%}
        .status-pills{gap:3px}
        .pill-label{padding:3px 8px;font-size:11px}
    }
</style>

<div class="page">

    {{-- Header --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Catat Absensi Kelas</h1>
            <p class="page-sub">Absen massal seluruh siswa dalam satu kelas sekaligus</p>
        </div>
        <a href="{{ route('guru.absensi.index') }}" class="btn btn-secondary">
            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
            Kembali
        </a>
    </div>

    {{-- Step indicator --}}
    <div class="steps">
        <div class="step {{ $siswaList->count() ? 'done' : 'active' }}">
            <div class="step-num">
                @if($siswaList->count())
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="3" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                @else 1 @endif
            </div>
            <div class="step-info">
                <span class="step-label">Langkah 1</span>
                <span class="step-desc">Pilih Kelas &amp; Tanggal</span>
            </div>
        </div>
        <div class="step-sep {{ $siswaList->count() ? 'done' : '' }}"></div>
        <div class="step {{ $siswaList->count() ? 'active' : 'pending' }}">
            <div class="step-num">2</div>
            <div class="step-info">
                <span class="step-label">Langkah 2</span>
                <span class="step-desc">Input Status Semua Siswa</span>
            </div>
        </div>
    </div>

    {{-- ═══ STEP 1: Pilih kelas, jadwal & tanggal ═══ --}}
    <div class="form-card">
        <div class="form-card-header">
            <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <span class="form-card-title">Pilih Kelas &amp; Tanggal</span>
        </div>
        <div class="form-card-body">
            <form method="GET" action="{{ route('guru.absensi.create') }}" id="filterForm">
                <div class="step1-grid">
                    <div class="field">
                        <label>Kelas <span style="color:#dc2626">*</span></label>
                        <select name="kelas_id" id="kelasSelect">
                            <option value="">— Pilih Kelas —</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Jadwal Pelajaran <span style="font-weight:400;color:var(--text3)">(opsional)</span></label>
                        <select name="jadwal_pelajaran_id">
                            <option value="">— Pilih Jadwal —</option>
                            @foreach($jadwalList as $j)
                                <option value="{{ $j->id }}" {{ request('jadwal_pelajaran_id') == $j->id ? 'selected' : '' }}>
                                    {{ $j->mataPelajaran->nama_mapel ?? '—' }}
                                    · {{ ucfirst($j->hari) }}
                                    {{ \Carbon\Carbon::parse($j->jam_mulai)->format('H:i') }}–{{ \Carbon\Carbon::parse($j->jam_selesai)->format('H:i') }}
                                    ({{ $j->kelas->nama_kelas ?? '' }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="field">
                        <label>Tanggal <span style="color:#dc2626">*</span></label>
                        <input type="date" name="tanggal"
                               value="{{ request('tanggal', today()->format('Y-m-d')) }}"
                               max="{{ today()->format('Y-m-d') }}">
                    </div>
                </div>

                <div style="display:flex;gap:8px;align-items:center;flex-wrap:wrap">
                    <button type="submit" class="btn btn-primary">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/></svg>
                        {{ request('kelas_id') ? 'Muat Ulang' : 'Muat Daftar Siswa' }}
                    </button>
                    @if(request('kelas_id'))
                    <a href="{{ route('guru.absensi.create') }}" class="btn btn-secondary">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        Ganti Kelas
                    </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    {{-- ═══ STEP 2: Tabel absen massal ═══ --}}
    @if(request('kelas_id'))

        @if($siswaList->count())

        {{-- Summary bar --}}
        <div class="summary-bar">
            <div class="summary-item">
                <span class="summary-label">Kelas</span>
                <span class="summary-val">{{ $kelasList->firstWhere('id', request('kelas_id'))?->nama_kelas ?? '—' }}</span>
            </div>
            <div class="summary-sep"></div>
            <div class="summary-item">
                <span class="summary-label">Tanggal</span>
                <span class="summary-val">{{ \Carbon\Carbon::parse(request('tanggal', today()))->locale('id')->isoFormat('D MMMM Y') }}</span>
            </div>
            <div class="summary-sep"></div>
            <div class="summary-item">
                <span class="summary-label">Total Siswa</span>
                <span class="summary-val">{{ $siswaList->count() }} siswa</span>
            </div>
            @if(request('jadwal_pelajaran_id') && $jadwalList->firstWhere('id', request('jadwal_pelajaran_id')))
            <div class="summary-sep"></div>
            <div class="summary-item">
                <span class="summary-label">Jadwal</span>
                <span class="summary-val">{{ $jadwalList->firstWhere('id', request('jadwal_pelajaran_id'))?->mataPelajaran?->nama_mapel ?? '—' }}</span>
            </div>
            @endif
            <div style="margin-left:auto" class="count-strip" id="countStrip">
                <span class="count-badge hadir" id="cnt-hadir">0 Hadir</span>
                <span class="count-badge telat" id="cnt-telat">0 Telat</span>
                <span class="count-badge izin"  id="cnt-izin">0 Izin</span>
                <span class="count-badge sakit" id="cnt-sakit">0 Sakit</span>
                <span class="count-badge alfa"  id="cnt-alfa">0 Alfa</span>
            </div>
        </div>

        {{-- Form absen massal --}}
        <form action="{{ route('guru.absensi.storeMassal') }}" method="POST" enctype="multipart/form-data" id="absenForm">
            @csrf
            <input type="hidden" name="kelas_id"            value="{{ request('kelas_id') }}">
            <input type="hidden" name="tanggal"             value="{{ request('tanggal', today()->format('Y-m-d')) }}">
            <input type="hidden" name="jadwal_pelajaran_id" value="{{ request('jadwal_pelajaran_id') }}">

            <div class="form-card">
                {{-- Bulk action bar --}}
                <div class="bulk-bar">
                    <div class="bulk-title">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                        Daftar Siswa
                        <span style="background:var(--surface3);color:var(--text3);font-size:11px;padding:2px 8px;border-radius:99px;font-weight:700">{{ $siswaList->count() }}</span>
                    </div>
                    <div class="bulk-actions">
                        <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3)">Tandai semua:</span>
                        @foreach(['hadir','telat','izin','sakit','alfa'] as $s)
                        <button type="button" class="bulk-status-btn {{ $s }}" onclick="setAll('{{ $s }}')">
                            <span class="bulk-dot {{ $s }}"></span>{{ ucfirst($s) }}
                        </button>
                        @endforeach
                    </div>
                </div>

                {{-- Table --}}
                <div class="siswa-table-wrap">
                    <table class="siswa-table">
                        <thead>
                            <tr>
                                <th style="width:44px">#</th>
                                <th>Nama Siswa</th>
                                <th style="min-width:330px">Status Kehadiran</th>
                                <th style="min-width:88px">Jam Masuk</th>
                                <th style="min-width:88px">Jam Keluar</th>
                                <th style="min-width:160px">Keterangan</th>
                                <th style="min-width:110px">Surat Izin</th>
                            </tr>
                        </thead>
                        <tbody id="siswaTableBody">
                            @foreach($siswaList as $index => $s)
                            <tr id="row-{{ $s->id }}" class="row-hadir">
                                <td><span class="no-col">{{ $index + 1 }}</span></td>
                                <td>
                                    <input type="hidden" name="siswa[{{ $index }}][siswa_id]" value="{{ $s->id }}">
                                    <p class="siswa-name">{{ $s->nama_lengkap }}</p>
                                    <p class="siswa-nis">NIS: {{ $s->nis }}</p>
                                </td>
                                <td>
                                    <div class="status-pills">
                                        @foreach(['hadir','telat','izin','sakit','alfa'] as $st)
                                        <label class="status-pill">
                                            <input type="radio"
                                                   name="siswa[{{ $index }}][status]"
                                                   value="{{ $st }}"
                                                   {{ $st === 'hadir' ? 'checked' : '' }}
                                                   onchange="onStatusChange({{ $s->id }}, '{{ $st }}')">
                                            <span class="pill-label {{ $st }}">
                                                <span class="pill-dot {{ $st }}"></span>{{ ucfirst($st) }}
                                            </span>
                                        </label>
                                        @endforeach
                                    </div>
                                </td>
                                <td>
                                    <input type="time" name="siswa[{{ $index }}][jam_masuk]"
                                           class="table-input" placeholder="—">
                                </td>
                                <td>
                                    <input type="time" name="siswa[{{ $index }}][jam_keluar]"
                                           class="table-input" placeholder="—">
                                </td>
                                <td>
                                    <textarea name="siswa[{{ $index }}][keterangan]"
                                              class="table-textarea"
                                              placeholder="Catatan…"
                                              rows="1"
                                              oninput="autoResize(this)"></textarea>
                                </td>
                                <td>
                                    <label class="file-btn" for="surat_{{ $s->id }}">
                                        <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                                        Pilih Surat
                                    </label>
                                    <input type="file"
                                           id="surat_{{ $s->id }}"
                                           name="surat[{{ $s->id }}]"
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           style="display:none"
                                           onchange="showFileNameInline(this, {{ $s->id }})">
                                    <p class="file-name" id="fname-{{ $s->id }}"></p>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                {{-- Sticky submit bar --}}
                <div class="submit-bar">
                    <div>
                        <p class="submit-bar-left">
                            <span id="totalFilled">{{ $siswaList->count() }}</span> siswa siap diabsen
                        </p>
                        <div class="count-strip" style="margin-top:6px">
                            <span class="count-badge hadir" id="bcnt-hadir">0 Hadir</span>
                            <span class="count-badge telat" id="bcnt-telat">0 Telat</span>
                            <span class="count-badge izin"  id="bcnt-izin">0 Izin</span>
                            <span class="count-badge sakit" id="bcnt-sakit">0 Sakit</span>
                            <span class="count-badge alfa"  id="bcnt-alfa">0 Alfa</span>
                        </div>
                    </div>
                    <div style="display:flex;gap:8px">
                        <a href="{{ route('guru.absensi.index') }}" class="btn btn-secondary">Batal</a>
                        <button type="submit" class="btn btn-primary" id="submitBtn">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                            Simpan Absensi {{ $siswaList->count() }} Siswa
                        </button>
                    </div>
                </div>
            </div>
        </form>

        @else
        <div class="form-card">
            <div class="step2-empty">
                <div class="step2-empty-icon">
                    <svg width="26" height="26" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                </div>
                <p class="step2-empty-title">Tidak ada siswa di kelas ini</p>
                <p class="step2-empty-sub">Pastikan kelas sudah memiliki data siswa yang aktif</p>
            </div>
        </div>
        @endif

    @else
    <div class="form-card">
        <div class="step2-empty">
            <div class="step2-empty-icon">
                <svg width="26" height="26" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <p class="step2-empty-title">Pilih kelas terlebih dahulu</p>
            <p class="step2-empty-sub">Daftar siswa akan muncul setelah kelas dan tanggal dipilih</p>
        </div>
    </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// ── Flash messages ──────────────────────────────────────────────────────────
@if(session('success'))
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:3000,showConfirmButton:false,toast:true,position:'top-end'});
@endif
@if(session('error'))
Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
@endif
@if($errors->any())
@php $errorHtml = implode('<br>', $errors->all()); @endphp
Swal.fire({
    icon: 'warning',
    title: 'Perhatian!',
    html: @json($errorHtml),
    confirmButtonColor: '#1f63db'
});
@endif

const STATUS_LIST = ['hadir','telat','izin','sakit','alfa'];

/* ── Tandai semua siswa dengan 1 status ── */
function setAll(status) {
    document.querySelectorAll(`input[type=radio][value="${status}"]`).forEach(r => {
        r.checked = true;
        const siswaId = r.closest('tr')?.id?.replace('row-', '');
        if (siswaId) setRowClass(siswaId, status);
    });
    updateCounts();
}

/* ── Update row class saat status berubah ── */
function onStatusChange(siswaId, status) {
    setRowClass(siswaId, status);
    updateCounts();
}

function setRowClass(siswaId, status) {
    const row = document.getElementById(`row-${siswaId}`);
    if (!row) return;
    STATUS_LIST.forEach(s => row.classList.remove(`row-${s}`));
    row.classList.add(`row-${status}`);
}

/* ── Update counter badge ── */
function updateCounts() {
    const counts = {};
    STATUS_LIST.forEach(s => counts[s] = 0);

    document.querySelectorAll('input[type=radio]:checked').forEach(r => {
        if (STATUS_LIST.includes(r.value)) counts[r.value]++;
    });

    STATUS_LIST.forEach(s => {
        const label = s.charAt(0).toUpperCase() + s.slice(1);
        const text  = `${counts[s]} ${label}`;
        const top   = document.getElementById(`cnt-${s}`);
        const bot   = document.getElementById(`bcnt-${s}`);
        if (top) top.textContent = text;
        if (bot) bot.textContent = text;
    });
}

/* ── Auto-resize textarea ── */
function autoResize(el) {
    el.style.height = '34px';
    el.style.height = Math.min(el.scrollHeight, 80) + 'px';
}

/* ── Tampilkan nama file upload per baris ── */
function showFileNameInline(input, siswaId) {
    const label = document.getElementById(`fname-${siswaId}`);
    if (!label) return;
    if (input.files && input.files[0]) {
        label.textContent = input.files[0].name;
        label.style.display = 'block';
    } else {
        label.textContent = '';
        label.style.display = 'none';
    }
}

/* ── Konfirmasi submit ── */
document.getElementById('absenForm')?.addEventListener('submit', function(e) {
    e.preventDefault();
    const form    = this;
    const total   = {{ $siswaList->count() }};
    const counts  = {};
    STATUS_LIST.forEach(s => counts[s] = 0);
    document.querySelectorAll('input[type=radio]:checked').forEach(r => {
        if (STATUS_LIST.includes(r.value)) counts[r.value]++;
    });

    const detail = STATUS_LIST
        .filter(s => counts[s] > 0)
        .map(s => `<strong>${counts[s]}</strong> ${s.charAt(0).toUpperCase()+s.slice(1)}`)
        .join(' · ');

    Swal.fire({
        title: 'Simpan Absensi?',
        html: `${detail}<br><small style="color:#64748b;margin-top:6px;display:block">Total <strong>${total}</strong> siswa akan disimpan</small>`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#1f63db',
        cancelButtonColor:  '#64748b',
        confirmButtonText: 'Ya, Simpan!',
        cancelButtonText:  'Cek Lagi',
    }).then(r => { if (r.isConfirmed) form.submit(); });
});

/* ── Init counter saat halaman dimuat ── */
document.addEventListener('DOMContentLoaded', updateCounts);
</script>
</x-app-layout>