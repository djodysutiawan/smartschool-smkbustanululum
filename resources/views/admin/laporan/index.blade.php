<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root{--brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;--brand-100:#d9ebff;--brand-50:#eef6ff;--surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;--border:#e2e8f0;--text:#0f172a;--text2:#475569;--text3:#94a3b8;--radius:10px;--radius-sm:7px;}
    .page{padding:28px 28px 40px;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);}
    .page-sub{font-size:13px;color:var(--text3);margin-top:4px;margin-bottom:24px;}
    .stats-strip{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:28px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;display:flex;align-items:center;gap:14px;}
    .stat-icon{width:44px;height:44px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}
    .stat-icon.green{background:#f0fdf4;}
    .stat-icon.red{background:#fff0f0;}
    .stat-icon.orange{background:#fff7ed;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;font-weight:800;color:var(--text);line-height:1.1;margin-top:2px;}
    .ta-bar{background:linear-gradient(135deg,var(--brand-600),#3582f0);border-radius:var(--radius);padding:18px 24px;color:#fff;display:flex;align-items:center;gap:16px;margin-bottom:28px;}
    .ta-icon-wrap{width:46px;height:46px;background:rgba(255,255,255,.18);border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .ta-label{font-size:11px;font-weight:600;opacity:.8;text-transform:uppercase;letter-spacing:.05em;}
    .ta-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;margin-top:2px;}
    .ta-sub{font-size:11.5px;opacity:.7;margin-top:1px;}
    .section-head{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:800;color:var(--text);margin-bottom:14px;display:flex;align-items:center;gap:8px;}
    .section-line{flex:1;height:1px;background:var(--border);}
    .reports-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:16px;}
    .rc{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;transition:box-shadow .15s,border-color .15s;}
    .rc:hover{box-shadow:0 4px 20px rgba(31,99,219,.09);border-color:var(--brand-100);}
    .rc-top{padding:20px 22px 14px;display:flex;align-items:flex-start;gap:14px;}
    .rc-ico{width:46px;height:46px;border-radius:11px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .ico-green{background:#f0fdf4;}
    .ico-blue{background:var(--brand-50);}
    .ico-red{background:#fff0f0;}
    .ico-purple{background:#fdf4ff;}
    .rc-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text);}
    .rc-desc{font-size:12px;color:var(--text3);margin-top:3px;line-height:1.55;}
    .rc-btns{padding:12px 22px 18px;display:flex;gap:7px;flex-wrap:wrap;border-top:1px solid var(--surface3);}
    .btn{display:inline-flex;align-items:center;gap:5px;padding:7px 14px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.92);}
    .btn-view{background:var(--brand-600);color:#fff;}
    .btn-pdf{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}
    .btn-pdf:hover{background:#fee2e2;filter:none;}
    .btn-excel{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;}
    .btn-excel:hover{background:#dcfce7;filter:none;}
    @media(max-width:768px){.stats-strip{grid-template-columns:1fr 1fr;}.reports-grid{grid-template-columns:1fr;}.page{padding:16px;}}
</style>

<div class="page">
    <h1 class="page-title">📊 Pusat Laporan</h1>
    <p class="page-sub">Kelola dan ekspor semua laporan akademik — kehadiran, nilai, pelanggaran, dan data siswa</p>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="20" height="20" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div><p class="stat-label">Total Siswa Aktif</p><p class="stat-val">{{ number_format($stats['total_siswa']) }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="20" height="20" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div><p class="stat-label">Hadir Hari Ini</p><p class="stat-val">{{ number_format($stats['kehadiran_hari_ini']) }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="20" height="20" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
            </div>
            <div><p class="stat-label">Pelanggaran Bulan Ini</p><p class="stat-val">{{ number_format($stats['total_pelanggaran']) }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="20" height="20" fill="none" stroke="#c2410c" stroke-width="1.8" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
            </div>
            <div><p class="stat-label">Total Guru Aktif</p><p class="stat-val">{{ number_format($stats['total_guru']) }}</p></div>
        </div>
    </div>

    @if($tahunAjaranAktif)
    <div class="ta-bar">
        <div class="ta-icon-wrap">
            <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        </div>
        <div>
            <p class="ta-label">Tahun Ajaran Aktif Sekarang</p>
            <p class="ta-val">{{ $tahunAjaranAktif->tahun }} — Semester {{ ucfirst($tahunAjaranAktif->semester) }}</p>
            <p class="ta-sub">{{ $tahunAjaranAktif->tanggal_mulai->format('d M Y') }} s/d {{ $tahunAjaranAktif->tanggal_selesai->format('d M Y') }}</p>
        </div>
    </div>
    @endif

    <p class="section-head">
        <svg width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        Pilih Jenis Laporan
        <span class="section-line"></span>
    </p>

    <div class="reports-grid">
        <div class="rc">
            <div class="rc-top">
                <div class="rc-ico ico-green"><svg width="22" height="22" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
                <div><p class="rc-name">Laporan Absensi</p><p class="rc-desc">Rekap kehadiran siswa per hari, kelas, atau rentang tanggal. Filter hadir, izin, sakit, telat, dan alfa.</p></div>
            </div>
            <div class="rc-btns">
                <a href="{{ route('admin.laporan.absensi') }}" class="btn btn-view">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>Lihat
                </a>
                <a href="{{ route('admin.laporan.absensi.export.pdf') }}" class="btn btn-pdf" target="_blank">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>Export PDF
                </a>
                <a href="{{ route('admin.laporan.absensi.export.excel') }}" class="btn btn-excel">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>Export Excel
                </a>
            </div>
        </div>

        <div class="rc">
            <div class="rc-top">
                <div class="rc-ico ico-blue"><svg width="22" height="22" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
                <div><p class="rc-name">Laporan Nilai</p><p class="rc-desc">Rekap nilai siswa per mata pelajaran, kelas, dan tahun ajaran. Tampilkan nilai tugas, UTS, UAS, dan predikat.</p></div>
            </div>
            <div class="rc-btns">
                <a href="{{ route('admin.laporan.nilai') }}" class="btn btn-view">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>Lihat
                </a>
                <a href="{{ route('admin.laporan.nilai.export.pdf') }}" class="btn btn-pdf" target="_blank">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>Export PDF
                </a>
                <a href="{{ route('admin.laporan.nilai.export.excel') }}" class="btn btn-excel">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>Export Excel
                </a>
            </div>
        </div>

        <div class="rc">
            <div class="rc-top">
                <div class="rc-ico ico-red"><svg width="22" height="22" fill="none" stroke="#dc2626" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg></div>
                <div><p class="rc-name">Laporan Pelanggaran</p><p class="rc-desc">Rekap kasus pelanggaran per kategori, kelas, dan periode. Sertakan total poin dan status penanganan.</p></div>
            </div>
            <div class="rc-btns">
                <a href="{{ route('admin.laporan.pelanggaran') }}" class="btn btn-view">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>Lihat
                </a>
                <a href="{{ route('admin.laporan.pelanggaran.export.pdf') }}" class="btn btn-pdf" target="_blank">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>Export PDF
                </a>
                <a href="{{ route('admin.laporan.pelanggaran.export.excel') }}" class="btn btn-excel">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>Export Excel
                </a>
            </div>
        </div>

        <div class="rc">
            <div class="rc-top">
                <div class="rc-ico ico-purple"><svg width="22" height="22" fill="none" stroke="#7c3aed" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
                <div><p class="rc-name">Laporan Data Siswa</p><p class="rc-desc">Rekap data lengkap siswa per kelas, tahun ajaran, dan jenis kelamin. Cocok untuk pelaporan ke dinas.</p></div>
            </div>
            <div class="rc-btns">
                <a href="{{ route('admin.laporan.siswa') }}" class="btn btn-view">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>Lihat
                </a>
                <a href="{{ route('admin.laporan.siswa.export.pdf') }}" class="btn btn-pdf" target="_blank">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>Export PDF
                </a>
                <a href="{{ route('admin.laporan.siswa.export.excel') }}" class="btn btn-excel">
                    <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/></svg>Export Excel
                </a>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });@endif
    @if(session('error'))Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });@endif
</script>
</x-app-layout>