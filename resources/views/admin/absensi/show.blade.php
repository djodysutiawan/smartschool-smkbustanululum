<x-app-layout>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
    :root {
        --brand:#1f63db;--brand-50:#eef6ff;--brand-100:#d9ebff;--brand-700:#1750c0;
        --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
        --border:#e2e8f0;--border2:#cbd5e1;--text:#0f172a;--text2:#475569;--text3:#94a3b8;
        --red:#dc2626;--red-bg:#fee2e2;--red-border:#fecaca;--radius:10px;--radius-sm:7px;
    }
    .page{padding:28px 28px 60px;max-width:2000px;margin:0 auto}
    .breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--text3);margin-bottom:20px}
    .breadcrumb a{color:var(--text3);text-decoration:none}.breadcrumb a:hover{color:var(--brand)}
    .breadcrumb .sep{color:var(--border2)}.breadcrumb .current{color:var(--text2)}
    .page-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap}
    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-back{padding:8px 14px;background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-back:hover{background:var(--surface3);filter:none}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-edit:hover{background:var(--brand-100);filter:none}
    .btn-del{background:#fff0f0;color:var(--red);border:1px solid var(--red-border)}
    .btn-del:hover{background:var(--red-bg);filter:none}
    .detail-grid{display:grid;grid-template-columns:2fr 1fr;gap:16px;align-items:start}
    .card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .card-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:8px}
    .card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .card-body{padding:20px}
    .dl-grid{display:grid;grid-template-columns:1fr 1fr;gap:0}
    .dl-item{padding:12px 0;border-bottom:1px solid var(--border)}
    .dl-item:nth-last-child(-n+2){border-bottom:none}
    .dl-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--text3);letter-spacing:.05em;text-transform:uppercase;margin-bottom:4px}
    .dl-val{font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text);font-weight:500}
    .dl-full{grid-column:span 2}
    .badge{display:inline-flex;align-items:center;gap:4px;padding:4px 12px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700}
    .badge-dot{width:6px;height:6px;border-radius:50%}
    .badge-hadir{background:#dcfce7;color:#15803d}.badge-hadir .badge-dot{background:#15803d}
    .badge-telat{background:#fefce8;color:#a16207}.badge-telat .badge-dot{background:#a16207}
    .badge-izin{background:#eff6ff;color:#1d4ed8}.badge-izin .badge-dot{background:#1d4ed8}
    .badge-sakit{background:#fdf4ff;color:#7c3aed}.badge-sakit .badge-dot{background:#7c3aed}
    .badge-alfa{background:#fee2e2;color:#dc2626}.badge-alfa .badge-dot{background:#dc2626}
    .surat-preview{border:1px solid var(--border);border-radius:var(--radius-sm);overflow:hidden;background:var(--surface2)}
    .surat-preview a{display:flex;align-items:center;gap:10px;padding:12px;text-decoration:none;color:var(--brand);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700}
    .surat-preview a:hover{background:var(--surface3)}
    @media(max-width:900px){.detail-grid{grid-template-columns:1fr}.page{padding:16px 16px 40px}}
</style>

<div class="page">
    <nav class="breadcrumb">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="sep">›</span>
        <a href="{{ route('admin.absensi.index') }}">Data Absensi</a>
        <span class="sep">›</span>
        <span class="current">Detail Absensi</span>
    </nav>

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Absensi</h1>
            <p class="page-sub">{{ $absensi->siswa->nama_lengkap ?? '—' }} — {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.absensi.edit', $absensi->id) }}" class="btn btn-edit">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <form action="{{ route('admin.absensi.destroy', $absensi->id) }}" method="POST" id="delForm">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete()">
                    <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/></svg>
                    Hapus
                </button>
            </form>
            <a href="{{ route('admin.absensi.index') }}" class="btn btn-back">
                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="detail-grid">
        <div>
            <div class="card">
                <div class="card-header">
                    <svg width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    <span class="card-title">Data Absensi</span>
                </div>
                <div class="card-body">
                    <div class="dl-grid">
                        <div class="dl-item">
                            <p class="dl-label">Nama Siswa</p>
                            <p class="dl-val">{{ $absensi->siswa->nama_lengkap ?? '—' }}</p>
                        </div>
                        <div class="dl-item">
                            <p class="dl-label">NIS</p>
                            <p class="dl-val">{{ $absensi->siswa->nis ?? '—' }}</p>
                        </div>
                        <div class="dl-item">
                            <p class="dl-label">Kelas</p>
                            <p class="dl-val">{{ $absensi->kelas->nama_kelas ?? '—' }}</p>
                        </div>
                        <div class="dl-item">
                            <p class="dl-label">Tanggal</p>
                            <p class="dl-val">{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d F Y') }}</p>
                        </div>
                        <div class="dl-item">
                            <p class="dl-label">Status Kehadiran</p>
                            <p class="dl-val">
                                <span class="badge badge-{{ $absensi->status }}">
                                    <span class="badge-dot"></span>{{ ucfirst($absensi->status) }}
                                </span>
                            </p>
                        </div>
                        <div class="dl-item">
                            <p class="dl-label">Metode</p>
                            {{-- FIX: enum('manual','qr') — bukan 'qr_code' --}}
                            <p class="dl-val">{{ $absensi->metode === 'qr' ? 'QR Code' : 'Manual' }}</p>
                        </div>
                        <div class="dl-item">
                            <p class="dl-label">Jam Masuk</p>
                            <p class="dl-val">{{ $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') : '—' }}</p>
                        </div>
                        <div class="dl-item">
                            <p class="dl-label">Jam Keluar</p>
                            <p class="dl-val">{{ $absensi->jam_keluar ? \Carbon\Carbon::parse($absensi->jam_keluar)->format('H:i') : '—' }}</p>
                        </div>
                        @if($absensi->jadwalPelajaran)
                        <div class="dl-item dl-full">
                            <p class="dl-label">Jadwal Pelajaran</p>
                            <p class="dl-val">
                                {{ $absensi->jadwalPelajaran->mataPelajaran->nama_mapel ?? '' }}
                                — {{ ucfirst($absensi->jadwalPelajaran->hari) }}
                                {{ $absensi->jadwalPelajaran->jam_mulai }}–{{ $absensi->jadwalPelajaran->jam_selesai }}
                            </p>
                        </div>
                        @endif
                        @if($absensi->keterangan)
                        <div class="dl-item dl-full">
                            <p class="dl-label">Keterangan</p>
                            <p class="dl-val">{{ $absensi->keterangan }}</p>
                        </div>
                        @endif
                        @if($absensi->path_surat_izin)
                        <div class="dl-item dl-full">
                            <p class="dl-label">Surat Izin / Keterangan</p>
                            <div class="surat-preview" style="margin-top:6px">
                                <a href="{{ asset('storage/'.$absensi->path_surat_izin) }}" target="_blank">
                                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                    Lihat Surat Keterangan
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="card">
                <div class="card-header">
                    <svg width="14" height="14" fill="none" stroke="#94a3b8" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    <span class="card-title">Informasi Pencatatan</span>
                </div>
                <div class="card-body">
                    <div style="display:flex;flex-direction:column;gap:12px">
                        <div>
                            <p class="dl-label">Dicatat Oleh</p>
                            <p class="dl-val">{{ $absensi->dicatatOleh->name ?? '—' }}</p>
                        </div>
                        <div>
                            <p class="dl-label">Dibuat</p>
                            <p class="dl-val">{{ $absensi->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="dl-label">Diperbarui</p>
                            <p class="dl-val">{{ $absensi->updated_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
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
    function confirmDelete() {
        Swal.fire({
            title:'Hapus Absensi?',
            text:'Data absensi ini akan dihapus permanen.',
            icon:'warning', showCancelButton:true,
            confirmButtonColor:'#dc2626', cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus!', cancelButtonText:'Batal',
        }).then(r => { if(r.isConfirmed) document.getElementById('delForm').submit(); });
    }
</script>
</x-app-layout>