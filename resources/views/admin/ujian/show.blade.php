<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand:#1f63db;--brand-h:#3582f0;--brand-soft:#eff6ff;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;
        --text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --green:#16a34a;--green-bg:#dcfce7;--green-border:#bbf7d0;
        --yellow:#d97706;--yellow-bg:#fef3c7;--yellow-border:#fde68a;
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;
        --purple:#7c3aed;--purple-bg:#ede9fe;
        --radius:12px;--radius-sm:8px;--radius-xs:6px;
    }
    *{box-sizing:border-box;}
    .page{padding:28px 28px 60px;max-width:1400px;margin:0 auto;}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px;}
    .breadcrumb a{color:var(--text3);text-decoration:none;}.breadcrumb a:hover{color:var(--brand);}
    .breadcrumb .sep{color:var(--border2);}.breadcrumb .current{color:var(--text2);}
    /* Header */
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:28px;flex-wrap:wrap;}
    .header-left{display:flex;align-items:flex-start;gap:14px;}
    .ujian-icon{width:52px;height:52px;border-radius:14px;background:var(--brand-soft);display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--text);line-height:1.25;margin-bottom:6px;}
    .badge-row{display:flex;align-items:center;gap:6px;flex-wrap:wrap;}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;}
    .badge-jenis{background:var(--purple-bg);color:var(--purple);}
    .badge-active{background:var(--green-bg);color:var(--green);}
    .badge-inactive{background:var(--surface3);color:var(--text3);}
    .badge-kelas{background:var(--brand-soft);color:var(--brand);}
    .header-actions{display:flex;align-items:center;gap:8px;flex-wrap:wrap;}
    /* Buttons */
    .btn{display:inline-flex;align-items:center;gap:6px;padding:9px 18px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:all .15s;white-space:nowrap;}
    .btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border);}
    .btn-back:hover{background:var(--surface3);}
    .btn-edit{background:var(--yellow-bg);color:var(--yellow);border:1px solid var(--yellow-border);}
    .btn-edit:hover{filter:brightness(.95);}
    .btn-delete{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border);}
    .btn-delete:hover{filter:brightness(.95);}
    .btn-primary{background:var(--brand);color:#fff;}
    .btn-primary:hover{background:var(--brand-h);}
    .btn-soal{background:var(--brand);color:#fff;padding:10px 22px;font-size:14px;}
    .btn-soal:hover{background:var(--brand-h);}
    /* Stats grid */
    .stats-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:14px;margin-bottom:24px;}
    .stat-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);padding:18px 20px;}
    .stat-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.06em;margin-bottom:8px;}
    .stat-value{font-family:'Plus Jakarta Sans',sans-serif;font-size:28px;font-weight:800;color:var(--text);line-height:1;}
    .stat-sub{font-size:12px;color:var(--text3);margin-top:4px;}
    .stat-card.green .stat-value{color:var(--green);}
    .stat-card.red .stat-value{color:var(--red);}
    .stat-card.brand .stat-value{color:var(--brand);}
    /* Main grid */
    .content-grid{display:grid;grid-template-columns:1fr 340px;gap:20px;}
    /* Cards */
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:20px;}
    .card-header{display:flex;align-items:center;justify-content:space-between;padding:16px 20px;border-bottom:1px solid var(--border);}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text);display:flex;align-items:center;gap:8px;}
    .card-body{padding:20px;}
    /* Soal section */
    .soal-header{display:flex;align-items:center;justify-content:space-between;padding:18px 24px;background:var(--surface2);border-bottom:1px solid var(--border);}
    .soal-header-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:800;color:var(--text);}
    .soal-header-sub{font-size:12.5px;color:var(--text3);margin-top:2px;}
    .soal-actions{display:flex;align-items:center;gap:8px;}
    /* Soal list */
    .soal-list{padding:0;}
    .soal-item{display:flex;align-items:flex-start;gap:14px;padding:16px 24px;border-bottom:1px solid var(--border);transition:background .12s;}
    .soal-item:last-child{border-bottom:none;}
    .soal-item:hover{background:var(--surface2);}
    .soal-nomor{width:36px;height:36px;border-radius:10px;background:var(--brand-soft);color:var(--brand);font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;}
    .soal-content{flex:1;min-width:0;}
    .soal-text{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);line-height:1.5;margin-bottom:6px;
        display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;}
    .soal-meta{display:flex;align-items:center;gap:8px;flex-wrap:wrap;}
    .soal-badge{display:inline-flex;align-items:center;gap:3px;padding:2px 8px;border-radius:99px;font-size:11px;font-weight:600;font-family:'Plus Jakarta Sans',sans-serif;}
    .sb-pg{background:var(--brand-soft);color:var(--brand);}
    .sb-essay{background:var(--purple-bg);color:var(--purple);}
    .sb-bs{background:var(--green-bg);color:var(--green);}
    .soal-bobot{font-size:11.5px;color:var(--text3);font-family:'DM Sans',sans-serif;}
    .soal-item-actions{display:flex;align-items:center;gap:4px;flex-shrink:0;}
    .icon-btn{width:30px;height:30px;border-radius:var(--radius-xs);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:background .12s;text-decoration:none;border:none;background:transparent;}
    .icon-btn:hover{background:var(--surface3);}
    .icon-btn.red:hover{background:var(--red-bg);color:var(--red);}
    .icon-btn.yellow:hover{background:var(--yellow-bg);color:var(--yellow);}
    /* Empty state */
    .empty-soal{padding:56px 24px;text-align:center;}
    .empty-icon{width:64px;height:64px;border-radius:18px;background:var(--surface3);display:flex;align-items:center;justify-content:center;margin:0 auto 16px;}
    .empty-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:700;color:var(--text);margin-bottom:6px;}
    .empty-sub{font-size:13px;color:var(--text3);margin-bottom:20px;}
    /* Info list */
    .info-list{display:flex;flex-direction:column;gap:0;}
    .info-row{display:flex;align-items:flex-start;gap:12px;padding:11px 0;border-bottom:1px solid var(--border);}
    .info-row:last-child{border-bottom:none;}
    .info-icon{width:30px;height:30px;border-radius:8px;background:var(--surface2);display:flex;align-items:center;justify-content:center;flex-shrink:0;color:var(--text3);}
    .info-key{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);margin-bottom:2px;}
    .info-val{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);}
    /* Toggle form */
    .toggle-form{display:inline;}
    /* Alert */
    .alert{display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-radius:var(--radius-sm);margin-bottom:20px;font-size:13.5px;}
    .alert-success{background:var(--green-bg);color:var(--green);border:1px solid var(--green-border);}
    .alert-error{background:var(--red-bg);color:var(--red);border:1px solid var(--red-border);}
    /* Progress bar */
    .progress-wrap{background:var(--surface3);border-radius:99px;height:6px;overflow:hidden;margin-top:6px;}
    .progress-fill{height:100%;border-radius:99px;background:var(--brand);}
    @media(max-width:1024px){.stats-grid{grid-template-columns:repeat(3,1fr);}.content-grid{grid-template-columns:1fr;}}
    @media(max-width:640px){.stats-grid{grid-template-columns:1fr 1fr;}.page{padding:16px;}.page-title{font-size:18px;}}
</style>

<div class="page">
    {{-- Breadcrumb --}}
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.ujian.index') }}">Data Ujian</a>
        <span class="sep">›</span>
        <span class="current">{{ Str::limit($ujian->judul, 40) }}</span>
    </nav>

    {{-- Alert --}}
    @if(session('success'))
    <div class="alert alert-success">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-error">
        <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
        {{ session('error') }}
    </div>
    @endif

    {{-- Page Header --}}
    <div class="page-header">
        <div class="header-left">
            <div class="ujian-icon">
                <svg width="24" height="24" fill="none" stroke="var(--brand)" stroke-width="1.8" viewBox="0 0 24 24"><path d="M9 11l3 3L22 4"/><path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/></svg>
            </div>
            <div>
                <h1 class="page-title">{{ $ujian->judul }}</h1>
                <div class="badge-row">
                    <span class="badge badge-jenis">{{ strtoupper(str_replace('_',' ',$ujian->jenis)) }}</span>
                    <span class="badge badge-kelas">{{ $ujian->kelas->nama_kelas ?? '-' }}</span>
                    @if($ujian->is_active)
                        <span class="badge badge-active">● Aktif</span>
                    @else
                        <span class="badge badge-inactive">○ Nonaktif</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.ujian.index') }}" class="btn btn-back">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('admin.ujian.edit', $ujian) }}" class="btn btn-edit">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form action="{{ route('admin.ujian.destroy', $ujian) }}" method="POST" class="toggle-form" id="formDelete">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-delete" onclick="confirmDelete()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
        <div class="stat-card brand">
            <div class="stat-label">Total Soal</div>
            <div class="stat-value">{{ $stats['total_soal'] }}</div>
            <div class="stat-sub">Bobot: {{ $stats['total_bobot'] }} poin</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Durasi</div>
            <div class="stat-value">{{ $ujian->durasi_menit }}'</div>
            <div class="stat-sub">menit</div>
        </div>
        <div class="stat-card green">
            <div class="stat-label">Siswa Selesai</div>
            <div class="stat-value">{{ $stats['siswa_selesai'] }}</div>
            <div class="stat-sub">Lulus: {{ $stats['siswa_lulus'] }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Rata-rata Nilai</div>
            <div class="stat-value">{{ $stats['rata_nilai'] }}</div>
            <div class="stat-sub">dari 100</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Nilai KKM</div>
            <div class="stat-value">{{ $ujian->nilai_kkm ?? '—' }}</div>
            <div class="stat-sub">batas kelulusan</div>
        </div>
    </div>

    <div class="content-grid">
        {{-- Kolom Kiri: Soal --}}
        <div>
            <div class="card">
                <div class="soal-header">
                    <div>
                        <div class="soal-header-title">Daftar Soal</div>
                        <div class="soal-header-sub">{{ $stats['total_soal'] }} soal · Total bobot {{ $stats['total_bobot'] }} poin</div>
                    </div>
                    <div class="soal-actions">
                        {{-- Export dropdown --}}
                        @if($stats['total_soal'] > 0)
                        <a href="{{ route('admin.ujian.soal.export.pdf', $ujian) }}" class="btn btn-back" style="font-size:12px;padding:7px 12px;">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Export PDF
                        </a>
                        @endif
                        {{-- ✅ TOMBOL UTAMA: Tambah Soal --}}
                        <a href="{{ route('admin.ujian.soal.create', $ujian) }}" class="btn btn-soal">
                            <svg width="15" height="15" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Tambah Soal
                        </a>
                    </div>
                </div>

                @if($ujian->soal->isEmpty())
                    <div class="empty-soal">
                        <div class="empty-icon">
                            <svg width="28" height="28" fill="none" stroke="var(--text3)" stroke-width="1.5" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="12" y1="18" x2="12" y2="12"/><line x1="9" y1="15" x2="15" y2="15"/></svg>
                        </div>
                        <div class="empty-title">Belum ada soal</div>
                        <div class="empty-sub">Tambahkan soal untuk ujian ini agar siswa bisa mengikutinya.</div>
                        <a href="{{ route('admin.ujian.soal.create', $ujian) }}" class="btn btn-soal" style="margin:0 auto;">
                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                            Tambah Soal Pertama
                        </a>
                    </div>
                @else
                    <div class="soal-list">
                        @foreach($ujian->soal->sortBy('nomor_soal') as $soal)
                        <div class="soal-item">
                            <div class="soal-nomor">{{ $soal->nomor_soal }}</div>
                            <div class="soal-content">
                                <div class="soal-text">{!! Str::limit(strip_tags($soal->pertanyaan), 120) !!}</div>
                                <div class="soal-meta">
                                    @if($soal->jenis_soal === 'pilihan_ganda')
                                        <span class="soal-badge sb-pg">PG · {{ $soal->pilihan->count() }} opsi</span>
                                    @elseif($soal->jenis_soal === 'essay')
                                        <span class="soal-badge sb-essay">Essay</span>
                                    @else
                                        <span class="soal-badge sb-bs">Benar/Salah</span>
                                    @endif
                                    <span class="soal-bobot">Bobot: {{ $soal->bobot }} poin</span>
                                    @if($soal->gambar_soal)
                                        <span class="soal-badge" style="background:var(--surface3);color:var(--text3);">
                                            <svg width="10" height="10" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><polyline points="21 15 16 10 5 21"/></svg>
                                            Gambar
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="soal-item-actions">
                                <a href="{{ route('admin.ujian.soal.edit', [$ujian, $soal]) }}" class="icon-btn yellow" title="Edit Soal">
                                    <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                                </a>
                                <form action="{{ route('admin.ujian.soal.destroy', [$ujian, $soal]) }}" method="POST" style="display:inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="icon-btn red" title="Hapus Soal"
                                        onclick="return confirm('Hapus soal no. {{ $soal->nomor_soal }}?')">
                                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/></svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Footer soal: link ke halaman soal penuh --}}
                    <div style="padding:14px 24px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;background:var(--surface2);">
                        <span style="font-size:12.5px;color:var(--text3);">Menampilkan {{ $ujian->soal->count() }} soal</span>
                        <a href="{{ route('admin.ujian.soal.index', $ujian) }}" class="btn btn-back" style="font-size:12.5px;padding:7px 14px;">
                            Kelola Semua Soal →
                        </a>
                    </div>
                @endif
            </div>
        </div>

        {{-- Kolom Kanan: Info --}}
        <div>
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        Informasi Ujian
                    </span>
                </div>
                <div class="card-body" style="padding:16px 20px;">
                    <div class="info-list">
                        <div class="info-row">
                            <div class="info-icon"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg></div>
                            <div><div class="info-key">Guru</div><div class="info-val">{{ $ujian->guru->nama_lengkap ?? '-' }}</div></div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg></div>
                            <div><div class="info-key">Mata Pelajaran</div><div class="info-val">{{ $ujian->mataPelajaran->nama_mapel ?? '-' }}</div></div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg></div>
                            <div>
                                <div class="info-key">Tanggal</div>
                                <div class="info-val">{{ $ujian->tanggal ? $ujian->tanggal->translatedFormat('d F Y') : '-' }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg></div>
                            <div>
                                <div class="info-key">Jam Mulai</div>
                                <div class="info-val">{{ $ujian->jam_mulai ?? 'Tidak ditentukan' }}</div>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 2v4M12 18v4M4.93 4.93l2.83 2.83M16.24 16.24l2.83 2.83M2 12h4M18 12h4"/></svg></div>
                            <div><div class="info-key">Tahun Ajaran</div><div class="info-val">{{ $ujian->tahunAjaran->tahun ?? '-' }}</div></div>
                        </div>
                        <div class="info-row">
                            <div class="info-icon"><svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93A10 10 0 0 0 2 12a10 10 0 0 0 17.07 7.07"/></svg></div>
                            <div>
                                <div class="info-key">Maks. Percobaan</div>
                                <div class="info-val">{{ $ujian->maks_percobaan ?? 1 }}×</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pengaturan --}}
            <div class="card">
                <div class="card-header">
                    <span class="card-title">
                        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93A10 10 0 0 0 2 12a10 10 0 0 0 17.07 7.07"/></svg>
                        Pengaturan
                    </span>
                </div>
                <div class="card-body" style="padding:16px 20px;display:flex;flex-direction:column;gap:10px;">
                    @php
                        $settings = [
                            ['label' => 'Acak Urutan Soal',     'val' => $ujian->acak_soal],
                            ['label' => 'Acak Pilihan Jawaban', 'val' => $ujian->acak_pilihan],
                            ['label' => 'Tampilkan Nilai',      'val' => $ujian->tampilkan_nilai],
                            ['label' => 'Ujian Aktif',          'val' => $ujian->is_active],
                        ];
                    @endphp
                    @foreach($settings as $s)
                    <div style="display:flex;align-items:center;justify-content:space-between;">
                        <span style="font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text2);">{{ $s['label'] }}</span>
                        @if($s['val'])
                            <span style="font-size:11.5px;font-weight:700;color:var(--green);background:var(--green-bg);padding:2px 10px;border-radius:99px;">Ya</span>
                        @else
                            <span style="font-size:11.5px;font-weight:700;color:var(--text3);background:var(--surface3);padding:2px 10px;border-radius:99px;">Tidak</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Keterangan --}}
            @if($ujian->keterangan)
            <div class="card">
                <div class="card-header">
                    <span class="card-title">Keterangan</span>
                </div>
                <div class="card-body">
                    <p style="font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text2);line-height:1.6;margin:0;">{{ $ujian->keterangan }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete() {
    Swal.fire({
        title: 'Hapus Ujian?',
        html: 'Semua soal dan sesi ujian terkait akan ikut terhapus.<br><strong>Tindakan ini tidak dapat diurungkan.</strong>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#64748b',
    }).then(r => { if(r.isConfirmed) document.getElementById('formDelete').submit(); });
}
@if(session('success'))
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),confirmButtonColor:'#1f63db',timer:3000,timerProgressBar:true});
@endif
</script>
</x-app-layout>