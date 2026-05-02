<x-app-layout>
<style>
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap');
:root{
    --brand-700:#1750c0;--brand-600:#1f63db;--brand-500:#3582f0;
    --brand-100:#d9ebff;--brand-50:#eef6ff;
    --surface:#fff;--surface2:#f8fafc;--surface3:#f1f5f9;
    --border:#e2e8f0;--border2:#cbd5e1;
    --text:#0f172a;--text2:#475569;--text3:#94a3b8;
    --radius:10px;--radius-sm:7px;--danger:#dc2626;
}
.page{padding:28px 28px 40px}
.page-header{display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;flex-wrap:wrap}
.page-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;color:var(--text);line-height:1.2}
.page-sub{font-size:12.5px;color:var(--text3);margin-top:3px}
.header-actions{display:flex;gap:8px;flex-wrap:wrap}

.btn{display:inline-flex;align-items:center;gap:6px;padding:8px 16px;border-radius:var(--radius-sm);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;border:none;text-decoration:none;transition:filter .15s;white-space:nowrap}
.btn:hover{filter:brightness(.93)}
.btn-primary{background:var(--brand-600);color:#fff}
.btn-back{background:var(--surface2);color:var(--text2);border:1px solid var(--border)}
.btn-back:hover{background:var(--surface3);filter:none}
.btn-edit{background:var(--brand-50);color:var(--brand-700);border:1px solid var(--brand-100)}
.btn-del{background:#fff0f0;color:#dc2626;border:1px solid #fecaca}
.btn-toggle-on{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
.btn-toggle-off{background:#fef9c3;color:#a16207;border:1px solid #fde68a}

.detail-grid{display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start}

.card{background:var(--surface);border:1px solid var(--border);border-radius:var(--radius);overflow:hidden;margin-bottom:16px}
.card:last-child{margin-bottom:0}
.card-header{padding:14px 20px;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px}
.card-header-icon{width:32px;height:32px;border-radius:8px;background:var(--brand-50);display:flex;align-items:center;justify-content:center}
.card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--text)}
.card-body{padding:20px}

.detail-hero{width:100%;border-radius:var(--radius-sm);overflow:hidden;margin-bottom:20px;border:1px solid var(--border)}
.detail-hero img{width:100%;display:block;max-height:340px;object-fit:cover}

.dl-grid{display:grid;grid-template-columns:1fr 1fr;gap:0}
.dl-item{padding:12px 0;border-bottom:1px solid var(--surface3)}
.dl-item:nth-child(odd){padding-right:16px}
.dl-item:last-child,.dl-item:nth-last-child(2):nth-child(odd){border-bottom:none}
.dl-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--text3);text-transform:uppercase;letter-spacing:.04em;margin-bottom:4px}
.dl-value{font-family:'DM Sans',sans-serif;font-size:13.5px;color:var(--text);font-weight:500}

.dl-full{grid-column:1/-1}

.tingkat-pill{display:inline-block;padding:3px 12px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700}
.tingkat-sekolah{background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0}
.tingkat-kecamatan{background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe}
.tingkat-kabupaten{background:#faf5ff;color:#7c3aed;border:1px solid #e9d5ff}
.tingkat-provinsi{background:#fff7ed;color:#c2410c;border:1px solid #fed7aa}
.tingkat-nasional{background:#fef9c3;color:#a16207;border:1px solid #fde68a}
.tingkat-internasional{background:#fdf2f8;color:#be185d;border:1px solid #fbcfe8}

.badge{display:inline-flex;align-items:center;gap:4px;padding:3px 10px;border-radius:99px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700}
.badge-dot{width:5px;height:5px;border-radius:50%}
.badge-published{background:#dcfce7;color:#15803d}.badge-published .badge-dot{background:#15803d}
.badge-draft{background:#fee2e2;color:#dc2626}.badge-draft .badge-dot{background:#dc2626}
.badge-featured{background:#fef9c3;color:#a16207}.badge-featured .badge-dot{background:#a16207}

.deskripsi-box{background:var(--surface2);border:1px solid var(--border);border-radius:var(--radius-sm);padding:16px;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text2);line-height:1.7;white-space:pre-wrap}

.sertif-link{display:inline-flex;align-items:center;gap:8px;padding:10px 16px;border:1px solid var(--border);border-radius:var(--radius-sm);background:var(--surface2);text-decoration:none;color:var(--text2);font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;transition:all .15s}
.sertif-link:hover{background:var(--brand-50);border-color:var(--brand-100);color:var(--brand-700)}

.meta-row{display:flex;align-items:center;justify-content:space-between;padding:10px 0;border-bottom:1px solid var(--surface3)}
.meta-row:last-child{border-bottom:none;padding-bottom:0}
.meta-row:first-child{padding-top:0}
.meta-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--text3)}
.meta-value{font-family:'DM Sans',sans-serif;font-size:13px;color:var(--text);font-weight:500}

.action-danger-zone{border:1px solid #fecaca;border-radius:var(--radius-sm);padding:14px;background:#fff5f5}
.action-danger-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--danger);margin-bottom:10px}

@media(max-width:900px){.detail-grid{grid-template-columns:1fr}.dl-grid{grid-template-columns:1fr}.page{padding:16px}}
</style>

<div class="page">

    <div class="page-header">
        <div>
            <h1 class="page-title">Detail Prestasi</h1>
            <p class="page-sub">Informasi lengkap data prestasi</p>
        </div>
        <div class="header-actions">
            <a href="{{ route('admin.prestasi.edit', $prestasi->id) }}" class="btn btn-edit">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                Edit
            </a>
            <a href="{{ route('admin.prestasi.index') }}" class="btn btn-back">
                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali
            </a>
        </div>
    </div>

    <div class="detail-grid">

        {{-- ── KOLOM KIRI ── --}}
        <div>
            {{-- Hero foto --}}
            @if($prestasi->foto_path || $prestasi->foto_url)
            <div class="detail-hero">
                <img src="{{ $prestasi->foto_path ? asset('storage/'.$prestasi->foto_path) : $prestasi->foto_url }}"
                    alt="{{ $prestasi->judul }}">
            </div>
            @endif

            {{-- Data Utama --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-header-icon">
                        <svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
                    </div>
                    <p class="card-title">Informasi Prestasi</p>
                </div>
                <div class="card-body">
                    <div style="margin-bottom:16px">
                        <p style="font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--text);margin-bottom:8px">{{ $prestasi->judul }}</p>
                        <div style="display:flex;gap:8px;flex-wrap:wrap">
                            <span class="tingkat-pill tingkat-{{ $prestasi->tingkat }}">{{ ucfirst($prestasi->tingkat) }}</span>
                            @if($prestasi->peringkat)
                                <span style="background:#fef9c3;color:#a16207;border:1px solid #fde68a;padding:2px 10px;border-radius:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700">🏆 {{ $prestasi->peringkat }}</span>
                            @endif
                            @if($prestasi->is_featured)
                                <span class="badge badge-featured"><span class="badge-dot"></span>Unggulan</span>
                            @endif
                        </div>
                    </div>

                    <div class="dl-grid">
                        @if($prestasi->bidang)
                        <div class="dl-item">
                            <p class="dl-label">Bidang</p>
                            <p class="dl-value">{{ $prestasi->bidang }}</p>
                        </div>
                        @endif
                        @if($prestasi->tahun)
                        <div class="dl-item">
                            <p class="dl-label">Tahun</p>
                            <p class="dl-value">{{ $prestasi->tahun }}</p>
                        </div>
                        @endif
                        @if($prestasi->nama_event)
                        <div class="dl-item">
                            <p class="dl-label">Nama Event</p>
                            <p class="dl-value">{{ $prestasi->nama_event }}</p>
                        </div>
                        @endif
                        @if($prestasi->tanggal)
                        <div class="dl-item">
                            <p class="dl-label">Tanggal</p>
                            <p class="dl-value">{{ \Carbon\Carbon::parse($prestasi->tanggal)->isoFormat('D MMMM Y') }}</p>
                        </div>
                        @endif
                        @if($prestasi->penyelenggara)
                        <div class="dl-item dl-full">
                            <p class="dl-label">Penyelenggara</p>
                            <p class="dl-value">{{ $prestasi->penyelenggara }}</p>
                        </div>
                        @endif
                        @if($prestasi->nama_penerima)
                        <div class="dl-item dl-full">
                            <p class="dl-label">Penerima ({{ $prestasi->tipe_penerima ? ucfirst($prestasi->tipe_penerima) : '—' }})</p>
                            <p class="dl-value">{{ $prestasi->nama_penerima }}</p>
                        </div>
                        @endif
                        @if($prestasi->jurusan)
                        <div class="dl-item dl-full">
                            <p class="dl-label">Jurusan</p>
                            <p class="dl-value">{{ $prestasi->jurusan->nama }}</p>
                        </div>
                        @endif
                    </div>

                    @if($prestasi->deskripsi)
                    <div style="margin-top:16px">
                        <p class="dl-label" style="margin-bottom:8px">Deskripsi</p>
                        <div class="deskripsi-box">{{ $prestasi->deskripsi }}</div>
                    </div>
                    @endif

                    @if($prestasi->sertifikat_path)
                    <div style="margin-top:16px">
                        <p class="dl-label" style="margin-bottom:8px">Sertifikat</p>
                        <a href="{{ asset('storage/'.$prestasi->sertifikat_path) }}" target="_blank" class="sertif-link">
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            Lihat / Unduh Sertifikat
                        </a>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- ── KOLOM KANAN ── --}}
        <div>
            {{-- Status --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-header-icon">
                        <svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                    </div>
                    <p class="card-title">Status & Meta</p>
                </div>
                <div class="card-body">
                    <div class="meta-row">
                        <span class="meta-label">Status Publikasi</span>
                        @if($prestasi->is_published)
                            <span class="badge badge-published"><span class="badge-dot"></span>Tayang</span>
                        @else
                            <span class="badge badge-draft"><span class="badge-dot"></span>Draft</span>
                        @endif
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Unggulan</span>
                        <span class="meta-value">{{ $prestasi->is_featured ? '⭐ Ya' : 'Tidak' }}</span>
                    </div>
                    @if($prestasi->urutan !== null)
                    <div class="meta-row">
                        <span class="meta-label">Urutan</span>
                        <span class="meta-value">{{ $prestasi->urutan }}</span>
                    </div>
                    @endif
                    <div class="meta-row">
                        <span class="meta-label">Dibuat</span>
                        <span class="meta-value">{{ $prestasi->created_at->isoFormat('D MMM Y') }}</span>
                    </div>
                    <div class="meta-row">
                        <span class="meta-label">Diperbarui</span>
                        <span class="meta-value">{{ $prestasi->updated_at->isoFormat('D MMM Y') }}</span>
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="card">
                <div class="card-header">
                    <div class="card-header-icon">
                        <svg width="15" height="15" fill="none" stroke="#1f63db" stroke-width="1.8" viewBox="0 0 24 24"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"/></svg>
                    </div>
                    <p class="card-title">Aksi Cepat</p>
                </div>
                <div class="card-body" style="display:flex;flex-direction:column;gap:10px">
                    {{-- Toggle publish --}}
                    <form action="{{ route('admin.prestasi.toggle', $prestasi->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn {{ $prestasi->is_published ? 'btn-toggle-on' : 'btn-toggle-off' }}" style="width:100%;justify-content:center">
                            @if($prestasi->is_published)
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
                                Nonaktifkan
                            @else
                                <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                                Aktifkan
                            @endif
                        </button>
                    </form>

                    {{-- Toggle featured --}}
                    <form action="{{ route('admin.prestasi.featured', $prestasi->id) }}" method="POST">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn {{ $prestasi->is_featured ? 'btn-toggle-on' : 'btn-back' }}" style="width:100%;justify-content:center">
                            @if($prestasi->is_featured)
                                ⭐ Hapus dari Unggulan
                            @else
                                ☆ Jadikan Unggulan
                            @endif
                        </button>
                    </form>

                    <a href="{{ route('admin.prestasi.edit', $prestasi->id) }}" class="btn btn-edit" style="justify-content:center">
                        <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                        Edit Prestasi
                    </a>

                    <div class="action-danger-zone">
                        <p class="action-danger-title">⚠ Zona Bahaya</p>
                        <form action="{{ route('admin.prestasi.destroy', $prestasi->id) }}" method="POST" id="delForm">
                            @csrf @method('DELETE')
                            <button type="button" class="btn btn-del" style="width:100%;justify-content:center"
                                onclick="confirmDelete()">
                                <svg width="13" height="13" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
                                Hapus Permanen
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
    Swal.fire({icon:'success',title:'Berhasil!',text:@json(session('success')),timer:2500,showConfirmButton:false,toast:true,position:'top-end'});
    @endif

    function confirmDelete() {
        Swal.fire({
            title:'Hapus Prestasi?',
            html:'Data <strong>{{ addslashes($prestasi->judul) }}</strong> akan dihapus permanen bersama foto dan sertifikat.',
            icon:'warning',showCancelButton:true,
            confirmButtonColor:'#dc2626',cancelButtonColor:'#64748b',
            confirmButtonText:'Ya, Hapus!',cancelButtonText:'Batal',
        }).then(r => { if(r.isConfirmed) document.getElementById('delForm').submit(); });
    }
</script>
</x-app-layout>