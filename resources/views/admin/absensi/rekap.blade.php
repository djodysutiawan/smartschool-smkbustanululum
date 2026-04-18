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

    .summary-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:20px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px}
    .summary-left .title{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text)}
    .summary-left .sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .summary-stats{display:flex;gap:16px;flex-wrap:wrap}
    .sumstat{text-align:center}
    .sumstat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;line-height:1}
    .sumstat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;margin-top:2px}
    .sumstat-val.green{color:#15803d}.sumstat-val.yellow{color:#a16207}
    .sumstat-val.purple{color:#7c3aed}.sumstat-val.red{color:#dc2626}

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
    td.muted{color:var(--text3)}
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
    @media print{.no-print{display:none!important}.page{padding:0}}
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
            <h1 class="page-title">Rekap Absensi — {{ $kelas->nama_kelas }}</h1>
            <p class="page-sub">
                {{ \Carbon\Carbon::parse($request->tanggal_dari)->format('d M Y') }}
                –
                {{ \Carbon\Carbon::parse($request->tanggal_sampai)->format('d M Y') }}
            </p>
        </div>
        <div class="header-actions no-print">
            {{-- Cetak / print browser --}}
            <button onclick="window.print()" class="btn btn-print">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Cetak
            </button>

            {{-- Export PDF rekap --}}
            <a href="{{ route('admin.absensi.rekap-kelas.export.pdf', [
                'kelas_id'       => $request->kelas_id,
                'tanggal_dari'   => $request->tanggal_dari,
                'tanggal_sampai' => $request->tanggal_sampai,
            ]) }}" class="btn btn-pdf">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Export PDF
            </a>

            {{-- Export Excel rekap --}}
            <a href="{{ route('admin.absensi.rekap-kelas.export.excel', [
                'kelas_id'       => $request->kelas_id,
                'tanggal_dari'   => $request->tanggal_dari,
                'tanggal_sampai' => $request->tanggal_sampai,
            ]) }}" class="btn btn-excel">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Export Excel
            </a>

            <a href="{{ route('admin.absensi.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    {{-- Summary --}}
    @php
        $totalHadir = 0; $totalTelat = 0; $totalIzin = 0; $totalSakit = 0; $totalAlfa = 0;
        foreach($absensi as $siswaId => $records) {
            $totalHadir += $records->where('status','hadir')->count();
            $totalTelat += $records->where('status','telat')->count();
            $totalIzin  += $records->where('status','izin')->count();
            $totalSakit += $records->where('status','sakit')->count();
            $totalAlfa  += $records->where('status','alfa')->count();
        }
    @endphp
    <div class="summary-card">
        <div class="summary-left">
            <p class="title">{{ $kelas->nama_kelas }}</p>
            <p class="sub">{{ $absensi->count() }} siswa · {{ $absensi->flatten()->count() }} total record absensi</p>
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
                <p class="sumstat-val" style="color:#1d4ed8">{{ $totalIzin }}</p>
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
            <p class="table-info">Rekap Per Siswa <span>— {{ $absensi->count() }} siswa</span></p>
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
                        $pctHadir = $total > 0 ? round((($hadir + $telat) / $total) * 100) : 0;
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
                                <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:{{ $pctHadir >= 80 ? '#15803d' : ($pctHadir >= 60 ? '#a16207' : '#dc2626') }};width:36px">{{ $pctHadir }}%</span>
                                <div class="pct-bar">
                                    <div class="pct-fill" style="width:{{ $pctHadir }}%;background:{{ $pctHadir >= 80 ? '#15803d' : ($pctHadir >= 60 ? '#a16207' : '#dc2626') }}"></div>
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
                                <p class="empty-sub">Tidak ditemukan rekap absensi untuk kelas dan rentang tanggal ini</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
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
</script>
</x-app-layout>