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
    .page{padding:28px 28px 40px}
    .page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
    .page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text)}
    .page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
    .header-actions{display:flex;gap:8px;flex-wrap:wrap}

    .btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s,background .15s;white-space:nowrap}
    .btn:hover{filter:brightness(.93)}
    .btn-primary{background:var(--brand-600);color:#fff}
    .btn-secondary{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
    .btn-secondary:hover{background:var(--surface3);filter:none}
    .btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
    .btn-edit:hover{background:var(--brand-100);filter:none}
    .btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
    .btn-del:hover{background:#fee2e2;filter:none}

    .layout{display:grid;grid-template-columns:1fr 280px;gap:16px;align-items:start}

    .detail-card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
    .detail-card-header{padding:14px 20px;border-bottom:1px solid var(--border);background:var(--surface2);display:flex;align-items:center;gap:8px}
    .detail-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--text)}
    .detail-card-body{padding:20px}

    .info-grid{display:grid;grid-template-columns:1fr 1fr;gap:0}
    .info-row{display:flex;flex-direction:column;gap:3px;padding:12px 0;border-bottom:1px solid var(--surface3)}
    .info-row:last-child{border-bottom:none}
    .info-row.full{grid-column:span 2}
    .info-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em}
    .info-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:600;color:var(--text)}
    .info-val.muted{color:var(--text3);font-weight:400}

    .badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
    .badge-dot{width:5px;height:5px;border-radius:50%;flex-shrink:0}
    .badge-hadir{background:#dcfce7;color:#15803d} .badge-hadir .badge-dot{background:#15803d}
    .badge-telat{background:#fefce8;color:#a16207} .badge-telat .badge-dot{background:#a16207}
    .badge-izin {background:#eff6ff;color:#1d4ed8} .badge-izin  .badge-dot{background:#3b82f6}
    .badge-sakit{background:#fdf4ff;color:#7c3aed} .badge-sakit .badge-dot{background:#a855f7}
    .badge-alfa {background:#fee2e2;color:#dc2626} .badge-alfa  .badge-dot{background:#dc2626}
    .badge-manual{background:var(--surface3);color:var(--text2)} .badge-manual .badge-dot{background:var(--text3)}
    .badge-qr   {background:#ecfdf5;color:#065f46} .badge-qr    .badge-dot{background:#059669}

    .surat-box{display:flex;align-items:center;gap:12px;padding:12px 14px;background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm)}
    .surat-icon{width:40px;height:40px;background:var(--brand-50);border-radius:9px;display:flex;align-items:center;justify-content:center;flex-shrink:0}

    @media(max-width:900px){.layout{grid-template-columns:1fr}}
    @media(max-width:640px){.page{padding:16px}.info-grid{grid-template-columns:1fr}.info-row.full{grid-column:span 1}}
</style>

<div class="page">
    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Absensi</h1>
            <p class="page-sub">{{ $absensi->siswa->nama_lengkap ?? '—' }} — {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') }}</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('guru.absensi.index') }}" class="btn btn-secondary">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
            <a href="{{ route('guru.absensi.edit', $absensi->id) }}" class="btn btn-edit">Edit</a>
            <form action="{{ route('guru.absensi.destroy', $absensi->id) }}" method="POST" id="delForm" style="display:inline">
                @csrf @method('DELETE')
                <button type="button" class="btn btn-del" onclick="confirmDelete()">Hapus</button>
            </form>
        </div>
    </div>

    <div class="layout">
        <div>
            <div class="detail-card">
                <div class="detail-card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    <span class="detail-card-title">Informasi Absensi</span>
                </div>
                <div class="detail-card-body">
                    <div class="info-grid">
                        <div class="info-row">
                            <span class="info-label">Nama Siswa</span>
                            <span class="info-val">{{ $absensi->siswa->nama_lengkap ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">NIS</span>
                            <span class="info-val">{{ $absensi->siswa->nis ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Kelas</span>
                            <span class="info-val">{{ $absensi->kelas->nama_kelas ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Tanggal</span>
                            <span class="info-val">{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Status</span>
                            <span class="info-val">
                                <span class="badge badge-{{ $absensi->status }}">
                                    <span class="badge-dot"></span>{{ ucfirst($absensi->status) }}
                                </span>
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Metode</span>
                            <span class="info-val">
                                @if($absensi->metode === 'qr')
                                    <span class="badge badge-qr"><span class="badge-dot"></span>QR Code</span>
                                @elseif($absensi->metode === 'manual')
                                    <span class="badge badge-manual"><span class="badge-dot"></span>Manual</span>
                                @else
                                    <span class="info-val muted">—</span>
                                @endif
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Jam Masuk</span>
                            <span class="info-val {{ !$absensi->jam_masuk ? 'muted' : '' }}">{{ $absensi->jam_masuk ? \Carbon\Carbon::parse($absensi->jam_masuk)->format('H:i') : '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Jam Keluar</span>
                            <span class="info-val {{ !$absensi->jam_keluar ? 'muted' : '' }}">{{ $absensi->jam_keluar ? \Carbon\Carbon::parse($absensi->jam_keluar)->format('H:i') : '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Jadwal Pelajaran</span>
                            <span class="info-val {{ !$absensi->jadwalPelajaran ? 'muted' : '' }}">{{ $absensi->jadwalPelajaran->mataPelajaran->nama_mapel ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Dicatat Oleh</span>
                            <span class="info-val">{{ $absensi->dicatatOleh->name ?? '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Dicatat Pada</span>
                            <span class="info-val">{{ $absensi->created_at ? $absensi->created_at->format('d M Y, H:i') : '—' }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Terakhir Diperbarui</span>
                            <span class="info-val">{{ $absensi->updated_at ? $absensi->updated_at->format('d M Y, H:i') : '—' }}</span>
                        </div>
                        @if($absensi->keterangan)
                        <div class="info-row full">
                            <span class="info-label">Keterangan</span>
                            <span class="info-val" style="font-weight:400;font-family:'DM Sans',sans-serif;line-height:1.6">{{ $absensi->keterangan }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            @if($absensi->path_surat_izin)
            <div class="detail-card">
                <div class="detail-card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                    <span class="detail-card-title">Surat Izin</span>
                </div>
                <div class="detail-card-body">
                    <div class="surat-box">
                        <div class="surat-icon">
                            <svg width="18" height="18" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        </div>
                        <div style="flex:1;overflow:hidden">
                            <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">{{ basename($absensi->path_surat_izin) }}</p>
                            <p style="font-size:11.5px;color:var(--text3)">Surat izin ketidakhadiran</p>
                        </div>
                        <a href="{{ Storage::url($absensi->path_surat_izin) }}" target="_blank" class="btn btn-secondary" style="padding:5px 12px;font-size:12px">
                            <svg width="12" height="12" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
                            Buka
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>

        {{-- Sidebar --}}
        <div>
            <div class="detail-card">
                <div class="detail-card-header">
                    <svg width="14" height="14" fill="none" stroke="var(--brand-600)" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>
                    <span class="detail-card-title">Aksi Cepat</span>
                </div>
                <div class="detail-card-body" style="display:flex;flex-direction:column;gap:8px">
                    <a href="{{ route('guru.absensi.edit', $absensi->id) }}" class="btn btn-edit" style="width:100%;justify-content:center">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit Absensi
                    </a>
                    <button type="button" class="btn btn-del" style="width:100%;justify-content:center" onclick="confirmDelete()">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                        Hapus Absensi
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
@if(session('success'))
Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2800,showConfirmButton:false,toast:true,position:'top-end'});
@endif
function confirmDelete() {
    Swal.fire({
        title:'Hapus Absensi?',
        html:`Data absensi <strong>{{ addslashes($absensi->siswa->nama_lengkap ?? '') }}</strong> tanggal <strong>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') }}</strong> akan dihapus permanen.`,
        icon:'warning',showCancelButton:true,
        confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',
        confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal',
    }).then(r => { if(r.isConfirmed) document.getElementById('delForm').submit(); });
}
</script>
</x-app-layout>