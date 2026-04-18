<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand:#1f63db;--brand-h:#3582f0;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 60px;max-width:2000px;}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;}
    .breadcrumb a{color:var(--text3);text-decoration:none;}.breadcrumb a:hover{color:var(--brand);}
    .breadcrumb .sep{color:var(--border2);}.breadcrumb .current{color:var(--text2);}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px;}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap;}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap;}
    .btn:hover{filter:brightness(.93);}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}.btn-back:hover{background:var(--surface3);filter:none;}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100);}.btn-edit:hover{background:var(--brand-100);filter:none;}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca;}.btn-del:hover{background:#fee2e2;filter:none;}
    .stats-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:14px 18px;display:flex;align-items:center;gap:12px;}
    .stat-icon{width:38px;height:38px;border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .stat-icon.blue{background:var(--brand-50);}.stat-icon.green{background:#f0fdf4;}.stat-icon.red{background:#fff0f0;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:600;color:var(--text3);letter-spacing:.03em;text-transform:uppercase;}
    .stat-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.1;margin-top:1px;}
    .layout-2col{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
    .detail-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px;}
    .detail-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px;}
    .detail-header-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text);}
    .detail-item{padding:12px 20px;border-bottom:1px solid var(--border);display:flex;flex-direction:column;gap:4px;}
    .detail-item:last-child{border-bottom:none;}
    .detail-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;}
    .detail-value{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);font-weight:500;}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;}
    .badge-dot{width:5px;height:5px;border-radius:50%;}
    .badge-aktif{background:#dcfce7;color:#15803d;}.badge-aktif .badge-dot{background:#15803d;}
    .badge-nonaktif{background:#f1f5f9;color:#64748b;}.badge-nonaktif .badge-dot{background:#94a3b8;}
    .siswa-table{width:100%;border-collapse:collapse;font-size:13px;}
    .siswa-table thead tr{background:var(--surface2);border-bottom:1px solid var(--border);}
    .siswa-table thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;}
    .siswa-table tbody tr{border-bottom:1px solid #f1f5f9;}
    .siswa-table tbody tr:last-child{border-bottom:none;}
    .siswa-table td{padding:9px 14px;color:var(--text);}
    .kapasitas-bar{width:100%;height:8px;background:var(--surface3);border-radius:99px;overflow:hidden;margin-top:8px;}
    .kapasitas-fill{height:100%;border-radius:99px;}
    .jadwal-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;}
    .jadwal-table{width:100%;border-collapse:collapse;font-size:13px;}
    .jadwal-table thead tr{background:var(--surface2);border-bottom:1px solid var(--border);}
    .jadwal-table thead th{padding:10px 14px;text-align:left;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.05em;}
    .jadwal-table tbody tr{border-bottom:1px solid #f1f5f9;}
    .jadwal-table tbody tr:last-child{border-bottom:none;}
    .jadwal-table td{padding:9px 14px;color:var(--text);}
    @media(max-width:768px){.layout-2col{grid-template-columns:1fr;}.stats-strip{grid-template-columns:1fr 1fr;}.page{padding:16px;}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.kelas.index') }}">Data Kelas</a>
        <span class="sep">›</span>
        <span class="current">{{ $kelas->nama_kelas }}</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">
                {{ $kelas->nama_kelas }}
                @if($stats['sudah_penuh'])
                <span style="display:inline-block;background:#dc2626;color:#fff;font-size:10px;font-weight:800;padding:2px 8px;border-radius:5px;margin-left:6px;font-family:'Plus Jakarta Sans',sans-serif;vertical-align:middle;">PENUH</span>
                @endif
            </h1>
            <p class="page-sub">{{ $kelas->kode_kelas }} — {{ $kelas->tahunAjaran->tahun ?? '' }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.kelas.edit', $kelas->id) }}" class="btn btn-edit">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form action="{{ route('admin.kelas.destroy', $kelas->id) }}" method="POST" id="delForm" style="display:inline;">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del"
                    onclick="confirmDelete(document.getElementById('delForm'), '{{ addslashes($kelas->nama_kelas) }}')">
                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                    Hapus
                </button>
            </form>
            <a href="{{ route('admin.kelas.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="stats-strip">
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="18" height="18" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
            </div>
            <div><p class="stat-label">Total Siswa</p><p class="stat-val">{{ $stats['total_siswa'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div><p class="stat-label">Sisa Kapasitas</p><p class="stat-val">{{ $stats['sisa_kapasitas'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon {{ $stats['sudah_penuh'] ? 'red' : 'blue' }}">
                <svg width="18" height="18" fill="none" stroke="{{ $stats['sudah_penuh'] ? '#dc2626' : '#1f63db' }}" stroke-width="1.8" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><path d="M3 9h18M9 21V9"/></svg>
            </div>
            <div><p class="stat-label">Kapasitas Maks</p><p class="stat-val">{{ $kelas->kapasitas_maks }}</p></div>
        </div>
    </div>

    @php
        $pct = $kelas->kapasitas_maks > 0 ? min(100, round($stats['total_siswa'] / $kelas->kapasitas_maks * 100)) : 0;
        $barColor = $pct >= 100 ? '#dc2626' : ($pct >= 80 ? '#f97316' : '#22c55e');
    @endphp
    <div style="background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:16px 20px;margin-bottom:16px;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text2);">Kapasitas Kelas</span>
            <span style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;color:var(--text);">{{ $stats['total_siswa'] }}/{{ $kelas->kapasitas_maks }} siswa ({{ $pct }}%)</span>
        </div>
        <div class="kapasitas-bar"><div class="kapasitas-fill" style="width:{{ $pct }}%;background:{{ $barColor }};"></div></div>
    </div>

    <div class="layout-2col">
        <div>
            <div class="detail-card">
                <div class="detail-header">
                    <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/></svg>
                    <p class="detail-header-title">Informasi Kelas</p>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Nama Kelas</span>
                    <span class="detail-value" style="font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;">{{ $kelas->nama_kelas }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Kode Kelas</span>
                    <span class="detail-value">{{ $kelas->kode_kelas }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Tingkat</span>
                    <span class="detail-value">{{ $kelas->tingkat }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Jurusan</span>
                    <span class="detail-value">{{ $kelas->jurusan ?? '—' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Status</span>
                    <span class="detail-value">
                        @if($kelas->status === 'aktif')
                            <span class="badge badge-aktif"><span class="badge-dot"></span>Aktif</span>
                        @else
                            <span class="badge badge-nonaktif"><span class="badge-dot"></span>Tidak Aktif</span>
                        @endif
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Tahun Ajaran</span>
                    <span class="detail-value">{{ $kelas->tahunAjaran->tahun ?? '—' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Wali Kelas</span>
                    <span class="detail-value">{{ $kelas->waliKelas->nama_lengkap ?? '—' }}</span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Ruang</span>
                    <span class="detail-value">
                        @if($kelas->ruang)
                            {{ $kelas->ruang->nama_ruang }}
                            <span style="color:var(--text3);font-size:12px;"> — {{ $kelas->ruang->gedung->nama_gedung ?? '' }}</span>
                        @else —
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <div>
            <div class="detail-card">
                <div class="detail-header">
                    <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    <p class="detail-header-title">Daftar Siswa <span style="font-weight:400;color:var(--text3);">({{ $kelas->siswa->count() }})</span></p>
                </div>
                @if($kelas->siswa->count())
                <div style="overflow-x:auto;">
                    <table class="siswa-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>NIS</th>
                                <th>Nama</th>
                                <th>L/P</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kelas->siswa as $i => $s)
                            <tr>
                                <td style="color:var(--text3);font-size:12px;">{{ $i + 1 }}</td>
                                <td style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;color:var(--text3);">{{ $s->nis }}</td>
                                <td style="font-weight:600;font-size:13px;">{{ $s->nama_lengkap }}</td>
                                <td style="font-size:12px;color:var(--text3);">{{ $s->jenis_kelamin }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div style="padding:32px 20px;text-align:center;color:var(--text3);font-size:13px;">Belum ada siswa di kelas ini.</div>
                @endif
            </div>
        </div>
    </div>

    @if($kelas->jadwalPelajaran->count())
    <div class="jadwal-card">
        <div class="detail-header">
            <svg width="15" height="15" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            <p class="detail-header-title">Jadwal Pelajaran <span style="font-weight:400;color:var(--text3);">({{ $kelas->jadwalPelajaran->count() }})</span></p>
        </div>
        <div style="overflow-x:auto;">
            <table class="jadwal-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru</th>
                        <th>Hari</th>
                        <th>Jam</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kelas->jadwalPelajaran as $i => $j)
                    <tr>
                        <td style="color:var(--text3);font-size:12px;">{{ $i + 1 }}</td>
                        <td style="font-weight:600;">{{ $j->mataPelajaran->nama_mapel ?? '—' }}</td>
                        <td style="font-size:12.5px;color:var(--text2);">{{ $j->guru->nama_lengkap ?? '—' }}</td>
                        <td style="font-size:12.5px;">{{ $j->hari ?? '—' }}</td>
                        <td style="font-size:12.5px;color:var(--text3);">{{ $j->jam_mulai ?? '' }} – {{ $j->jam_selesai ?? '' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({ icon:'success', title:'Berhasil!', text:@json(session('success')), timer:2500, showConfirmButton:false, toast:true, position:'top-end' });
    @endif
    @if(session('error'))
    Swal.fire({ icon:'error', title:'Gagal!', text:@json(session('error')), confirmButtonColor:'#1f63db' });
    @endif

    function confirmDelete(form, nama) {
        Swal.fire({
            title: 'Hapus Kelas?',
            text: `Kelas "${nama}" akan dihapus permanen. Pastikan tidak ada siswa di dalamnya.`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>