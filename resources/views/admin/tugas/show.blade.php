<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand: #1f63db; --brand-700: #1750c0; --brand-50: #eef6ff; --brand-100: #d9ebff;
        --surface: #fff; --surface2: #f8fafc; --surface3: #f1f5f9;
        --border: #e2e8f0; --border2: #cbd5e1;
        --text: #0f172a; --text2: #475569; --text3: #94a3b8;
        --radius: 10px; --radius-sm: 7px;
    }
    .page { padding: 28px 28px 60px; max-width: 2000px; margin: 0 auto; }
    .breadcrumb { display: flex; align-items: center; gap: 6px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 600; color: var(--text3); margin-bottom: 20px; }
    .breadcrumb a { color: var(--text3); text-decoration: none; }
    .breadcrumb a:hover { color: var(--brand); }
    .breadcrumb .sep { color: var(--border2); }
    .breadcrumb .current { color: var(--text2); }
    .page-header { display: flex; align-items: flex-start; justify-content: space-between; gap: 16px; margin-bottom: 24px; flex-wrap: wrap; }
    .page-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 20px; font-weight: 800; color: var(--text); }
    .page-sub   { font-size: 12.5px; color: var(--text3); margin-top: 3px; }
    .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 13px; font-weight: 700; cursor: pointer; border: none; text-decoration: none; transition: filter .15s; white-space: nowrap; }
    .btn-back { background: var(--surface2); color: var(--text2); border: 1px solid var(--border); }
    .btn-back:hover { background: var(--surface3); }
    .btn-edit { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .btn-edit:hover { background: var(--brand-100); }
    .btn-del  { background: #fff0f0; color: #dc2626; border: 1px solid #fecaca; }
    .btn-del:hover  { background: #fee2e2; }
    .btn-sm { padding: 5px 10px; font-size: 11.5px; border-radius: 6px; }

    .stats-strip { display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px; margin-bottom: 16px; }
    .stat-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); padding: 14px 18px; display: flex; align-items: center; gap: 12px; }
    .stat-icon { width: 38px; height: 38px; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .stat-icon.blue   { background: var(--brand-50); }
    .stat-icon.green  { background: #f0fdf4; }
    .stat-icon.orange { background: #fff7ed; }
    .stat-label { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 600; color: var(--text3); text-transform: uppercase; letter-spacing: .03em; }
    .stat-val   { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 22px; font-weight: 800; color: var(--text); line-height: 1.1; margin-top: 1px; }

    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
    .detail-card { background: var(--surface); border: 1px solid var(--border); border-radius: var(--radius); overflow: hidden; }
    .detail-header { padding: 14px 20px; border-bottom: 1px solid var(--border); background: var(--surface2); display: flex; align-items: center; justify-content: space-between; }
    .detail-header-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .05em; display: flex; align-items: center; gap: 7px; }
    .detail-body { padding: 20px; }
    .dl { display: grid; grid-template-columns: 150px 1fr; gap: 10px 16px; }
    .dl dt { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text3); align-self: start; padding-top: 1px; }
    .dl dd { font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text); margin: 0; }

    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 3px 10px; border-radius: 99px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; white-space: nowrap; }
    .badge-dot { width: 5px; height: 5px; border-radius: 50%; }
    .badge-publish { background: #dcfce7; color: #15803d; } .badge-publish .badge-dot { background: #15803d; }
    .badge-draft   { background: #f1f5f9; color: #64748b; } .badge-draft .badge-dot   { background: #64748b; }

    .jenis-pill { display: inline-block; padding: 2px 9px; border-radius: 5px; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12px; font-weight: 700; }
    .jenis-file  { background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); }
    .jenis-teks  { background: #f0fdf4; color: #15803d; border: 1px solid #bbf7d0; }
    .jenis-link  { background: #fdf4ff; color: #7c3aed; border: 1px solid #e9d5ff; }
    .jenis-foto  { background: #fff7ed; color: #c2410c; border: 1px solid #fed7aa; }

    .deskripsi-box { background: var(--surface2); border: 1px solid var(--border); border-radius: var(--radius-sm); padding: 14px 16px; font-family: 'DM Sans', sans-serif; font-size: 13.5px; color: var(--text2); line-height: 1.7; white-space: pre-wrap; }
    .file-link { display: inline-flex; align-items: center; gap: 6px; padding: 6px 12px; background: var(--brand-50); color: var(--brand-700); border: 1px solid var(--brand-100); border-radius: var(--radius-sm); font-family: 'Plus Jakarta Sans', sans-serif; font-size: 12.5px; font-weight: 700; text-decoration: none; }
    .file-link:hover { background: var(--brand-100); }
    .deadline-text { font-size: 13.5px; font-family: 'DM Sans', sans-serif; }
    .deadline-text.lewat { color: #dc2626; font-weight: 600; }

    table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    thead tr { background: var(--surface2); border-bottom: 1px solid var(--border); }
    thead th { padding: 10px 14px; text-align: left; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11.5px; font-weight: 700; color: var(--text3); text-transform: uppercase; letter-spacing: .05em; white-space: nowrap; }
    tbody tr { border-bottom: 1px solid #f1f5f9; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #fafbff; }
    td { padding: 10px 14px; color: var(--text); vertical-align: middle; }

    @media (max-width: 860px) { .grid-2 { grid-template-columns: 1fr; } .stats-strip { grid-template-columns: 1fr 1fr; } }
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.tugas.index') }}">Manajemen Tugas</a>
        <span class="sep">›</span>
        <span class="current">Detail Tugas</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">{{ $tugas->judul }}</h1>
            <p class="page-sub">{{ $tugas->kelas->nama_kelas ?? '-' }} · {{ $tugas->mataPelajaran->nama_mapel ?? '-' }} · {{ $tugas->tahunAjaran->tahun ?? '-' }}</p>
        </div>
        <div style="display:flex;gap:8px;flex-wrap:wrap">
            <a href="{{ route('admin.tugas.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.tugas.edit', $tugas->id) }}" class="btn btn-edit">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit Tugas
            </a>
            <form action="{{ route('admin.tugas.destroy', $tugas->id) }}" method="POST" id="deleteForm">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del"
                    onclick="confirmDelete(document.getElementById('deleteForm'), '{{ addslashes($tugas->judul) }}')">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                    Hapus
                </button>
            </form>
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
                <svg width="18" height="18" fill="none" stroke="#15803d" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><polyline points="16 13 12 17 8 13"/><line x1="12" y1="17" x2="12" y2="9"/></svg>
            </div>
            <div><p class="stat-label">Terkumpul</p><p class="stat-val">{{ $stats['terkumpul'] }}</p></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="18" height="18" fill="none" stroke="#c2410c" stroke-width="1.8" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
            </div>
            <div><p class="stat-label">Sudah Dinilai</p><p class="stat-val">{{ $stats['sudah_dinilai'] }}</p></div>
        </div>
    </div>

    <div class="grid-2" style="margin-bottom:16px">
        <div class="detail-card">
            <div class="detail-header">
                <p class="detail-header-title">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    Informasi Tugas
                </p>
            </div>
            <div class="detail-body">
                <dl class="dl">
                    <dt>Guru</dt>
                    <dd>{{ $tugas->guru->nama_lengkap ?? '-' }}</dd>

                    <dt>Mata Pelajaran</dt>
                    <dd>{{ $tugas->mataPelajaran->nama_mapel ?? '-' }}</dd>

                    <dt>Kelas</dt>
                    <dd>{{ $tugas->kelas->nama_kelas ?? '-' }}</dd>

                    <dt>Tahun Ajaran</dt>
                    <dd>{{ $tugas->tahunAjaran->tahun ?? '-' }}</dd>

                    <dt>Jenis Pengumpulan</dt>
                    <dd><span class="jenis-pill jenis-{{ $tugas->jenis_pengumpulan }}">{{ ucfirst($tugas->jenis_pengumpulan) }}</span></dd>

                    <dt>Batas Waktu</dt>
                    <dd>
                        <span class="deadline-text {{ now()->gt($tugas->batas_waktu) ? 'lewat' : '' }}">
                            {{ \Carbon\Carbon::parse($tugas->batas_waktu)->format('d M Y, H:i') }}
                            @if(now()->gt($tugas->batas_waktu))
                                <span style="margin-left:6px;font-size:11.5px;background:#fee2e2;color:#dc2626;padding:1px 7px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">Lewat</span>
                            @endif
                        </span>
                    </dd>

                    <dt>Nilai Maksimal</dt>
                    <dd>{{ $tugas->nilai_maksimal ?? 100 }}</dd>

                    <dt>Izin Terlambat</dt>
                    <dd>{{ $tugas->izinkan_terlambat ? 'Ya' : 'Tidak' }}</dd>

                    <dt>Status</dt>
                    <dd>
                        @if($tugas->dipublikasikan)
                            <span class="badge badge-publish"><span class="badge-dot"></span>Dipublikasikan</span>
                        @else
                            <span class="badge badge-draft"><span class="badge-dot"></span>Draft</span>
                        @endif
                    </dd>

                    <dt>Dibuat</dt>
                    <dd style="color:var(--text3);font-size:12.5px">{{ $tugas->created_at->format('d M Y, H:i') }}</dd>

                    @if($tugas->path_file_soal)
                    <dt>File Soal</dt>
                    <dd>
                        <a href="{{ asset('storage/'.$tugas->path_file_soal) }}" target="_blank" class="file-link">
                            <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            Unduh File Soal
                        </a>
                    </dd>
                    @endif
                </dl>
            </div>
        </div>

        <div class="detail-card">
            <div class="detail-header">
                <p class="detail-header-title">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><line x1="21" y1="10" x2="3" y2="10"/><line x1="21" y1="6" x2="3" y2="6"/><line x1="21" y1="14" x2="3" y2="14"/><line x1="21" y1="18" x2="3" y2="18"/></svg>
                    Deskripsi / Instruksi Tugas
                </p>
            </div>
            <div class="detail-body">
                @if($tugas->deskripsi)
                    <div class="deskripsi-box">{{ $tugas->deskripsi }}</div>
                @else
                    <p style="color:var(--text3);font-size:13px;font-style:italic">Tidak ada deskripsi yang ditambahkan.</p>
                @endif
            </div>
        </div>
    </div>

    <div class="detail-card">
        <div class="detail-header">
            <p class="detail-header-title">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                Daftar Pengumpulan Siswa
            </p>
            <a href="{{ route('admin.pengumpulan-tugas.index') }}?tugas_id={{ $tugas->id }}" class="btn btn-sm" style="background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)">
                Lihat Semua
            </a>
        </div>
        <div style="overflow-x:auto">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Dikumpulkan Pada</th>
                        <th>Status</th>
                        <th>Nilai</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tugas->pengumpulan as $i => $p)
                    <tr>
                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--text3)">{{ $i + 1 }}</td>
                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px">{{ $p->siswa->nama_lengkap ?? '-' }}</td>
                        <td style="color:var(--text3);font-size:12.5px">{{ $p->siswa->kelas->nama_kelas ?? '-' }}</td>
                        <td style="color:var(--text2);font-size:12.5px">{{ $p->created_at->format('d M Y, H:i') }}</td>
                        <td>
                            @php
                                $stColor = match($p->status) {
                                    'dinilai'   => ['bg'=>'#dcfce7','c'=>'#15803d'],
                                    'terkumpul' => ['bg'=>'#dbeafe','c'=>'#1d4ed8'],
                                    'terlambat' => ['bg'=>'#fee2e2','c'=>'#dc2626'],
                                    default     => ['bg'=>'#f1f5f9','c'=>'#64748b'],
                                };
                            @endphp
                            <span style="display:inline-block;padding:2px 9px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;background:{{ $stColor['bg'] }};color:{{ $stColor['c'] }}">
                                {{ ucfirst(str_replace('_', ' ', $p->status)) }}
                            </span>
                        </td>
                        <td style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700">{{ $p->nilai ?? '—' }}</td>
                        <td>
                            <a href="{{ route('admin.pengumpulan-tugas.show', $p->id) }}" class="btn btn-sm" style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0">Detail</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center;padding:40px;color:var(--text3);font-size:13px">
                            Belum ada siswa yang mengumpulkan tugas ini
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

    function confirmDelete(form, nama) {
        Swal.fire({
            title: 'Hapus Tugas?', text: `Tugas "${nama}" akan dihapus (bisa dipulihkan).`,
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#dc2626', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then(r => { if (r.isConfirmed) form.submit(); });
    }
</script>
</x-app-layout>