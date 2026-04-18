<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;--brand-100:#d9ebff;--brand-50:#eef6ff;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px;}
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto;}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;}
    .breadcrumb a{color:var(--text3);text-decoration:none;}.breadcrumb a:hover{color:var(--brand-600);}
    .breadcrumb .sep{color:var(--border2);}.breadcrumb .current{color:var(--text2);}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
    .btn-back:hover{background:var(--surface3);filter:none;}
    .btn-print{background:var(--brand-600);color:#fff;}
    .btn-export-pdf{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .btn-export-pdf:hover{background:#fee2e2;filter:none;}
    .btn-export-excel{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .btn-export-excel:hover{background:#dcfce7;filter:none;}
    .rapor-meta{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;display:flex;align-items:center;gap:20px;flex-wrap:wrap;}
    .meta-item{display:flex;flex-direction:column;gap:2px;}
    .meta-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.06em;}
    .meta-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:var(--text);}
    .meta-sep{width:1px;height:36px;background:var(--border);}
    .stats-strip{display:grid;grid-template-columns:repeat(5,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:12px 16px;text-align:center;}
    .stat-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;}
    .stat-lbl{font-size:11.5px;color:var(--text3);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;text-transform:uppercase;letter-spacing:.04em;margin-top:2px;}
    .table-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .table-topbar{display:flex;align-items:center;justify-content:space-between;padding:14px 20px;border-bottom:1px solid var(--border);flex-wrap:wrap;gap:10px;}
    .table-info{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .table-actions{display:flex;gap:8px;}
    .table-wrap{overflow-x:auto;}
    table{width:100%;border-collapse:collapse;font-size:13px;}
    thead tr{background:var(--surface2);border-bottom:1px solid var(--border);}
    thead th{padding:11px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;white-space:nowrap;}
    thead th.center{text-align:center;}
    tbody tr{border-bottom:1px solid #f1f5f9;transition:background .1s;}
    tbody tr:last-child{border-bottom:none;}
    tbody tr:hover{background:#fafbff;}
    td{padding:9px 14px;color:var(--text);vertical-align:middle;}
    td.center{text-align:center;}td.muted{color:var(--text3);font-size:12.5px;}
    .no-col{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3);}
    .sname{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;color:var(--text);}
    .mapel-tag{display:inline-block;padding:1px 7px;border-radius:4px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}
    .badge{display:inline-flex;align-items:center;padding:2px 8px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:800;}
    .badge-a{background:#dcfce7;color:#15803d;}.badge-b{background:#dbeafe;color:#1d4ed8;}.badge-c{background:#fef9c3;color:#a16207;}.badge-d{background:#fee2e2;color:#dc2626;}.badge-e{background:#ffe4e6;color:#9f1239;}
    .nilai-num{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;}
    .empty-state{padding:60px 20px;text-align:center;}
    .empty-icon{width:56px;height:56px;background:var(--surface2);border-radius:14px;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--text);margin-bottom:5px;}
    .empty-sub{font-size:13px;color:var(--text3);}
    @media print{
        .breadcrumb,.page-header .btn,.stats-strip{display:none!important;}
        .page{padding:0;}
        .table-topbar .table-actions{display:none!important;}
    }
    @media(max-width:768px){.stats-strip{grid-template-columns:repeat(3,1fr);}.page{padding:16px;}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.nilai.index') }}">Nilai Siswa</a>
        <span class="sep">›</span>
        <span class="current">Rapor Kelas</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Rapor Kelas {{ $kelas->nama_kelas }}</h1>
            <p class="page-sub">Rekap nilai semua siswa — {{ $tahunAjaran->tahun }} Semester {{ ucfirst($tahunAjaran->semester) }}</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <a href="{{ route('admin.nilai.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <button onclick="window.print()" class="btn btn-print">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Cetak
            </button>
        </div>
    </div>

    <div class="rapor-meta">
        <div class="meta-item"><p class="meta-label">Kelas</p><p class="meta-val">{{ $kelas->nama_kelas }}</p></div>
        <div class="meta-sep"></div>
        <div class="meta-item"><p class="meta-label">Tahun Ajaran</p><p class="meta-val">{{ $tahunAjaran->tahun }}</p></div>
        <div class="meta-sep"></div>
        <div class="meta-item"><p class="meta-label">Semester</p><p class="meta-val">{{ ucfirst($tahunAjaran->semester) }}</p></div>
        <div class="meta-sep"></div>
        <div class="meta-item"><p class="meta-label">Total Siswa</p><p class="meta-val">{{ $nilai->count() }} siswa</p></div>
        <div class="meta-sep"></div>
        <div class="meta-item"><p class="meta-label">Dicetak</p><p class="meta-val">{{ now()->format('d M Y') }}</p></div>
    </div>

    @php
        $allNilai   = $nilai->flatten();
        $countA     = $allNilai->where('predikat', 'A')->count();
        $countB     = $allNilai->where('predikat', 'B')->count();
        $countC     = $allNilai->where('predikat', 'C')->count();
        $countBawah = $allNilai->whereIn('predikat', ['D', 'E'])->count();
        $avgAll     = $allNilai->whereNotNull('nilai_akhir')->avg('nilai_akhir');
    @endphp

    <div class="stats-strip">
        <div class="stat-card"><p class="stat-num" style="color:var(--brand-600)">{{ $nilai->count() }}</p><p class="stat-lbl">Siswa</p></div>
        <div class="stat-card"><p class="stat-num" style="color:#15803d">{{ $countA }}</p><p class="stat-lbl">Predikat A</p></div>
        <div class="stat-card"><p class="stat-num" style="color:#2563eb">{{ $countB }}</p><p class="stat-lbl">Predikat B</p></div>
        <div class="stat-card"><p class="stat-num" style="color:#d97706">{{ $countC }}</p><p class="stat-lbl">Predikat C</p></div>
        <div class="stat-card"><p class="stat-num" style="color:#dc2626">{{ $countBawah }}</p><p class="stat-lbl">Di Bawah KKM</p></div>
    </div>

    <div class="table-card">
        <div class="table-topbar">
            <p class="table-info">Rekap Nilai Per Siswa
                @if($avgAll)
                    <span style="font-weight:400;color:var(--text3);margin-left:6px">Rata-rata kelas: <strong style="color:var(--brand-600)">{{ number_format($avgAll, 1) }}</strong></span>
                @endif
            </p>
            <div class="table-actions">
                <a href="{{ route('admin.nilai.rapor-kelas.export.pdf', ['kelas_id' => $kelas->id, 'tahun_ajaran_id' => $tahunAjaran->id]) }}"
                   class="btn btn-sm btn-export-pdf" target="_blank">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    PDF
                </a>
                <a href="{{ route('admin.nilai.rapor-kelas.export.excel', ['kelas_id' => $kelas->id, 'tahun_ajaran_id' => $tahunAjaran->id]) }}"
                   class="btn btn-sm btn-export-excel">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
                    Excel
                </a>
            </div>
        </div>
        <div class="table-wrap">
            <table>
                <thead>
                    <tr>
                        <th style="width:40px">#</th>
                        <th>Nama Siswa</th>
                        <th>Mata Pelajaran</th>
                        <th class="center">Tugas</th>
                        <th class="center">Harian</th>
                        <th class="center">UTS</th>
                        <th class="center">UAS</th>
                        <th class="center">Nilai Akhir</th>
                        <th class="center">Predikat</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($nilai as $siswaId => $siswaRow)
                        @foreach($siswaRow as $idx => $n)
                        <tr>
                            @if($idx === 0)
                                <td rowspan="{{ $siswaRow->count() }}"><span class="no-col">{{ $loop->parent->iteration }}</span></td>
                                <td rowspan="{{ $siswaRow->count() }}"><p class="sname">{{ $n->siswa->nama_lengkap ?? '-' }}</p></td>
                            @endif
                            <td><span class="mapel-tag">{{ $n->mataPelajaran->nama_mapel ?? '-' }}</span></td>
                            <td class="center muted">{{ $n->nilai_tugas ?? '—' }}</td>
                            <td class="center muted">{{ $n->nilai_harian ?? '—' }}</td>
                            <td class="center muted">{{ $n->nilai_uts ?? '—' }}</td>
                            <td class="center muted">{{ $n->nilai_uas ?? '—' }}</td>
                            <td class="center">
                                @if($n->nilai_akhir !== null)
                                    @php
                                        $nc = $n->predikat === 'A' ? '#15803d' : ($n->predikat === 'B' ? '#2563eb' : ($n->predikat === 'C' ? '#d97706' : '#dc2626'));
                                    @endphp
                                    <span class="nilai-num" style="color:{{ $nc }}">{{ number_format($n->nilai_akhir, 1) }}</span>
                                @else
                                    <span class="muted">—</span>
                                @endif
                            </td>
                            <td class="center">
                                @if($n->predikat)
                                    <span class="badge badge-{{ strtolower($n->predikat) }}">{{ $n->predikat }}</span>
                                @else
                                    <span class="muted">—</span>
                                @endif
                            </td>
                            <td class="muted" style="font-size:12px;max-width:180px">{{ $n->catatan ?? '-' }}</td>
                        </tr>
                        @endforeach
                    @empty
                    <tr><td colspan="10">
                        <div class="empty-state">
                            <div class="empty-icon"><svg width="24" height="24" fill="none" stroke="#94a3b8" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg></div>
                            <p class="empty-title">Tidak ada data nilai</p>
                            <p class="empty-sub">Belum ada nilai yang diinput untuk kelas dan tahun ajaran ini</p>
                        </div>
                    </td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
    @endif
    @if(session('error'))
    Swal.fire({icon:'error',title:'Gagal!',text:@json(session('error')),confirmButtonColor:'#1f63db'});
    @endif
</script>
</x-app-layout>