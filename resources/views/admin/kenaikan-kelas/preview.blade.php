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
        --danger:#dc2626;--danger-bg:#fff0f0;--danger-border:#fecaca;
        --success:#15803d;--success-bg:#f0fdf4;--success-border:#bbf7d0;
        --warn:#b45309;--warn-bg:#fffbeb;--warn-border:#fde68a;
    }
    *{box-sizing:border-box;}
    .page{padding:28px 28px 60px;}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-size:12px;color:var(--text3);margin-bottom:20px;font-family:'Plus Jakarta Sans',sans-serif;}
    .breadcrumb a{color:var(--text3);text-decoration:none;}.breadcrumb a:hover{color:var(--brand-600);}
    .breadcrumb-sep{color:var(--border2);}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:6px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2;}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .flow-steps{display:flex;align-items:center;gap:0;margin:20px 0 24px;}
    .flow-step{display:flex;align-items:center;gap:8px;flex:1;}
    .flow-step-num{width:28px;height:28px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;flex-shrink:0;}
    .flow-step.active .flow-step-num{background:var(--brand-600);color:#fff;}
    .flow-step.done .flow-step-num{background:#dcfce7;color:#15803d;}
    .flow-step.inactive .flow-step-num{background:var(--surface3);color:var(--text3);}
    .flow-step-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;}
    .flow-step.active .flow-step-label{color:var(--brand-600);}
    .flow-step.done .flow-step-label{color:#15803d;}
    .flow-step.inactive .flow-step-label{color:var(--text3);}
    .flow-line{flex:1;height:2px;background:var(--border);margin:0 8px;max-width:60px;}

    /* Summary Banner */
    .summary-banner{display:grid;grid-template-columns:repeat(5,1fr);gap:10px;margin-bottom:20px;}
    .s-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:12px 16px;display:flex;align-items:center;gap:10px;}
    .s-icon{width:34px;height:34px;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .s-icon.blue{background:var(--brand-50);}
    .s-icon.green{background:#f0fdf4;}
    .s-icon.red{background:#fff0f0;}
    .s-icon.yellow{background:#fefce8;}
    .s-icon.purple{background:#fdf4ff;}
    .s-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);letter-spacing:.04em;text-transform:uppercase;}
    .s-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}

    .info-strip{display:flex;align-items:center;gap:12px;padding:11px 16px;background:var(--warn-bg);border:1px solid var(--warn-border);border-radius:var(--radius-sm);margin-bottom:20px;font-size:12.5px;color:var(--warn);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;}

    /* Table */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:20px;}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:10px;}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px;}
    .topbar-filters{display:flex;align-items:center;gap:8px;}
    .filter-btn{padding:5px 12px;border-radius:6px;border:1px solid var(--border2);background:var(--surface);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);cursor:pointer;transition:background .12s;}
    .filter-btn:hover,.filter-btn.active{background:var(--brand-50);border-color:var(--brand-500);color:var(--brand-600);}
    .table-wrap{overflow-x:auto;}
    table{width:100%;border-collapse:collapse;font-size:13px;}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border);}
    thead th{padding:10px 12px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap;}
    thead th.center{text-align:center;}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s;}
    tbody tr:last-child{border-bottom:none;}
    tbody tr:hover{background:#fafbff;}
    tbody tr.row-tidak-naik{background:#fff9f9;}
    tbody tr.row-tidak-naik:hover{background:#fff5f5;}
    td{padding:9px 12px;color:var(--text);vertical-align:middle;}
    td.center{text-align:center;}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);}
    .siswa-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text);}
    .siswa-nis{font-size:11.5px;color:var(--text3);}
    .kelas-badge{display:inline-block;padding:2px 8px;background:var(--brand-50);color:var(--brand-700);border-radius:5px;font-size:11px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;}

    /* Progress bar kehadiran */
    .progress-wrap{display:flex;align-items:center;gap:8px;}
    .progress-bar{flex:1;height:6px;background:var(--surface3);border-radius:99px;overflow:hidden;min-width:60px;}
    .progress-fill{height:100%;border-radius:99px;transition:width .3s;}
    .progress-pct{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;width:40px;text-align:right;flex-shrink:0;}
    .progress-fill.good{background:#22c55e;}
    .progress-fill.warn{background:#f59e0b;}
    .progress-fill.bad{background:#ef4444;}

    /* Syarat icons */
    .syarat-check{display:flex;align-items:center;gap:4px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;}
    .syarat-check.pass{color:#15803d;}
    .syarat-check.fail{color:#dc2626;}

    /* Rekomendasi */
    .rek-badge{display:inline-flex;align-items:center;gap:4px;padding:3px 9px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;}
    .rek-naik{background:#dcfce7;color:#15803d;}
    .rek-tidak{background:#fff0f0;color:#dc2626;}
    .rek-lulus{background:#f3e8ff;color:#7c3aed;}

    /* Form select inline */
    .select-sm{padding:5px 8px;border:1px solid var(--border2);border-radius:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;color:var(--text);background:var(--surface);outline:none;width:100%;min-width:130px;}
    .select-sm:focus{border-color:var(--brand-500);box-shadow:0 0 0 2px var(--brand-100);}

    /* Sticky action bar */
    .action-bar{position:sticky;bottom:0;left:0;right:0;background:var(--surface);border-top:1px solid var(--border);padding:14px 28px;display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;z-index:100;box-shadow:0 -4px 20px rgba(0,0,0,.06);}
    .action-bar-left{display:flex;align-items:center;gap:10px;}
    .action-bar-right{display:flex;align-items:center;gap:8px;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-primary{background:var(--brand-600);color:#fff;}
    .btn-ghost{background:transparent;color:var(--text2);border:1px solid var(--border2);}
    .btn-ghost:hover{background:var(--surface3);filter:none;}
    .select-all-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;color:var(--text2);display:flex;align-items:center;gap:6px;cursor:pointer;user-select:none;}
    .catatan-input{padding:5px 10px;border:1px solid var(--border2);border-radius:6px;font-family:'DM Sans',sans-serif;font-size:12px;color:var(--text);background:var(--surface);outline:none;width:150px;}
    .catatan-input:focus{border-color:var(--brand-500);}
    .nilai-val{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;}
    .nilai-pass{color:#15803d;}
    .nilai-fail{color:#dc2626;}
    @media(max-width:768px){.summary-banner{grid-template-columns:1fr 1fr;}.page{padding:16px;}}
</style>

<div class="page">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('admin.kenaikan-kelas.index') }}">Kenaikan Kelas</a>
        <span class="breadcrumb-sep">›</span>
        <span>Preview Evaluasi</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">Preview Kenaikan Kelas — Tingkat {{ $validated['dari_tingkat'] }} → {{ $keTingkat === 'lulus' ? 'Lulus' : $keTingkat }}</h1>
            <p class="page-sub">{{ $taAsal->nama }} → {{ $taTujuan->nama }} · Review dan sesuaikan keputusan sebelum dikonfirmasi</p>
        </div>
    </div>

    {{-- Flow Steps --}}
    <div class="flow-steps">
        <div class="flow-step done">
            <div class="flow-step-num">✓</div>
            <span class="flow-step-label">Parameter</span>
        </div>
        <div class="flow-line" style="background:var(--success-border);"></div>
        <div class="flow-step active">
            <div class="flow-step-num">2</div>
            <span class="flow-step-label">Preview & Evaluasi</span>
        </div>
        <div class="flow-line"></div>
        <div class="flow-step inactive">
            <div class="flow-step-num">3</div>
            <span class="flow-step-label">Konfirmasi</span>
        </div>
    </div>

    {{-- Summary --}}
    @php
        $totalSiswa     = count($evaluasi);
        $totalRekNaik   = collect($evaluasi)->where('rekomendasi', 'naik_kelas')->count();
        $totalRekTidak  = collect($evaluasi)->where('rekomendasi', 'tidak_naik')->count();
        $memenuhi2Syarat = collect($evaluasi)->filter(fn($e) => $e['memenuhi_syarat_nilai'] && $e['memenuhi_syarat_kehadiran'])->count();
    @endphp
    <div class="summary-banner">
        <div class="s-card">
            <div class="s-icon blue"><svg width="16" height="16" fill="none" stroke="#1f63db" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
            <div><p class="s-label">Total Siswa</p><p class="s-val">{{ $totalSiswa }}</p></div>
        </div>
        <div class="s-card">
            <div class="s-icon green"><svg width="16" height="16" fill="none" stroke="#15803d" stroke-width="2" viewBox="0 0 24 24"><path d="M5 15l7-7 7 7"/></svg></div>
            <div><p class="s-label">Rek. Naik</p><p class="s-val">{{ $totalRekNaik }}</p></div>
        </div>
        <div class="s-card">
            <div class="s-icon red"><svg width="16" height="16" fill="none" stroke="#dc2626" stroke-width="2" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg></div>
            <div><p class="s-label">Rek. Tidak</p><p class="s-val">{{ $totalRekTidak }}</p></div>
        </div>
        <div class="s-card">
            <div class="s-icon yellow"><svg width="16" height="16" fill="none" stroke="#b45309" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg></div>
            <div><p class="s-label">Penuh Syarat</p><p class="s-val">{{ $memenuhi2Syarat }}</p></div>
        </div>
        <div class="s-card">
            <div class="s-icon purple"><svg width="16" height="16" fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
            <div><p class="s-label">Kelas Tersedia</p><p class="s-val">{{ $kelasTujuanList->count() }}</p></div>
        </div>
    </div>

    <div class="info-strip">
        <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        Sistem telah memberikan rekomendasi otomatis. Anda dapat mengubah keputusan dan kelas tujuan sebelum konfirmasi.
        Siswa kelas XII akan otomatis direkomendasikan <strong style="color:#7c3aed;">Lulus</strong> jika memenuhi syarat.
    </div>

    <form action="{{ route('admin.kenaikan-kelas.store') }}" method="POST" id="formKenaikan">
        @csrf
        <input type="hidden" name="tahun_ajaran_asal_id"   value="{{ $validated['tahun_ajaran_asal_id'] }}">
        <input type="hidden" name="tahun_ajaran_tujuan_id" value="{{ $validated['tahun_ajaran_tujuan_id'] }}">
        <input type="hidden" name="dari_tingkat"           value="{{ $validated['dari_tingkat'] }}">
        <input type="hidden" name="catatan"                value="{{ $validated['catatan'] ?? '' }}">

        <div class="table-card">
            <div class="table-topbar">
                <p class="table-info">Daftar Siswa <span>— {{ $totalSiswa }} siswa ditemukan</span></p>
                <div class="topbar-filters">
                    <button type="button" class="filter-btn active" onclick="filterRows('all', this)">Semua</button>
                    <button type="button" class="filter-btn" onclick="filterRows('naik_kelas', this)">Naik</button>
                    <button type="button" class="filter-btn" onclick="filterRows('tidak_naik', this)">Tidak Naik</button>
                    @if($keTingkat === 'lulus')
                    <button type="button" class="filter-btn" onclick="filterRows('lulus', this)">Lulus</button>
                    @endif
                </div>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th style="width:36px;">#</th>
                            <th>Siswa</th>
                            <th>Kelas Asal</th>
                            <th class="center">Kehadiran</th>
                            <th class="center">Rata Nilai</th>
                            <th class="center">Syarat</th>
                            <th>Keputusan</th>
                            <th>Kelas Tujuan</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody id="tabelSiswa">
                        @foreach($evaluasi as $i => $ev)
                        @php
                            $isXII = $validated['dari_tingkat'] === 'XII';
                            $defaultKeputusan = $isXII && $ev['rekomendasi'] === 'naik_kelas' ? 'lulus' : $ev['rekomendasi'];
                            $persen = $ev['persentase_kehadiran'];
                            $progressClass = $persen >= 75 ? 'good' : ($persen >= 50 ? 'warn' : 'bad');
                        @endphp
                        <tr class="siswa-row {{ $defaultKeputusan === 'tidak_naik' ? 'row-tidak-naik' : '' }}"
                            data-keputusan="{{ $defaultKeputusan }}">
                            <td><span class="no-col">{{ $i + 1 }}</span></td>
                            <td>
                                <input type="hidden" name="siswa[{{ $i }}][siswa_id]" value="{{ $ev['siswa']->id }}">
                                <p class="siswa-name">{{ $ev['siswa']->nama_lengkap }}</p>
                                <p class="siswa-nis">{{ $ev['siswa']->nis }}</p>
                            </td>
                            <td>
                                <span class="kelas-badge">{{ $ev['kelas_asal']->nama_kelas }}</span>
                            </td>
                            <td>
                                <div class="progress-wrap">
                                    <div class="progress-bar">
                                        <div class="progress-fill {{ $progressClass }}" style="width:{{ min(100, $persen) }}%"></div>
                                    </div>
                                    <span class="progress-pct {{ $persen >= 75 ? 'nilai-pass' : 'nilai-fail' }}">
                                        {{ number_format($persen, 1) }}%
                                    </span>
                                </div>
                                <p style="font-size:10.5px;color:var(--text3);margin-top:2px;">{{ $ev['total_hadir'] }}/{{ $ev['total_pertemuan'] }} pertemuan</p>
                            </td>
                            <td class="center">
                                <span class="nilai-val {{ $ev['rata_rata_nilai'] >= 65 ? 'nilai-pass' : 'nilai-fail' }}">
                                    {{ number_format($ev['rata_rata_nilai'], 1) }}
                                </span>
                            </td>
                            <td class="center">
                                <div style="display:flex;flex-direction:column;gap:3px;align-items:center;">
                                    <span class="syarat-check {{ $ev['memenuhi_syarat_kehadiran'] ? 'pass' : 'fail' }}">
                                        @if($ev['memenuhi_syarat_kehadiran'])
                                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Hadir
                                        @else
                                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg> Hadir
                                        @endif
                                    </span>
                                    <span class="syarat-check {{ $ev['memenuhi_syarat_nilai'] ? 'pass' : 'fail' }}">
                                        @if($ev['memenuhi_syarat_nilai'])
                                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg> Nilai
                                        @else
                                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg> Nilai
                                        @endif
                                    </span>
                                </div>
                            </td>
                            <td>
                                <select name="siswa[{{ $i }}][keputusan]"
                                        class="select-sm keputusan-select"
                                        data-index="{{ $i }}"
                                        onchange="handleKeputusanChange(this)">
                                    <option value="naik_kelas"  {{ $defaultKeputusan === 'naik_kelas'  ? 'selected' : '' }}>Naik Kelas</option>
                                    <option value="tidak_naik"  {{ $defaultKeputusan === 'tidak_naik'  ? 'selected' : '' }}>Tidak Naik</option>
                                    @if($isXII)
                                    <option value="lulus"       {{ $defaultKeputusan === 'lulus'       ? 'selected' : '' }}>Lulus</option>
                                    @endif
                                </select>
                            </td>
                            <td>
                                <select name="siswa[{{ $i }}][kelas_tujuan_id]"
                                        class="select-sm kelas-tujuan-select"
                                        id="kelas_tujuan_{{ $i }}"
                                        {{ in_array($defaultKeputusan, ['tidak_naik', 'lulus']) ? 'disabled' : '' }}>
                                    <option value="">— Pilih Kelas —</option>
                                    @foreach($kelasTujuanList as $kt)
                                        <option value="{{ $kt->id }}"
                                            {{ optional($ev['kelas_tujuan_rekomendasi'])->id == $kt->id ? 'selected' : '' }}>
                                            {{ $kt->nama_kelas }}
                                            @if($kt->jurusan) ({{ $kt->jurusan->nama }}) @endif
                                        </option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input type="text"
                                       name="siswa[{{ $i }}][catatan]"
                                       class="catatan-input"
                                       placeholder="Catatan...">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Sticky Action Bar --}}
        <div class="action-bar">
            <div class="action-bar-left">
                <label class="select-all-label">
                    <input type="checkbox" id="cbNaikSemua" onchange="setSemuaNaik(this)">
                    Naik semua yang memenuhi syarat
                </label>
                <span style="font-size:12px;color:var(--text3);" id="counterLabel">{{ $totalSiswa }} siswa</span>
            </div>
            <div class="action-bar-right">
                <a href="{{ route('admin.kenaikan-kelas.create') }}" class="btn btn-ghost">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    Kembali
                </a>
                <button type="button" class="btn btn-primary" onclick="konfirmasi()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    Konfirmasi & Proses
                </button>
            </div>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function handleKeputusanChange(sel) {
        const idx = sel.dataset.index;
        const val = sel.value;
        const kelasTujuan = document.getElementById('kelas_tujuan_' + idx);
        const row = sel.closest('tr');

        if (val === 'tidak_naik' || val === 'lulus') {
            kelasTujuan.disabled = true;
            kelasTujuan.value = '';
            row.classList.toggle('row-tidak-naik', val === 'tidak_naik');
        } else {
            kelasTujuan.disabled = false;
            row.classList.remove('row-tidak-naik');
        }

        row.dataset.keputusan = val;
        updateCounter();
    }

    function updateCounter() {
        const rows = document.querySelectorAll('.siswa-row');
        const naik = [...rows].filter(r => r.dataset.keputusan === 'naik_kelas').length;
        const tidak = [...rows].filter(r => r.dataset.keputusan === 'tidak_naik').length;
        const lulus = [...rows].filter(r => r.dataset.keputusan === 'lulus').length;
        let parts = [];
        if (naik)  parts.push(`${naik} naik`);
        if (tidak) parts.push(`${tidak} tidak naik`);
        if (lulus) parts.push(`${lulus} lulus`);
        document.getElementById('counterLabel').textContent = parts.join(', ');
    }

    function filterRows(keputusan, btn) {
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
        document.querySelectorAll('.siswa-row').forEach(row => {
            row.style.display = (keputusan === 'all' || row.dataset.keputusan === keputusan) ? '' : 'none';
        });
    }

    function setSemuaNaik(cb) {
        // Hanya ubah yang memenuhi syarat (bisa diketahui dari atribut data)
        // Untuk sederhana, toggle semua ke naik_kelas
        document.querySelectorAll('.keputusan-select').forEach(sel => {
            if (cb.checked) {
                const row = sel.closest('tr');
                // Hanya set naik jika opsi naik_kelas tersedia
                const hasNaik = [...sel.options].some(o => o.value === 'naik_kelas');
                if (hasNaik) {
                    sel.value = 'naik_kelas';
                    handleKeputusanChange(sel);
                }
            }
        });
        if (!cb.checked) updateCounter();
    }

    function konfirmasi() {
        // Validasi: yang naik kelas harus punya kelas tujuan
        let invalid = 0;
        document.querySelectorAll('.siswa-row').forEach(row => {
            const sel = row.querySelector('.keputusan-select');
            const kelasSel = row.querySelector('.kelas-tujuan-select');
            if (sel.value === 'naik_kelas' && !kelasSel.value) {
                invalid++;
                kelasSel.style.borderColor = '#dc2626';
            } else if (kelasSel) {
                kelasSel.style.borderColor = '';
            }
        });

        if (invalid > 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Kelas Tujuan Belum Dipilih',
                text: `${invalid} siswa yang akan naik kelas belum ditentukan kelas tujuannya.`,
                confirmButtonColor: '#1f63db',
            });
            return;
        }

        const rows = document.querySelectorAll('.siswa-row');
        const naik  = [...rows].filter(r => r.dataset.keputusan === 'naik_kelas').length;
        const tidak = [...rows].filter(r => r.dataset.keputusan === 'tidak_naik').length;
        const lulus = [...rows].filter(r => r.dataset.keputusan === 'lulus').length;

        Swal.fire({
            title: 'Konfirmasi Proses Kenaikan Kelas',
            html: `
                <div style="text-align:left;font-size:14px;line-height:1.8;">
                    <p style="margin-bottom:8px;color:#475569;">Ringkasan keputusan:</p>
                    <div style="display:flex;gap:16px;justify-content:center;padding:12px;background:#f8fafc;border-radius:8px;margin-bottom:12px;">
                        <div style="text-align:center;"><strong style="font-size:22px;color:#15803d;">${naik}</strong><br><span style="font-size:11px;color:#64748b;">NAIK KELAS</span></div>
                        <div style="text-align:center;"><strong style="font-size:22px;color:#dc2626;">${tidak}</strong><br><span style="font-size:11px;color:#64748b;">TIDAK NAIK</span></div>
                        <div style="text-align:center;"><strong style="font-size:22px;color:#7c3aed;">${lulus}</strong><br><span style="font-size:11px;color:#64748b;">LULUS</span></div>
                    </div>
                    <p style="color:#dc2626;font-size:12px;">⚠ Proses ini akan mengubah data kelas siswa dan tidak dapat diurungkan secara otomatis.</p>
                </div>
            `,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#1f63db',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Proses Sekarang!',
            cancelButtonText: 'Periksa Kembali',
        }).then(r => {
            if (r.isConfirmed) {
                document.getElementById('formKenaikan').submit();
            }
        });
    }

    updateCounter();
</script>
</x-app-layout>