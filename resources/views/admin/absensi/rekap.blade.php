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
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none}.breadcrumb a:hover{color:var(--brand-600)}
    .breadcrumb .sep{color:var(--border2)}.breadcrumb .current{color:var(--text2)}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-back:hover{background:var(--surface3);filter:none}
    .btn-print{background:var(--brand-600);color:#fff}
    .btn-pdf{background:#fee2e2;color:#dc2626;border:1px solid #fecaca}
    .btn-pdf:hover{background:#fecaca;filter:none}
    .btn-excel{background:#dcfce7;color:#15803d;border:1px solid #bbf7d0}
    .btn-excel:hover{background:#bbf7d0;filter:none}
    .btn-primary{background:var(--brand-600);color:#fff}

    {{-- Filter Card --}}
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:20px}
    .filter-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px}
    .filter-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .filter-body{padding:20px}
    .filter-grid{display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:14px;align-items:end}
    .field{display:flex;flex-direction:column;gap:5px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}
    .field label .req{color:var(--brand-600);margin-left:2px}
    .field select,.field input{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);width:100%;outline:none;transition:border-color .15s}
    .field select:focus,.field input:focus{border-color:var(--brand-500);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1)}
    .field select.is-invalid,.field input.is-invalid{border-color:#dc2626}
    .field-error{font-size:12px;color:#dc2626;font-family:'DM Sans',sans-serif;margin-top:-2px}

    {{-- Summary --}}
    .summary-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px}
    .summary-left .title{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text)}
    .summary-left .sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .summary-stats{display:flex;gap:20px;flex-wrap:wrap}
    .sumstat{text-align:center;min-width:44px}
    .sumstat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;line-height:1}
    .sumstat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;margin-top:3px}
    .sumstat-val.green{color:#15803d}.sumstat-val.yellow{color:#a16207}
    .sumstat-val.blue{color:#1d4ed8}.sumstat-val.purple{color:#7c3aed}.sumstat-val.red{color:#dc2626}

    {{-- Table --}}
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border)}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:10px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)}
    .num-cell{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px}
    .num-cell.hadir{color:#15803d}.num-cell.telat{color:#a16207}
    .num-cell.izin{color:#1d4ed8}.num-cell.sakit{color:#7c3aed}.num-cell.alfa{color:#dc2626}
    .pct-bar{height:6px;background:var(--surface3);border-radius:99px;margin-top:4px;overflow:hidden;width:80px}
    .pct-fill{height:100%;border-radius:99px}
    .student-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}

    {{-- Placeholder state (belum pilih kelas) --}}
    .placeholder-box{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:60px 20px;text-align:center;margin-bottom:20px}

    @media print{
        .no-print{display:none!important}
        .page{padding:0}
        .filter-card{display:none}
    }
    @media(max-width:900px){
        .page{padding:16px 16px 40px}
        .filter-grid{grid-template-columns:1fr 1fr}
        .filter-grid .btn-primary{grid-column:span 2}
    }
    @media(max-width:580px){
        .filter-grid{grid-template-columns:1fr}
        .filter-grid .btn-primary{grid-column:span 1}
    }
</style>

<div class="page">
    <nav class="breadcrumb no-print">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.absensi.index') }}">Data Absensi</a>
        <span class="sep">›</span>
        <span class="current">Rekap Kelas</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Rekap Absensi Kelas</h1>
            @if($kelas && $absensi !== null)
            <p class="page-sub">
                {{ $kelas->nama_kelas }} &nbsp;·&nbsp;
                {{ \Carbon\Carbon::parse($request->tanggal_dari)->format('d M Y') }}
                –
                {{ \Carbon\Carbon::parse($request->tanggal_sampai)->format('d M Y') }}
            </p>
            @else
            <p class="page-sub">Pilih kelas dan rentang tanggal untuk melihat rekap kehadiran</p>
            @endif
        </div>
        <div class="header-actions no-print">
            @if($kelas && $absensi !== null)
            {{-- Tombol export hanya tampil jika rekap sudah ditampilkan --}}
            <button onclick="window.print()" class="btn btn-print">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Cetak
            </button>
            <a href="{{ route('admin.absensi.rekap-kelas.export.pdf', [
                'kelas_id'       => $request->kelas_id,
                'tanggal_dari'   => $request->tanggal_dari,
                'tanggal_sampai' => $request->tanggal_sampai,
            ]) }}" class="btn btn-pdf">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Export PDF
            </a>
            <a href="{{ route('admin.absensi.rekap-kelas.export.excel', [
                'kelas_id'       => $request->kelas_id,
                'tanggal_dari'   => $request->tanggal_dari,
                'tanggal_sampai' => $request->tanggal_sampai,
            ]) }}" class="btn btn-excel">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Export Excel
            </a>
            @endif
            <a href="{{ route('admin.absensi.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- ── FORM FILTER ──────────────────────────────────────────────────────── --}}
    <div class="filter-card no-print">
        <div class="filter-header">
            <svg width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
            <span class="filter-title">Filter Rekap</span>
        </div>
        <div class="filter-body">
            <form method="GET" action="{{ route('admin.absensi.rekap-kelas') }}" id="filterForm">
                <div class="filter-grid">
                    <div class="field">
                        <label>Kelas <span class="req">*</span></label>
                        <select name="kelas_id" class="{{ $errors->has('kelas_id') ? 'is-invalid' : '' }}" required>
                            <option value="">— Pilih Kelas —</option>
                            @foreach($kelasList as $k)
                                <option value="{{ $k->id }}" {{ $request->kelas_id == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Tanggal Dari <span class="req">*</span></label>
                        <input type="date" name="tanggal_dari"
                               value="{{ $request->tanggal_dari ?? now()->startOfMonth()->toDateString() }}"
                               class="{{ $errors->has('tanggal_dari') ? 'is-invalid' : '' }}" required>
                        @error('tanggal_dari')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Tanggal Sampai <span class="req">*</span></label>
                        <input type="date" name="tanggal_sampai"
                               value="{{ $request->tanggal_sampai ?? now()->toDateString() }}"
                               class="{{ $errors->has('tanggal_sampai') ? 'is-invalid' : '' }}" required>
                        @error('tanggal_sampai')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary" style="height:38px;width:100%;justify-content:center">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            Tampilkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- ── BELUM PILIH KELAS ────────────────────────────────────────────────── --}}
    @if($absensi === null)
    <div class="placeholder-box">
        <div class="empty-icon" style="margin:0 auto 14px">
            <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
        </div>
        <p class="empty-title">Pilih Kelas &amp; Periode</p>
        <p class="empty-sub">Pilih kelas dan rentang tanggal di atas, lalu klik <strong>Tampilkan</strong> untuk melihat rekap absensi.</p>
    </div>

    {{-- ── REKAP TERSEDIA ───────────────────────────────────────────────────── --}}
    @else

    @php
        $totalHadir = 0; $totalTelat = 0; $totalIzin = 0; $totalSakit = 0; $totalAlfa = 0;
        foreach($absensi as $siswaId => $records) {
            $totalHadir += $records->where('status','hadir')->count();
            $totalTelat += $records->where('status','telat')->count();
            $totalIzin  += $records->where('status','izin')->count();
            $totalSakit += $records->where('status','sakit')->count();
            $totalAlfa  += $records->where('status','alfa')->count();
        }
        $grandTotal = $totalHadir + $totalTelat + $totalIzin + $totalSakit + $totalAlfa;
    @endphp

    {{-- Summary --}}
    <div class="summary-card">
        <div class="summary-left">
            <p class="title">{{ $kelas->nama_kelas }}</p>
            <p class="sub">
                {{ $absensi->count() }} siswa
                &nbsp;·&nbsp;
                {{ $grandTotal }} total record absensi
            </p>
        </div>
        <div class="summary-stats">
            <div class="sumstat">
                <p class="sumstat-val green">{{ $totalHadir }}</p>
                <p class="sumstat-label">Hadir</p>
            </div>
            <div class="sumstat">
                <p class="sumstat-val yellow">{{ $totalTelat }}</p>
                <p class="sumstat-label">Telat</p>
            </div>
            <div class="sumstat">
                <p class="sumstat-val blue">{{ $totalIzin }}</p>
                <p class="sumstat-label">Izin</p>
            </div>
            <div class="sumstat">
                <p class="sumstat-val purple">{{ $totalSakit }}</p>
                <p class="sumstat-label">Sakit</p>
            </div>
            <div class="sumstat">
                <p class="sumstat-val red">{{ $totalAlfa }}</p>
                <p class="sumstat-label">Alfa</p>
            </div>
        </div>
    </div>

    {{-- Table --}}
    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">
                Rekap Per Siswa
                <span>— {{ $absensi->count() }} siswa</span>
            </p>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:48px">#</th>
                        <th>Nama Siswa</th>
                        <th class="center">Hadir</th>
                        <th class="center">Telat</th>
                        <th class="center">Izin</th>
                        <th class="center">Sakit</th>
                        <th class="center">Alfa</th>
                        <th class="center">Total</th>
                        <th>% Kehadiran</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($absensi as $siswaId => $records)
                    @php
                        $siswa    = $records->first()->siswa;
                        $hadir    = $records->where('status','hadir')->count();
                        $telat    = $records->where('status','telat')->count();
                        $izin     = $records->where('status','izin')->count();
                        $sakit    = $records->where('status','sakit')->count();
                        $alfa     = $records->where('status','alfa')->count();
                        $total    = $records->count();
                        // Kehadiran = hadir + telat (telat tetap dihitung hadir)
                        $pctHadir = $total > 0 ? round((($hadir + $telat) / $total) * 100) : 0;
                        $pctColor = $pctHadir >= 80 ? '#15803d' : ($pctHadir >= 60 ? '#a16207' : '#dc2626');
                    @endphp
                    <tr>
                        <td><span class="no-col">{{ $loop->iteration }}</span></td>
                        <td>
                            <p class="student-name">{{ $siswa->nama_lengkap ?? '—' }}</p>
                            <p style="font-size:12px;color:var(--text3);margin-top:1px">NIS: {{ $siswa->nis ?? '—' }}</p>
                        </td>
                        <td class="center"><span class="num-cell hadir">{{ $hadir }}</span></td>
                        <td class="center"><span class="num-cell telat">{{ $telat }}</span></td>
                        <td class="center"><span class="num-cell izin">{{ $izin }}</span></td>
                        <td class="center"><span class="num-cell sakit">{{ $sakit }}</span></td>
                        <td class="center"><span class="num-cell alfa">{{ $alfa }}</span></td>
                        <td class="center">
                            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text)">{{ $total }}</span>
                        </td>
                        <td>
                            <div style="display:flex;align-items:center;gap:8px">
                                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:{{ $pctColor }};width:36px">{{ $pctHadir }}%</span>
                                <div class="pct-bar">
                                    <div class="pct-fill" style="width:{{ $pctHadir }}%;background:{{ $pctColor }}"></div>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9">
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                </div>
                                <p class="empty-title">Tidak ada data absensi</p>
                                <p class="empty-sub">Tidak ditemukan rekap absensi untuk kelas dan rentang tanggal ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @endif {{-- end $absensi !== null --}}
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif

    // Validasi sisi klien: tanggal_sampai >= tanggal_dari
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        const dari    = document.querySelector('[name="tanggal_dari"]').value;
        const sampai  = document.querySelector('[name="tanggal_sampai"]').value;
        const kelasId = document.querySelector('[name="kelas_id"]').value;
        if (!kelasId) {
            e.preventDefault();
            Swal.fire({ icon:'warning', title:'Pilih Kelas', text:'Harap pilih kelas terlebih dahulu.', confirmButtonColor:'#1f63db' });
            return;
        }
        if (dari && sampai && sampai < dari) {
            e.preventDefault();
            Swal.fire({ icon:'warning', title:'Tanggal Tidak Valid', text:'Tanggal sampai harus setelah atau sama dengan tanggal dari.', confirmButtonColor:'#1f63db' });
        }
    });
</script>
</x-app-layout><x-app-layout>
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
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none}.breadcrumb a:hover{color:var(--brand-600)}
    .breadcrumb .sep{color:var(--border2)}.breadcrumb .current{color:var(--text2)}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-back:hover{background:var(--surface3);filter:none}
    .btn-print{background:var(--brand-600);color:#fff}
    .btn-pdf{background:#fee2e2;color:#dc2626;border:1px solid #fecaca}
    .btn-pdf:hover{background:#fecaca;filter:none}
    .btn-excel{background:#dcfce7;color:#15803d;border:1px solid #bbf7d0}
    .btn-excel:hover{background:#bbf7d0;filter:none}
    .btn-primary{background:var(--brand-600);color:#fff}
    .filter-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:20px}
    .filter-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px}
    .filter-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .filter-body{padding:20px}
    .filter-grid{display:grid;grid-template-columns:1fr 1fr 1fr auto;gap:14px;align-items:end}
    .field{display:flex;flex-direction:column;gap:5px}
    .field label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text2)}
    .field label .req{color:var(--brand-600);margin-left:2px}
    .field select,.field input{height:38px;padding:0 12px;border:1px solid var(--border);border-radius:var(--radius-sm);font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);background:var(--surface2);width:100%;outline:none;transition:border-color .15s}
    .field select:focus,.field input:focus{border-color:var(--brand-500);background:#fff;box-shadow:0 0 0 3px rgba(53,130,240,.1)}
    .field select.is-invalid,.field input.is-invalid{border-color:#dc2626}
    .field-error{font-size:12px;color:#dc2626;font-family:'DM Sans',sans-serif;margin-top:-2px}
    .summary-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px}
    .summary-left .title{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text)}
    .summary-left .sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .summary-stats{display:flex;gap:20px;flex-wrap:wrap}
    .sumstat{text-align:center;min-width:44px}
    .sumstat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;line-height:1}
    .sumstat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;margin-top:3px}
    .sumstat-val.green{color:#15803d}.sumstat-val.yellow{color:#a16207}
    .sumstat-val.blue{color:#1d4ed8}.sumstat-val.purple{color:#7c3aed}.sumstat-val.red{color:#dc2626}
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border)}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .table-info span{font-weight:400;color:var(--text3);margin-left:6px}
    .table-wrap{overflow-x:auto}
    table{width:100%;border-collapse:collapse;font-size:13px}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border)}
    thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap}
    thead th.center{text-align:center}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s}
    tbody tr:last-child{border-bottom:none}
    tbody tr:hover{background:#fafbff}
    td{padding:10px 14px;color:var(--text);vertical-align:middle}
    td.center{text-align:center}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)}
    .num-cell{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px}
    .num-cell.hadir{color:#15803d}.num-cell.telat{color:#a16207}
    .num-cell.izin{color:#1d4ed8}.num-cell.sakit{color:#7c3aed}.num-cell.alfa{color:#dc2626}
    .pct-bar{height:6px;background:var(--surface3);border-radius:99px;margin-top:4px;overflow:hidden;width:80px}
    .pct-fill{height:100%;border-radius:99px}
    .student-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--text)}
    .empty-state{padding:60px 20px;text-align:center}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px}
    .empty-sub{font-size:13px;color:var(--text3)}
    .placeholder-box{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:60px 20px;text-align:center;margin-bottom:20px}
    @media print{
        .no-print{display:none!important}
        .page{padding:0}
        .filter-card{display:none}
    }
    @media(max-width:900px){
        .page{padding:16px 16px 40px}
        .filter-grid{grid-template-columns:1fr 1fr}
        .filter-grid .submit-col{grid-column:span 2}
    }
    @media(max-width:580px){
        .filter-grid{grid-template-columns:1fr}
        .filter-grid .submit-col{grid-column:span 1}
    }
</style>

{{--
    FIX #1 — $request di sini adalah Illuminate\Http\Request yang dikirim via compact('request')
    dari controller. Akses propertinya via $request->kelas_id, $request->tanggal_dari, dll.
    Semua sudah menggunakan null-safe operator (??) untuk mencegah error jika belum diisi.

    FIX #2 — $absensi dikirim null (bukan Collection) jika kelas_id belum dipilih.
    Gunakan $absensi !== null sebagai guard utama, bukan is_null() atau empty().

    FIX #3 — $absensi sudah di-groupBy('siswa_id') di controller, jadi iterasi
    menggunakan $siswaId => $records. $records adalah Collection of Absensi.
    Relasi ->siswa sudah di-eager-load via with('siswa') di controller.

    FIX #4 — Route name export sudah sesuai dengan web.php:
    admin.absensi.rekap-kelas.export.pdf dan admin.absensi.rekap-kelas.export.excel

    FIX #5 — Komentar Blade {{-- --}} DIHAPUS dari dalam blok <style></style>
    karena bisa menyebabkan parse error pada beberapa konfigurasi server.
--}}

<div class="page">
    <nav class="breadcrumb no-print">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.absensi.index') }}">Data Absensi</a>
        <span class="sep">›</span>
        <span class="current">Rekap Kelas</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Rekap Absensi Kelas</h1>
            {{-- FIX #1: Gunakan $kelas && $absensi !== null sebagai kondisi header --}}
            @if($kelas && $absensi !== null)
                <p class="page-sub">
                    {{ $kelas->nama_kelas }} &nbsp;·&nbsp;
                    {{ \Carbon\Carbon::parse($request->tanggal_dari)->format('d M Y') }}
                    –
                    {{ \Carbon\Carbon::parse($request->tanggal_sampai)->format('d M Y') }}
                </p>
            @else
                <p class="page-sub">Pilih kelas dan rentang tanggal untuk melihat rekap kehadiran</p>
            @endif
        </div>
        <div class="header-actions no-print">
            {{-- FIX #4: Route name sudah sesuai web.php: rekap-kelas.export.pdf / .excel --}}
            @if($kelas && $absensi !== null)
                <button onclick="window.print()" class="btn btn-print">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Cetak
                </button>
                <a href="{{ route('admin.absensi.rekap-kelas.export.pdf', [
                    'kelas_id'       => $request->kelas_id,
                    'tanggal_dari'   => $request->tanggal_dari,
                    'tanggal_sampai' => $request->tanggal_sampai,
                ]) }}" class="btn btn-pdf" target="_blank">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Export PDF
                </a>
                <a href="{{ route('admin.absensi.rekap-kelas.export.excel', [
                    'kelas_id'       => $request->kelas_id,
                    'tanggal_dari'   => $request->tanggal_dari,
                    'tanggal_sampai' => $request->tanggal_sampai,
                ]) }}" class="btn btn-excel">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    Export Excel
                </a>
            @endif
            <a href="{{ route('admin.absensi.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- FORM FILTER --}}
    <div class="filter-card no-print">
        <div class="filter-header">
            <svg width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><polygon points="22 3 2 3 10 12.46 10 19 14 21 14 12.46 22 3"/></svg>
            <span class="filter-title">Filter Rekap</span>
        </div>
        <div class="filter-body">
            <form method="GET" action="{{ route('admin.absensi.rekap-kelas') }}" id="filterForm">
                <div class="filter-grid">
                    <div class="field">
                        <label>Kelas <span class="req">*</span></label>
                        <select name="kelas_id" class="{{ $errors->has('kelas_id') ? 'is-invalid' : '' }}" required>
                            <option value="">— Pilih Kelas —</option>
                            @foreach($kelasList as $k)
                                {{--
                                    FIX #1: Gunakan $request->kelas_id (Request object dari controller)
                                    bukan $request->input() — keduanya valid, tapi ->kelas_id lebih singkat
                                --}}
                                <option value="{{ $k->id }}" {{ $request->kelas_id == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                        @error('kelas_id')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Tanggal Dari <span class="req">*</span></label>
                        {{-- FIX #1: $request->tanggal_dari bisa null jika belum submit, pakai ?? fallback --}}
                        <input type="date" name="tanggal_dari"
                               value="{{ $request->tanggal_dari ?? now()->startOfMonth()->toDateString() }}"
                               class="{{ $errors->has('tanggal_dari') ? 'is-invalid' : '' }}" required>
                        @error('tanggal_dari')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="field">
                        <label>Tanggal Sampai <span class="req">*</span></label>
                        <input type="date" name="tanggal_sampai"
                               value="{{ $request->tanggal_sampai ?? now()->toDateString() }}"
                               class="{{ $errors->has('tanggal_sampai') ? 'is-invalid' : '' }}" required>
                        @error('tanggal_sampai')<span class="field-error">{{ $message }}</span>@enderror
                    </div>
                    <div class="submit-col">
                        <button type="submit" class="btn btn-primary" style="height:38px;width:100%;justify-content:center">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                            Tampilkan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- BELUM PILIH KELAS (controller kirim $absensi = null) --}}
    @if($absensi === null)
        <div class="placeholder-box">
            <div class="empty-icon">
                <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <p class="empty-title">Pilih Kelas &amp; Periode</p>
            <p class="empty-sub">Pilih kelas dan rentang tanggal di atas, lalu klik <strong>Tampilkan</strong> untuk melihat rekap absensi.</p>
        </div>

    @else
        {{--
            FIX #3 — $absensi adalah hasil ->groupBy('siswa_id') dari controller.
            Tipe: Illuminate\Support\Collection, key = siswa_id (integer), value = Collection of Absensi.
            Relasi siswa sudah di-eager-load: Absensi::with('siswa')->...->get()->groupBy('siswa_id')
        --}}
        @php
            $totalHadir = 0;
            $totalTelat = 0;
            $totalIzin  = 0;
            $totalSakit = 0;
            $totalAlfa  = 0;

            foreach ($absensi as $siswaId => $records) {
                $totalHadir += $records->where('status', 'hadir')->count();
                $totalTelat += $records->where('status', 'telat')->count();
                $totalIzin  += $records->where('status', 'izin')->count();
                $totalSakit += $records->where('status', 'sakit')->count();
                $totalAlfa  += $records->where('status', 'alfa')->count();
            }

            $grandTotal = $totalHadir + $totalTelat + $totalIzin + $totalSakit + $totalAlfa;
        @endphp

        {{-- Summary Bar --}}
        <div class="summary-card">
            <div class="summary-left">
                <p class="title">{{ $kelas->nama_kelas }}</p>
                <p class="sub">
                    {{ $absensi->count() }} siswa
                    &nbsp;·&nbsp;
                    {{ $grandTotal }} total record absensi
                    &nbsp;·&nbsp;
                    {{ \Carbon\Carbon::parse($request->tanggal_dari)->format('d M Y') }}
                    – {{ \Carbon\Carbon::parse($request->tanggal_sampai)->format('d M Y') }}
                </p>
            </div>
            <div class="summary-stats">
                <div class="sumstat">
                    <p class="sumstat-val green">{{ $totalHadir }}</p>
                    <p class="sumstat-label">Hadir</p>
                </div>
                <div class="sumstat">
                    <p class="sumstat-val yellow">{{ $totalTelat }}</p>
                    <p class="sumstat-label">Telat</p>
                </div>
                <div class="sumstat">
                    <p class="sumstat-val blue">{{ $totalIzin }}</p>
                    <p class="sumstat-label">Izin</p>
                </div>
                <div class="sumstat">
                    <p class="sumstat-val purple">{{ $totalSakit }}</p>
                    <p class="sumstat-label">Sakit</p>
                </div>
                <div class="sumstat">
                    <p class="sumstat-val red">{{ $totalAlfa }}</p>
                    <p class="sumstat-label">Alfa</p>
                </div>
            </div>
        </div>

        {{-- Tabel Rekap Per Siswa --}}
        <div class="table-card">
            <div class="table-topbar">
                <p class="table-info">
                    Rekap Per Siswa
                    <span>— {{ $absensi->count() }} siswa</span>
                </p>
            </div>
            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th style="width:48px">#</th>
                            <th>Nama Siswa</th>
                            <th class="center">Hadir</th>
                            <th class="center">Telat</th>
                            <th class="center">Izin</th>
                            <th class="center">Sakit</th>
                            <th class="center">Alfa</th>
                            <th class="center">Total</th>
                            <th>% Kehadiran</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($absensi as $siswaId => $records)
                            @php
                                {{--
                                    FIX #5 — Null-safe: $records->first() bisa null jika collection kosong.
                                    Gunakan optional() atau ?-> agar tidak error jika siswa tidak ter-load.
                                    Relasi sudah di-eager-load di controller (with('siswa')), tapi tetap
                                    defensive di sini untuk keamanan.
                                --}}
                                $siswa  = $records->first()?->siswa;
                                $hadir  = $records->where('status', 'hadir')->count();
                                $telat  = $records->where('status', 'telat')->count();
                                $izin   = $records->where('status', 'izin')->count();
                                $sakit  = $records->where('status', 'sakit')->count();
                                $alfa   = $records->where('status', 'alfa')->count();
                                $total  = $records->count();

                                // Kehadiran dihitung: hadir + telat (telat tetap dianggap hadir)
                                $hadirEfektif = $hadir + $telat;
                                $pctHadir     = $total > 0 ? round(($hadirEfektif / $total) * 100) : 0;

                                // Warna persentase: hijau >=80, kuning >=60, merah <60
                                $pctColor = $pctHadir >= 80 ? '#15803d' : ($pctHadir >= 60 ? '#a16207' : '#dc2626');
                            @endphp
                            <tr>
                                <td><span class="no-col">{{ $loop->iteration }}</span></td>
                                <td>
                                    {{-- FIX #5: Null-safe dengan ?-> dan ?? fallback --}}
                                    <p class="student-name">{{ $siswa?->nama_lengkap ?? '—' }}</p>
                                    <p style="font-size:12px;color:var(--text3);margin-top:1px">
                                        NIS: {{ $siswa?->nis ?? '—' }}
                                    </p>
                                </td>
                                <td class="center"><span class="num-cell hadir">{{ $hadir }}</span></td>
                                <td class="center"><span class="num-cell telat">{{ $telat }}</span></td>
                                <td class="center"><span class="num-cell izin">{{ $izin }}</span></td>
                                <td class="center"><span class="num-cell sakit">{{ $sakit }}</span></td>
                                <td class="center"><span class="num-cell alfa">{{ $alfa }}</span></td>
                                <td class="center">
                                    <span style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--text)">
                                        {{ $total }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display:flex;align-items:center;gap:8px">
                                        <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:{{ $pctColor }};width:36px">
                                            {{ $pctHadir }}%
                                        </span>
                                        <div class="pct-bar">
                                            <div class="pct-fill" style="width:{{ $pctHadir }}%;background:{{ $pctColor }}"></div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">
                                    <div class="empty-state">
                                        <div class="empty-icon">
                                            <svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                                        </div>
                                        <p class="empty-title">Tidak ada data absensi</p>
                                        <p class="empty-sub">Tidak ditemukan rekap absensi untuk kelas dan rentang tanggal ini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    @endif {{-- end $absensi !== null --}}
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: @json(session('success')),
        timer: 2500,
        showConfirmButton: false,
        toast: true,
        position: 'top-end'
    });
    @endif

    @if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: @json(session('error')),
        confirmButtonColor: '#1f63db'
    });
    @endif

    // Validasi sisi klien sebelum submit
    document.getElementById('filterForm').addEventListener('submit', function (e) {
        const kelasId = document.querySelector('[name="kelas_id"]').value;
        const dari    = document.querySelector('[name="tanggal_dari"]').value;
        const sampai  = document.querySelector('[name="tanggal_sampai"]').value;

        if (!kelasId) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Pilih Kelas',
                text: 'Harap pilih kelas terlebih dahulu.',
                confirmButtonColor: '#1f63db'
            });
            return;
        }

        if (dari && sampai && sampai < dari) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Tanggal Tidak Valid',
                text: 'Tanggal sampai harus setelah atau sama dengan tanggal dari.',
                confirmButtonColor: '#1f63db'
            });
        }
    });
</script>
</x-app-layout>