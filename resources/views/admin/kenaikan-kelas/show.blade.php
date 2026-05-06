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
    }
    *{box-sizing:border-box;}
    .page{padding:28px 28px 40px;}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-size:12px;color:var(--text3);margin-bottom:20px;font-family:'Plus Jakarta Sans',sans-serif;}
    .breadcrumb a{color:var(--text3);text-decoration:none;}.breadcrumb a:hover{color:var(--brand-600);}
    .breadcrumb-sep{color:var(--border2);}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2;}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;align-items:center;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-ghost{background:transparent;color:var(--text2);border:1px solid var(--border2);}
    .btn-ghost:hover{background:var(--surface3);filter:none;}
    .btn-danger-outline{background:var(--danger-bg);color:var(--danger);border:1px solid var(--danger-border);}
    .btn-danger-outline:hover{background:#fee2e2;filter:none;}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;white-space:nowrap;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-selesai{background:#dcfce7;color:#15803d;}.badge-selesai .badge-dot{background:#15803d;}
    .badge-diproses{background:#fefce8;color:#a16207;}.badge-diproses .badge-dot{background:#ca8a04;}
    .badge-draft{background:#f1f5f9;color:#64748b;}.badge-draft .badge-dot{background:#94a3b8;}
    .badge-dibatalkan{background:#fff0f0;color:#dc2626;}.badge-dibatalkan .badge-dot{background:#dc2626;}

    /* Layout */
    .layout{display:grid;grid-template-columns:1fr 300px;gap:16px;align-items:start;}
    .main-col{}
    .side-col{}

    /* Info card */
    .info-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px;}
    .card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;justify-content:space-between;}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:7px;}
    .card-body{padding:20px;}
    .meta-grid{display:grid;grid-template-columns:1fr 1fr;gap:12px 20px;}
    .meta-item{}
    .meta-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;}
    .meta-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text);margin-top:2px;}
    .meta-val.muted{font-weight:400;color:var(--text2);}

    /* Stats row */
    .stats-row{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;margin-bottom:16px;}
    .stat-sm{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px;text-align:center;}
    .stat-sm-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:24px;font-weight:800;color:var(--text);}
    .stat-sm-lbl{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;margin-top:2px;}

    /* Table */
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:12px 18px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:8px;}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .search-input{padding:6px 12px;border:1px solid var(--border2);border-radius:6px;font-family:'DM Sans',sans-serif;font-size:12.5px;color:var(--text);background:var(--surface);outline:none;width:200px;}
    .search-input:focus{border-color:var(--brand-500);}
    .table-wrap{overflow-x:auto;}
    table{width:100%;border-collapse:collapse;font-size:13px;}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border);}
    thead th{padding:10px 12px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap;}
    thead th.center{text-align:center;}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s;}
    tbody tr:last-child{border-bottom:none;}
    tbody tr:hover{background:#fafbff;}
    td{padding:9px 12px;color:var(--text);vertical-align:middle;}
    td.center{text-align:center;}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3);}
    .siswa-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;}
    .siswa-nis{font-size:11.5px;color:var(--text3);}

    /* Keputusan badge */
    .k-naik{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;background:#dcfce7;color:#15803d;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;}
    .k-tidak{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;background:#fff0f0;color:#dc2626;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;}
    .k-lulus{display:inline-flex;align-items:center;gap:4px;padding:2px 8px;background:#f3e8ff;color:#7c3aed;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;}

    /* Progress bar */
    .prog-wrap{display:flex;align-items:center;gap:6px;}
    .prog-bar{flex:1;height:5px;background:var(--surface3);border-radius:99px;overflow:hidden;min-width:50px;}
    .prog-fill{height:100%;border-radius:99px;}
    .prog-fill.g{background:#22c55e;}.prog-fill.w{background:#f59e0b;}.prog-fill.r{background:#ef4444;}
    .prog-pct{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;width:38px;text-align:right;flex-shrink:0;}

    .syarat-pass{color:#15803d;font-weight:700;font-size:12px;font-family:'Plus Jakarta Sans',sans-serif;}
    .syarat-fail{color:#dc2626;font-weight:700;font-size:12px;font-family:'Plus Jakarta Sans',sans-serif;}

    /* Catatan highlight */
    .catatan-text{font-size:12px;color:var(--text2);font-style:italic;}

    @media(max-width:900px){.layout{grid-template-columns:1fr;}.stats-row{grid-template-columns:1fr 1fr;}}
    @media(max-width:640px){.page{padding:16px;}.meta-grid{grid-template-columns:1fr;}}
</style>

<div class="page">
    <div class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <span class="breadcrumb-sep">›</span>
        <a href="{{ route('admin.kenaikan-kelas.index') }}">Kenaikan Kelas</a>
        <span class="breadcrumb-sep">›</span>
        <span>Detail Proses #{{ $kenaikanKelas->id }}</span>
    </div>

    <div class="page-header">
        <div>
            <h1 class="page-title">
                Detail Kenaikan Kelas
                @php
                    $badgeCls = match($kenaikanKelas->status) {
                        'selesai'    => 'badge-selesai',
                        'diproses'   => 'badge-diproses',
                        'dibatalkan' => 'badge-dibatalkan',
                        default      => 'badge-draft',
                    };
                    $badgeLbl = match($kenaikanKelas->status) {
                        'selesai'    => 'Selesai',
                        'diproses'   => 'Diproses',
                        'dibatalkan' => 'Dibatalkan',
                        default      => 'Draft',
                    };
                @endphp
                <span class="badge {{ $badgeCls }}" style="margin-left:8px;vertical-align:middle;">
                    <span class="badge-dot"></span>{{ $badgeLbl }}
                </span>
            </h1>
            <p class="page-sub">
                Tingkat {{ $kenaikanKelas->dari_tingkat }} → {{ $kenaikanKelas->ke_tingkat === 'lulus' ? 'Lulus' : $kenaikanKelas->ke_tingkat }}
                · {{ optional($kenaikanKelas->tahunAjaranAsal)->nama }} → {{ optional($kenaikanKelas->tahunAjaranTujuan)->nama }}
            </p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.kenaikan-kelas.index') }}" class="btn btn-ghost">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            @if(! $kenaikanKelas->isSelesai() && ! $kenaikanKelas->isDibatalkan())
            <form method="POST" action="{{ route('admin.kenaikan-kelas.batalkan', $kenaikanKelas) }}" id="formBatal">
                @csrf
                <button type="button" class="btn btn-danger-outline"
                        onclick="confirmBatal()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
                    Batalkan Proses
                </button>
            </form>
            @endif
        </div>
    </div>

    @if(session('success'))
    <div style="display:flex;align-items:center;gap:10px;padding:12px 16px;background:var(--success-bg);border:1px solid var(--success-border);color:var(--success);border-radius:var(--radius);margin-bottom:16px;font-size:13px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="display:flex;align-items:center;gap:10px;padding:12px 16px;background:var(--danger-bg);border:1px solid var(--danger-border);color:var(--danger);border-radius:var(--radius);margin-bottom:16px;font-size:13px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Summary Stats --}}
    <div class="stats-row">
        <div class="stat-sm">
            <p class="stat-sm-val">{{ $kenaikanKelas->total_siswa }}</p>
            <p class="stat-sm-lbl">Total Siswa</p>
        </div>
        <div class="stat-sm">
            <p class="stat-sm-val" style="color:#15803d;">{{ $kenaikanKelas->naik_kelas }}</p>
            <p class="stat-sm-lbl">Naik Kelas</p>
        </div>
        <div class="stat-sm">
            <p class="stat-sm-val" style="color:#dc2626;">{{ $kenaikanKelas->tidak_naik }}</p>
            <p class="stat-sm-lbl">Tidak Naik</p>
        </div>
        <div class="stat-sm">
            <p class="stat-sm-val" style="color:#7c3aed;">{{ $kenaikanKelas->lulus }}</p>
            <p class="stat-sm-lbl">Lulus</p>
        </div>
    </div>

    <div class="layout">
        <div class="main-col">
            {{-- Tabel Detail Siswa --}}
            <div class="table-card">
                <div class="table-topbar">
                    <p class="table-info">Detail Per Siswa</p>
                    <input type="text" class="search-input" placeholder="Cari nama / NIS..." oninput="filterSiswa(this.value)">
                </div>
                <div class="table-wrap">
                    <table>
                        <thead>
                            <tr>
                                <th style="width:36px;">#</th>
                                <th>Siswa</th>
                                <th>Kelas Asal</th>
                                <th>Kelas Tujuan</th>
                                <th class="center">Kehadiran</th>
                                <th class="center">Rata Nilai</th>
                                <th class="center">Syarat</th>
                                <th>Keputusan</th>
                                <th>Catatan</th>
                            </tr>
                        </thead>
                        <tbody id="tabelDetail">
                            @foreach($kenaikanKelas->detail as $i => $det)
                            @php
                                $persen = $det->persentase_kehadiran ?? 0;
                                $progCls = $persen >= 75 ? 'g' : ($persen >= 50 ? 'w' : 'r');
                            @endphp
                            <tr class="detail-row" data-search="{{ strtolower($det->siswa->nama_lengkap . ' ' . $det->siswa->nis) }}">
                                <td><span class="no-col">{{ $i + 1 }}</span></td>
                                <td>
                                    <p class="siswa-name">{{ $det->siswa->nama_lengkap }}</p>
                                    <p class="siswa-nis">{{ $det->siswa->nis }}</p>
                                </td>
                                <td style="font-size:12.5px;">{{ optional($det->kelasAsal)->nama_kelas ?? '—' }}</td>
                                <td style="font-size:12.5px;">{{ optional($det->kelasTujuan)->nama_kelas ?? '—' }}</td>
                                <td>
                                    <div class="prog-wrap">
                                        <div class="prog-bar">
                                            <div class="prog-fill {{ $progCls }}" style="width:{{ min(100, $persen) }}%"></div>
                                        </div>
                                        <span class="prog-pct" style="color:{{ $persen >= 75 ? '#15803d' : '#dc2626' }}">
                                            {{ number_format($persen, 1) }}%
                                        </span>
                                    </div>
                                    <p style="font-size:10.5px;color:var(--text3);margin-top:1px;">{{ $det->total_hadir }}/{{ $det->total_pertemuan }}</p>
                                </td>
                                <td class="center" style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:{{ $det->rata_rata_nilai >= 65 ? '#15803d' : '#dc2626' }}">
                                    {{ number_format($det->rata_rata_nilai, 1) }}
                                </td>
                                <td class="center">
                                    <div style="display:flex;flex-direction:column;gap:2px;align-items:center;">
                                        <span class="{{ $det->memenuhi_syarat_kehadiran ? 'syarat-pass' : 'syarat-fail' }}">
                                            {{ $det->memenuhi_syarat_kehadiran ? '✓' : '✗' }} Hadir
                                        </span>
                                        <span class="{{ $det->memenuhi_syarat_nilai ? 'syarat-pass' : 'syarat-fail' }}">
                                            {{ $det->memenuhi_syarat_nilai ? '✓' : '✗' }} Nilai
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    @if($det->keputusan === 'naik_kelas')
                                        <span class="k-naik">
                                            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M5 15l7-7 7 7"/></svg>
                                            Naik Kelas
                                        </span>
                                    @elseif($det->keputusan === 'tidak_naik')
                                        <span class="k-tidak">
                                            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M19 9l-7 7-7-7"/></svg>
                                            Tidak Naik
                                        </span>
                                    @elseif($det->keputusan === 'lulus')
                                        <span class="k-lulus">
                                            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                            Lulus
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    @if($det->catatan)
                                        <span class="catatan-text">{{ $det->catatan }}</span>
                                    @else
                                        <span style="color:var(--text3);font-size:12px;">—</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="side-col">
            {{-- Info Proses --}}
            <div class="info-card">
                <div class="card-header">
                    <p class="card-title">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                        Informasi Proses
                    </p>
                </div>
                <div class="card-body">
                    <div style="display:flex;flex-direction:column;gap:12px;">
                        <div class="meta-item">
                            <p class="meta-label">ID Proses</p>
                            <p class="meta-val">#{{ $kenaikanKelas->id }}</p>
                        </div>
                        <div class="meta-item">
                            <p class="meta-label">Tingkat</p>
                            <p class="meta-val">{{ $kenaikanKelas->dari_tingkat }} → {{ $kenaikanKelas->ke_tingkat === 'lulus' ? 'Lulus' : $kenaikanKelas->ke_tingkat }}</p>
                        </div>
                        <div class="meta-item">
                            <p class="meta-label">TA Asal</p>
                            <p class="meta-val muted">{{ optional($kenaikanKelas->tahunAjaranAsal)->nama ?? '—' }}</p>
                        </div>
                        <div class="meta-item">
                            <p class="meta-label">TA Tujuan</p>
                            <p class="meta-val muted">{{ optional($kenaikanKelas->tahunAjaranTujuan)->nama ?? '—' }}</p>
                        </div>
                        <div class="meta-item">
                            <p class="meta-label">Diproses Oleh</p>
                            <p class="meta-val muted">{{ optional($kenaikanKelas->diprosesOleh)->name ?? '—' }}</p>
                        </div>
                        <div class="meta-item">
                            <p class="meta-label">Tanggal Proses</p>
                            <p class="meta-val muted">{{ $kenaikanKelas->diproses_pada?->format('d M Y, H:i') ?? '—' }}</p>
                        </div>
                        @if($kenaikanKelas->catatan)
                        <div class="meta-item" style="padding-top:8px;border-top:1px solid var(--border);">
                            <p class="meta-label">Catatan</p>
                            <p style="font-size:12.5px;color:var(--text2);margin-top:4px;line-height:1.5;">{{ $kenaikanKelas->catatan }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Syarat Minimum --}}
            <div class="info-card">
                <div class="card-header">
                    <p class="card-title">
                        <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><polyline points="9 11 12 14 22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
                        Syarat Kenaikan
                    </p>
                </div>
                <div class="card-body" style="display:flex;flex-direction:column;gap:10px;">
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:10px;background:var(--surface2);border-radius:var(--radius-sm);">
                        <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);">Min. Kehadiran</span>
                        <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text);">≥ 75%</span>
                    </div>
                    <div style="display:flex;align-items:center;justify-content:space-between;padding:10px;background:var(--surface2);border-radius:var(--radius-sm);">
                        <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2);">Min. Rata Nilai</span>
                        <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text);">≥ 65.0</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function filterSiswa(q) {
        const val = q.toLowerCase();
        document.querySelectorAll('.detail-row').forEach(row => {
            row.style.display = row.dataset.search.includes(val) ? '' : 'none';
        });
    }

    function confirmBatal() {
        Swal.fire({
            title: 'Batalkan Proses?',
            text: 'Proses kenaikan kelas ini akan dibatalkan. Tindakan ini tidak dapat diurungkan.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc2626',
            cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Batal',
        }).then(r => {
            if (r.isConfirmed) document.getElementById('formBatal').submit();
        });
    }

    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif
</script>
</x-app-layout>